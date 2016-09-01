<?php

/**
 * Application core functions
 */


/**
 * Setup timezone
 */
AppFunction::setTimeZone( 'Europe/London' );


/**
 * Setup error display and loging
 */
AppLog::setupErrorLoging();



/**
 * Clean any incoming data
 */
$_GET = AppFunction::clean_data( $_GET );
$_POST = AppFunction::clean_data( $_POST );
$_REQUEST = AppFunction::clean_data( $_REQUEST );
$_COOKIE = AppFunction::clean_data( $_COOKIE );


/**
 * Parse defined headers
 */
AppFunction::parseHeaders();
