<?php

/**
 * Invite by email model
 */

require '../config.php';
AppConfig::setHeaders( array('Content-Type' => 'application/json') );

$response = array();
$response['error']['code'] = 400;
$response['error']['message'] = 'Invalid request.';

if ( isset($_POST['request']) && $_POST['request'] === 'inviteViaEmail' ) {
	$friendEmails = isset($_POST['friendEmails']) && $_POST['friendEmails'] ? $_POST['friendEmails'] : array();
	$passedCabacha = isset($_POST['appCabachaField']) && empty($_POST['appCabachaField']) ? true : false;
	$uid = isset($_POST['uidField']) && $_POST['uidField'] ? (int) $_POST['uidField'] : 0;

	if ( $passedCabacha ) {
		if ( $uid && count($friendEmails) ) {

			$hasUser = User::getById($uid);
			$getUserInvites = Invite::getAll( array(
					'conditions' => array(
						'user_id' => $uid
					)
				)
			);
			$alreadySentInvitesViaEmails = array();
			$invalidEmails = false;
			$alreadyInvited = false;
			$selfInvite = false;

			if ( $getUserInvites ) {
				foreach ($getUserInvites['data'] as $getUserInvite) {
					$alreadySentInvitesViaEmails[] = $getUserInvite->invited_email;
				}
			}


			//	Validate email addresses
			foreach ($friendEmails as $friendEmail) {
				if ( $friendEmail === $hasUser->email ) {
					$selfInvite = true;
					break;
				}
				elseif ( in_array($friendEmail, $alreadySentInvitesViaEmails) ) {
					$alreadyInvited = true;
					break;
				}
				elseif ( !filter_var($friendEmail, FILTER_VALIDATE_EMAIL) || strlen($friendEmail) > 255 ) {
					$invalidEmails = true;
					break;
				}
			}


			if ( $selfInvite || $alreadyInvited || $invalidEmails ) {
				if ( $selfInvite ) {
					$response['error']['code'] = 422;
					$response['error']['message'] = 'You cannot invite yourself.';
				}
				elseif ( $alreadyInvited ) {
					$response['error']['code'] = 422;
					$response['error']['message'] = 'You cannot invite already invited friends.';
				}
				elseif ( $invalidEmails ) {
					$response['error']['code'] = 422;
					$response['error']['message'] = 'Invalid email format.';
				}
				else {
					$response['error']['code'] = 422;
					$response['error']['message'] = 'Invalid email address.';
				}
			}
			else {
				if ( $hasUser ) {
					$emailSubject = "WIN a Thomas Cook Mexico holiday for two and a £250 shopping spree at Outfit";
					$emailHeaders = array(
						'MIME-Version: 1.0',
						'Content-Type: text/html; charset="iso-8895-1"',
						'From: ' . $hasUser->getName() . ' <' . $hasUser->email . '>'
					);

					$mailSuccess = array('successfullySent' => 0);

					$emailTemplate = file_get_contents('./inviteEmail.html');
					$emailTemplate = str_replace('{{app_title}}', AppConfig::get('app_title'), $emailTemplate);
					$emailTemplate = str_replace('{{banner_image}}', AppFunction::getFBCanvasUrl() . 'assets/images/email_banner.jpg', $emailTemplate);
					$emailTemplate = str_replace('{{terms_link}}', AppFunction::getFBCanvasUrl() . AppConfig::get('app_terms'), $emailTemplate);
					$emailTemplate = str_replace('{{privacy_link}}', AppConfig::get('app_privacy'), $emailTemplate);
					$emailTemplate = str_replace('{{app_link}}', AppFunction::getAppUrl() . '?ref=TC_HOLIDAY_MEXICO_INVITE_EMAIL', $emailTemplate);
					$emailMsg = str_replace('{{friend_name}}', $hasUser->getName(), $emailTemplate);

					for ( $i = 0; $i < count($friendEmails); $i++ ) {
						if ( mail($friendEmails[$i], $emailSubject, $emailMsg, join("\n", $emailHeaders)) ) {
							$mailSuccess['to'][] = $friendEmails[$i];
							$mailSuccess['status'][] = true;
							$mailSuccess['successfullySent'] += 1;

							$emailConfig = array(
								'conditions' => array(
									'invited_email' => $friendEmails[$i],
									'user_id' => $uid
								)
							);

							$alreadyInvitedViaEmail = Invite::getAll($emailConfig);

							if ( ! $alreadyInvitedViaEmail ) {
								$invite = new Invite;
								$invite->invited_email = $friendEmails[$i];
								$invite->user_id = $uid;
								$invite->save();
								unset($invite);
							}

							// error_log(AppConfig::get('app_title') . ' - Email successfully sent to ' . $friendEmails[$i]);
						}
						else {
							$mailSuccess['to'][] = $friendEmails[$i];
							$mailSuccess['status'][] = false;

							error_log(AppConfig::get('app_title') . ' - Email try was not successful to ' . $friendEmails[$i]);
						}
					}

					if ( $mailSuccess['successfullySent'] > 0 ) {
						$response = array();
						$response['code'] = 201;
						$response['message'] = $mailSuccess['successfullySent'] . ' friends successfully invited.';
					}
					else {
						$response['error']['message'] = 'Error while inviting/sending email(s).';
					}
				}
			}
		}
	}
	else {
		$response['error']['code'] = 403;
		$response['error']['message'] = 'Potential bot detected from IP: ' . AppFunction::getIP();
		$error = 'Potential bot detected from IP: ' . AppFunction::getIP();
	}
}

if ( isset($error) ) error_log($error);

header('Content-Type: application/json');
echo json_encode($response);
