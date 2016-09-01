<?php

/**
 * Invite by Facebook Model
 */

require '../config.php';
AppConfig::setHeaders( array('Content-Type' => 'application/json') );

$response = array();
$response['error']['code'] = 400;
$response['error']['message'] = 'Invalid request.';

if ( isset($_POST['request']) && $_POST['request'] === 'getInvitedFriends' ) {
	$uid = isset($_POST['uid']) && $_POST['uid'] ? (int) $_POST['uid'] : 0;

	if ( $uid ) {
		$config = array(
			'limit' => '500',
			'conditions' => array(
				'user_id' => $uid
			)
		);

		$invitedUsers = array();
		if ( $userInvites = Invite::getAll( $config ) ) {
			foreach ($userInvites['data'] as $userInvite) {
				if ( $userInvite->invited_email !== '' ) {
					$invitedUsers['email'][] = $userInvite->invited_email;					
				}
				else {
					$invitedUsers['fb'][] = $userInvite->invited_id;
				}
			}

			$response = array();
			$response['code'] = 200;
			$response['data'] = $invitedUsers;
		}

	}
}

if ( isset($_POST['request']) && $_POST['request'] === 'inviteFbFriends' ) {
	$fbid = isset($_POST['fbid']) && $_POST['fbid'] ? $_POST['fbid'] : false;
	$uid = isset($_POST['uid']) && $_POST['uid'] ? (int) $_POST['uid'] : 0;
	$invites = isset($_POST['invites']) && $_POST['invites'] ? $_POST['invites'] : array();

	if ( $uid && count($invites)  ) {
		$howManyInvited = 0;

		if ( $isMember = User::getById($uid) ) {
			foreach ($invites['to'] as $invited_id) {
				$full_request_id = $invites['request'] . '_' . $invited_id;
				$config = array(
					'limit' => 1,
					'conditions' => array(
						'full_request_id' => $full_request_id
					)
				);

				if ( ! Invite::getAll($config) ) {
					$invite = new Invite;
					$invite->request_id = $invites['request'];
					$invite->full_request_id = $full_request_id;
					$invite->invited_id = $invited_id;
					$invite->user_id = $uid;
					$invite->save();

					$howManyInvited++;
				}
			}

			if ( $howManyInvited ) {
				$response = array();
				$response['code'] = 201;
				$response['message'] = $howManyInvited . ($howManyInvited === 1 ? ' friend ' : ' friends ') . 'successfully invited.';
			}
		}
	}
}

header('Content-Type: application/json');
echo json_encode($response);

