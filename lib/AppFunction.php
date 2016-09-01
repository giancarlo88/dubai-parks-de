<?php

/**
 * App functions class
 */

class AppFunction {


	/**
	 * @override: Default __construct method
	 */
	public function __construct() {

		// Register default shutdown function
		register_shutdown_function( array($this, '__destruct') );
	}


	/**
	 * Set timezone
	 *
	 * @param: string $timezone
	 * @return: boolean
	 */
	public static function setTimeZone( $timezone = 'Europe/London' ) {
		date_default_timezone_set( $timezone );
		return true;
	}


	/**
	 * Get timezone
	 *
	 * @return: string
	 */
	public static function getTimeZone() {
		return date_default_timezone_get();
	}


	/**
	 * Confirms given day to current day
	 *
	 * @param: string $day
	 * @return: boolean
	 */
	public static function isToday( $day = '' ) {
		$now = time();
		$dateNow = getdate($now);
		$dayToday = strtolower($dateNow['weekday']);

		if ( AppConfig::get('is_dev') ) {
			$day = strtolower( gmdate('l', $now) );
		}

		return ($dayToday === $day);
	}


	/**
	 * Parse Facebook signed request
	 *
	 * @param: array|object $request
	 * @return: array|boolean
	 */
	public static function parsePageSignedRequest( $request ) {

		if ( isset($request) && $request ) {

			$encoded_sig = null;
			$payload = null;

			list( $encoded_sig, $payload ) = explode( '.', $request, 2 );
			$sig = base64_decode( strtr( $encoded_sig, '-_', '+/') );
			$data = json_decode( base64_decode( strtr( $payload, '-_', '+/' ), true ) );

			return $data;
		}

		return false;
	}


	/**
	 * Get current facebook page based on env
	 *
	 * @return: string
	 */
	public static function getFacebookPage() {
		if ( !AppConfig::getEnv() ) {
			AppConfig::set( array(
					'facebook_page' => AppConfig::get('facebook_test_page')
					)
				);
		}

		return AppConfig::get('facebook_page');
	}


	/**
	 * Get Facebook page tab URL
	 *
	 * @return string
	 */
	public static function getFBPageTabUrl() {
		return 'https://facebook.com/' . static::getFacebookPage() . '/app_' . AppConfig::get('facebook_app_id');
	}


	/**
	 * Get Facebook canvas URL
	 *
	 * @return string
	 */
	public static function getFBCanvasUrl() {
		return AppConfig::get('production_server') . '/' . AppConfig::get('app_client_dir') . '/' . AppConfig::get('app_dir') . '/';
	}


	/**
	 * Get app URL
	 *
	 * @return string
	 */
	public static function getAppUrl() {
		return AppConfig::get('fbapps') . '/' . AppConfig::get('facebook_namespace');
	}


	/**
	 * Get Twitter URL
	 *
	 * @return string
	 */
	public static function getTwitterUrl() {
		return AppConfig::get('twitter_url') ? AppConfig::get('twitter_url') : static::getAppUrl();
	}


	/**
	 * Get app featured image URL
	 *
	 * @return string
	 */
	public static function getFeaturedImage() {
		if ( ! AppConfig::get('app_image') ) return '';
		$basePath = ( AppConfig::get('domain') !== AppConfig::get('production_server') ) ? AppConfig::get('developer_server') : AppConfig::get('production_server');
		return $basePath . AppConfig::get('assets') . '/images/' . AppConfig::get('app_image');
	}


	/**
	 * Sanitize method to clean data
	 *
	 * @param: string $value
	 * @param: boolean $trim
	 *
	 * @return string
	 */
	public static function sanitize( $value = '', $trim = true ) {

		// Trim the value for any extra spaces
		if ( $trim )
			$value = trim( $value );

		$_magic_quotes_gpc = get_magic_quotes_gpc();
		$_real_escape_quotes = function_exists('mysqli_real_escape_string');

		if ( $_magic_quotes_gpc )
			$value = stripslashes($value);

		return ( ($_real_escape_quotes) ? @mysqli_real_escape_string( Database::getConnection(true), $value ) : addslashes( $value ) );
	}


	/**
	 * Extended form of PHP native htmlentities
	 *
	 * @param: string|array $value
	 * @return: string|array
	 */
	public static function legacyentities( $value ) {
		if ( version_compare(PHP_VERSION, '5.4.0', '<') ) {
			if (is_array($value))
				return array_map( array($this,'legacyentities'), $value );
			return htmlentities($value, ENT_COMPAT, 'UTF-8');
		}
		if (is_array($value))
			return array_map( array($this,'legacyentities'), $value );
		return htmlentities($value);
	}


	/**
	 * Clean any system passed data
	 *
	 * @param string|array $variable
	 * @param boolean $top
	 *
	 * @return string|array
	 */
	public static function clean_data( $variable, $top = true ) {
		if ( get_magic_quotes_gpc() )	{
			$clean_data = array();
			foreach( $variable as $key => $value )	{
				$key = ($top) ? $key : stripslashes($key);
				$clean_data[$key] = (is_array($value)) ?
					static::clean_data($value, false) :
						stripslashes($value);
			}
			return $clean_data;
		}

		return $variable;
	}


	/**
	 * Get IP address for current client
	 * From: http://goo.gl/K6WgWh
	 *
	 * @return: string
	 */
	public static function getIP() {
		$ipHolders = array(
				'HTTP_CLIENT_IP',
				'HTTP_X_FORWARDED_FOR',
				'HTTP_X_FORWARDED',
				'HTTP_X_CLUSTER_CLIENT_IP',
				'HTTP_FORWARDED_FOR',
				'HTTP_FORWARDED',
				'REMOTE_ADDR'
			);

	    foreach ( $ipHolders as $key){
	        if ( array_key_exists($key, $_SERVER) === true ) {
	            foreach ( explode(',', $_SERVER[$key] ) as $ip ) {
	                $ip = trim($ip);

	                if ( false !== filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) ) {
	                    return $ip;
	                }
	            }
	        }
	    }

	    return '';
	}


	/**
	 * Parse and setup headers
	 *
	 * @return boolean
	 */
	public static function parseHeaders() {
		$headers = AppConfig::getHeaders();

		if ( ! $headers )
			return;

		foreach ( $headers as $header => $value ) {
			if ( false === empty($value) )
				header( "$header: $value" );
			header( "$header" );
		}

		return true;
	}


	/**
	 * Get time in microseconds
	 *
	 * @return double
	 */
	public static function getTimeInMS() {
		list($msec, $sec) = explode(' ', microtime());
		return floor($sec / 1000) + $msec;
	}



	/**
	 * @override: Default __destruct method
	 *
	 * @return boolean
	 */
	public function __destruct() {
		return true;
	}

}