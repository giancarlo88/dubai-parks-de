<?php

/**
 * Invite page
 */
$thisPage = "register";
require './config.php';
require './template/header.php';
// require './template/navigation.php';

$uid = isset($_GET['uid']) && $_GET['uid'] ? (int) $_GET['uid'] : 0;

?>

<div class="app-wrapper invite">
	<div class="container">
		<div class="gis-heading">
			<h1></h1>
		</div>

		<div class="gis-container">

			<p>&nbsp;</p>

			<h4 class="text-center">Now invite your friends!</h4>

			<p>&nbsp;</p>
			<p>&nbsp;</p>

			<p class="text-center"><strong>You never know, if they win<br/> they might just take you with them!</strong></p>

			<p>&nbsp;</p>
			<p>&nbsp;</p>

			<p class="text-center" id="inviteBtns">
				<button id="inviteViaFacebook" class="btn  btn-gis btn-fix btn-facebook"
					data-uid="<?php echo $uid; ?>"
					data-title="<?php echo AppConfig::get('app_title'); ?>"
					data-message="<?php echo AppConfig::get('facebook_invite_message'); ?>"><i class="fa fa-facebook-square"></i> Invite via Facebook</button>

				<button id="inviteViaEmail" class="btn btn-gis btn-fix btn-primary"
					data-uid="<?php echo $uid; ?>"><i class="fa fa-envelope"></i> Invite via Email</button>
			</p>

			<div class="text-center form-horizontal" id="inviteViaEmailForm">
				<div class="form-group">
					<div class="col-sm-6 col-sm-offset-3">
						<button id="closeInviteViaEmailForm" type="button" class="btn btn-xs close">&times;</button>
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only">Email Address</label>
					<div class="col-sm-6 col-sm-offset-3">
						<input type="text" class="form-control friend-email" name="friendEmail[]" placeholder="Email address">
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only">Email Address</label>
					<div class="col-sm-6 col-sm-offset-3">
						<input type="text" class="form-control friend-email" name="friendEmail[]" placeholder="Email address">
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only">Email Address</label>
					<div class="col-sm-6 col-sm-offset-3">
						<input type="text" class="form-control friend-email" name="friendEmail[]" placeholder="Email address">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<input type="text" class="app-cabacha" id="appCabachaField" name="cabacha_<?php echo sha1(time()); ?>" value="">
						<input type="hidden" name="cabacha" id="cabachaField" value="cabacha_<?php echo sha1(time()); ?>">
						<input type="hidden" name="uid" id="uidField" value="<?php echo $uid; ?>">
						<button type="submit" id="inviteFriendSubmit" class="btn btn-primary btn-gis btn-fix">INVITE FRIENDS</button>
					</div>
				</div>
			</div>

			<p>&nbsp;</p>

			<p class="text-center">
				<a href="scratch.php?uid=<?php echo $uid; ?>" class="btn-skip">SKIP</a>
			</p>

			<br/>

			<?php include_once("./template/voucher_html.php"); ?>
			<div class="container-tc-priv">
				<div class="col-xs-6 text-left tc-pp">
					<a target="_blank" href="<?php echo AppConfig::get('app_terms'); ?>">Terms &amp; Conditions</a>
				</div>

				<div class="col-xs-6 text-right tc-pp">
					<a target="_blank" href="<?php echo AppConfig::get('app_privacy'); ?>">Privacy Policy</a>
				</div>
			</div>

		</div>


<?php

require './template/footer.php';

?>