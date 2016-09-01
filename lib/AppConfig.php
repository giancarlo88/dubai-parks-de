<?php

/**
 * App configuration class
 */

class AppConfig {


	/**
	 * Define default static variables
	 *
	 * @var: protected static $_env
	 * @var: protected static $_headers
	 * @var: protected static $_app
	 */
	protected static $_env, $_headers, $_app;


	/**
	 * @override: Default __construct method
	 */
	public function __construct() {

		static::$_env = false;
		static::$_headers = array();
		static::$_app = array();

		// Register default shutdown function
		register_shutdown_function( array($this, '__destruct') );
	}


	/**
	 * Set environment
	 *
	 * @param: boolean $env
	 */
	public static function setEnv( $env = false ) {
		static::$_env = $env;
	}


	/**
	 * Set HTTP headers
	 *
	 * @param: array $headers
	 */
	public static function setHeaders( $headers = array() ) {
		if ( is_array($headers) ) {
			foreach ($headers as $header => $value) {
				static::$_headers[$header] = $value;
			}
		}
	}


	/**
	 * Set multiple configurations for app
	 *
	 * @param: array $configs
	 */
	public static function set( $configs = array() ) {
		if ( is_array($configs) ) {
			foreach ($configs as $config => $value) {
				static::$_app[$config] = $value;
			}
		}
	}


	/**
	 * Get environment
	 *
	 * @return: boolean
	 */
	public static function getEnv() {
		return static::$_env;
	}


	/**
	 * Get specific header
	 * Parameter value is case sensitive
	 *
	 * @param: string $header
	 * @return: string
	 * @throws: Exception
	 */
	public static function getHeader( $header ) {
		if ( ! isset(static::$_headers[$header]) )
			throw new Exception('No such HTTP header found.');

		return static::$_headers[$header];
	}


	/**
	 * Get headers
	 *
	 * @return array
	 */
	public static function getHeaders() {
		return static::$_headers;
	}


	/**
	 * Get specific app config
	 *
	 * @param: string $config
	 * @return: string|array|boolean
	 */
	public static function get( $config ) {
		if ( isset(static::$_app[$config]) )
			return static::$_app[$config];
		return false;
	}


	/**
	 * Get app configs
	 *
	 * @return: array
	 */
	public static function getAll() {
		return static::$_app;
	}


	/**
	 * @override: Default __destruct method
	 *
	 * @return: boolean
	 */
	public function __destruct() {
		return true;
	}

}
