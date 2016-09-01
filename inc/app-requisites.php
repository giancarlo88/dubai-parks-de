<?php

/**
 * Check minimum PHP and CURL requirements
 */

if ( version_compare(PHP_VERSION, '5.3.0', '<') )
	throw new Exception('The app requires PHP version 5.3.0 or higher.');

if ( ! in_array('mysqli', get_loaded_extensions()) )
	throw new Exception('The app requires MySQLi extension installed.');

if ( ! in_array('curl', get_loaded_extensions()) )
	throw new Exception('The app requires CURL extension installed.');