<?php

/**
 * User Entries Model
 */

$uid = isset($_GET['uid']) && $_GET['uid'] ? (int) $_GET['uid'] : 0;


if ( $uid ) {
	$config = array(
		'conditions' => array(
			'user_id' => $uid
		)
	);

	if ( $userInvites = Invite::getAll( $config ) ) {
		$userTotalInvites = $userInvites['total'];
		$userTotalEntries = floor($userTotalInvites / 3);
	}
}
