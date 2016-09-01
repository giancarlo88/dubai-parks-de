<?php

/**
 * App default settings
 */


/**
 * Default includes path
 */
define('INCPATH', ABSPATH . '/inc');


/**
 * Default library/classes path
 */
define('LIBPATH', ABSPATH . '/lib');


/**
 * Custom defined library/classes path
 */
define('VENDORPATH', ABSPATH . '/vendor');


/**
 * Default configuration path
 */
define('CONFIGPATH', ABSPATH . '/config');


/**
 * Default app dist absolute path
 */
define('DISTABSPATH', ABSPATH . '/dist');


/**
 * Default app loging absolute path
 */
define('LOGPATH', ABSPATH . '/log');


/**
 * Set relative path
 */
define('RELPATH', substr(ABSPATH, strlen($_SERVER['DOCUMENT_ROOT'])));


/**
 * Set relative path to dist (production version of app)
 */
define('DISTPATH', RELPATH . '/dist');


/**
 * Set relative path to app assets
 */
define('ASSETSPATH', RELPATH . '/assets');
