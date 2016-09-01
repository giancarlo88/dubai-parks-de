<?php

/**
 * Default config page
 *
 * To setup application config, use
 * config files in '/config' directory instead
 */


/**
 * Define base path for framework
 */
define('ABSPATH', dirname(__FILE__));


/**
 * Load framework requisites
 */
require ABSPATH . '/inc/app-requisites.php';


/**
 * Load default settings
 */
require ABSPATH . '/inc/app-settings.php';


/**
 * Setup app by loading modules
 */
require INCPATH . '/app-setup.php';