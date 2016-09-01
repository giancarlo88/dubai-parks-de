<?php

/**
 * Database configuration load settings
 */


/**
 * Load database configuration file based on environment
 */
if ( AppConfig::get('domain') !== AppConfig::get('production_server') && file_exists(CONFIGPATH . '/db-config-dev.php') )
	require CONFIGPATH . '/db-config-dev.php';

elseif ( file_exists(CONFIGPATH . '/db-config.php') )
	require CONFIGPATH . '/db-config.php';

else
	die( 'Database configuration file is missing.' );
