<?php

/**
 * Application configurations
 */


/**
 * Setup development|production environment
 * @param: false|true / 0|1
 * @return: Loads various modules based on enabled environment type
 *
 */
AppConfig::setEnv(false);


/**
 * Setup app configuration and metadata
 *
 * To add a custom configuration append
 * an array key/value pair to following array
 *
 * To get the config, use AppConfig::get('CONFIG_YOU_REQUIRE');
 *
 */
AppConfig::set( array(

		/**
		 * Client's complete official name i.e. Dorothy Perkins
		 */
		'app_client' => 'Thomas Cook',


		/**
		 * Folder/Directory name for client on server i.e. dorothyperkins
		 */
		'app_client_dir' => 'thomascook',


		/**
		 * Folder/Directory name of this application
		 */
		'app_dir' => 'dubai_parks',


		/**
		 * Facebook application title
		 * By default it appears in social sharing options
		 */
		'app_title' => 'Dubai Parks',


		/** Facebook application image file name
		 * File must exist in 'assets/images/' directory of
		 * this template. This image will appear in Facebook
		 * share dialog and in Open Graph tags
		 */
		'app_image' => 'bg-ring.jpg',


		/**
		 * Facebook application description
		 */
		'app_description' => 'Crack the code to win tickets to Amazing.',

		/**
		 * Terms & Conditions URL
		 */
		'app_terms' => 'terms-conditions.php',


		/**
		 * Privacy Policy URL
		 */
		'app_privacy' => 'http://www.thomascook.com/privacy-policy/',


		/**
		 * Set a day when this app or certain methods shall be available
		 * only. Lowercase and complete day name only i.e. friday
		 *
		 * Use AppFunction::isToday( AppConfig::get('app_day') )
		 * for custom/conditional use
		 *
		 * @internal: In development environment, above statment
		 * always return true.
		 */
		'app_day' => ''
	)
);


/**
 * Setup Facebook configuration
 */
AppConfig::set( array(

		/**
		 * Facebook application type
		 * True for Canvas app, False for page tab app
		 */
		'facebook_canvas_app' => true,


		/**
		 * Facebook application NameSpace
		 */
		'facebook_namespace' => 'ticket-to-amazing',


		/**
		 * Facebook application ID
		 */
		'facebook_app_id' => '1761519824086921',


		/**
		 * Facebook application secret
		 */
		'facebook_app_secret' => '22f16300aa6ca63f1185c58a400f9b30',


		/**
		 * Client Facebook page name
		 */
		'facebook_page' => 'thomascook',


		/**
		 * Page name for developer's test page
		 */
		'facebook_test_page' => 'UnitedTestPage',


		/**
		 * Facebook invite message
		 */
		'facebook_invite_message' => 'I’ve cracked the code to amazing! Try yourself for a chance to WIN! link',


		/**
		 * Facebook share message
		 */
		'facebook_share_message' => 'I’ve cracked the code to amazing. Enter to WIN > link'
	)
);


/**
 * Setup Twitter configuration
 */
AppConfig::set( array(


		/**
		 * Tweet text
		 */
		'twitter_tweet' => 'I’ve cracked the code to amazing. Enter to WIN! link #amazingiscoming',


		/**
		 * Client's Twitter handle WITHOUT '@' i.e. ThomasCookUK
		 */
		'twitter_handle' => 'ThomasCookUK',


		/**
		 * Twitter app API Key
		 */
		'twitter_api_key' => '',


		/**
		 * Twitter app API Secret
		 */
		'twitter_api_secret' => ''
	)
);


/**
 * Setup Instagram configuration
 */
AppConfig::set( array(


		/**
		 * Instagram username
		 */
		'instagram_username' => '',


		/**
		 * Instagram client ID
		 */
		'instagram_client_id' => '',


		/**
		 * Instagram client secret
		 */
		'instagram_client_secret' => '',


		/**
		 * Instagram redirect URL
		 */
		'instagram_redirect_url' => ''
	)
);


/**
 * Setup default URLs
 */
AppConfig::set( array(

		/**
		 * Developers local server address (No trailing slash!)
		 */
		'developer_server' => 'http://localhost/',


		/**
		 * Default production server (No trailing slash!)
		 */
		'production_server' => 'https://united-agency-server.co.uk',


		/**
		 * Default domain for FB apps (No trailing slash!)
		 */
		'fbapps' => 'https://apps.facebook.com',


		/**
		 * Set app absolute path
		 */
		'distbase' => DISTABSPATH,


		/**
		 * Set app vendor lib path
		 */
		'vendor' => VENDORPATH,


		/**
		 * Get app rel path
		 */
		'base' => RELPATH,


		/**
		 * Get app dist rel path
		 */
		'dist' => DISTPATH,


		/**
		 * Get app assets rel path
		 */
		'assets' => ASSETSPATH,


		/**
		 * Set app loging targets
		 */
		'log' => array(
			'dev' => LOGPATH . '/error-log-dev.log',
			'dist' => LOGPATH . '/error-log-dist.log'
		)

	)
);


/**
 * Setup server defaults
 */
AppConfig::set( array(

		/**
		 * Set domain based on env and $_SERVER['SERVER_NAME']
		 */
		'domain' => strpos(AppConfig::get('production_server'), $_SERVER['SERVER_NAME']) ? AppConfig::get('production_server') : AppConfig::get('developer_server')

	)
);


/**
 * Set current environment
 */
AppConfig::set( array(
		'is_dev' => (! AppConfig::getEnv() || AppConfig::get('domain') === AppConfig::get('developer_server'))
	)
);


/**
 * Set default output HTTP headers
 */
AppConfig::setHeaders( array(
		'HTTP/1.1 200 OK' => '',
		'Content-Type' => 'text/html',
		'X-Content-Type-Options' => 'nosniff',
		'X-XSS-Protection' => true,
		'Cache-control' => 'no-store,no-cache,private,no-transform,must-revalidate',
		'Cache-control' => 'post-check=0, pre-check=0, false',
		'Pragma' => 'no-cache',
		'X-Powered-By' => 'App Framework v4.0.0',
		'X-UA-Compatible' => 'IE=edge,chrome=1',
		'P3P' => 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"'
	)
);

$black_logos = false;