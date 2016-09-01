<?php

/**
 * Load default modules for app
 */



/**
 * Load lib with autoload
 */
require LIBPATH . '/autoload.php';


/**
 * Load lib with autoload
 */
if ( file_exists( VENDORPATH . '/autoload.php' ) )
	require VENDORPATH . '/autoload.php';


/**
 * Load app configuration
 */
require CONFIGPATH . '/app-config.php';


/**
 * Load app functions
 */
require INCPATH . '/app-functions.php';


/**
 * Load app database configuration
 */
require INCPATH . '/app-db-settings.php';


/**
 * Load custom defined functions
 */
if ( file_exists( ABSPATH . '/functions.php' ) )
	require ABSPATH . '/functions.php';
