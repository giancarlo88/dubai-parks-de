<?php

/**
 * App error loging class
 */

class AppLog {


	/**
	 * @override: Default __construct magic method
	 */
	public function __construct() {

		// Register class shutdown method
		register_shutdown_function( array( $this, '__destruct' ) );
	}


	/**
	 * Setup error loging
	 *
	 * @return: boolean
	 */
	public static function setupErrorLoging() {
		static::setErrorReporting();
		static::setLogErrors();
		static::setDisplayErrors( AppConfig::get('is_dev') );
		static::setStartupErrorDisplay( AppConfig::get('is_dev') );

		$logFiles = AppConfig::get('log');

		if ( AppConfig::get('is_dev') )
			$error_log_file = $logFiles['dev'];
		else
			$error_log_file = $logFiles['dist'];

		static::setErrorLog( $error_log_file );

		return true;
	}


	/**
	 * Get error_reporting status
	 *
	 * @return: string
	 */
	public static function getErrorReporting() {
		return ini_get('error_reporting');
	}

	/**
	 * Setup error display for production environment
	 *
	 * @param: constant $err_type
	 * @return: boolean
	 */
	public static function setErrorReporting( $err_type = null ) {
		if ( $err_type === null )
			$err_type = E_ALL | E_STRICT;

		error_reporting( $err_type );
		return true;
	}


	/**
	 * Display error status
	 *
	 * @return: string
	 */
	public static function getDisplayErrors() {
		return ini_get('display_errors');
	}


	/**
	 * Set display errors status
	 *
	 * @param: boolean $environment
	 * @return: boolean
	 */
	public static function setDisplayErrors( $environment = false ) {
		ini_set( 'display_errors', $environment );
		return true;
	}


	/**
	 * Set log errors status
	 *
	 * @param: boolean $value
	 * @return: boolean
	 */
	public static function setLogErrors( $value = true ) {
		ini_set( 'log_errors', $value );
		return true;
	}


	/**
	 * Get log errors status
	 *
	 * @return: boolean
	 */
	public static function getLogErrors() {
		return ini_get( 'log_errors' );
	}


	/**
	 * Set error log file
	 *
	 * @param: string $file
	 * @return: boolean
	 */
	public static function setErrorLog( $file ) {
		ini_set( 'error_log', $file );
		return true;
	}


	/**
	 * Get error log file
	 *
	 * @return: string
	 */
	public static function getErrorLog() {
		return ini_get( 'error_log' );
	}


	/**
	 * Set display startup errors status
	 *
	 * @param: boolean $value
	 * @return: boolean
	 */
	public static function setStartupErrorDisplay( $value = false ) {
		ini_set( 'display_startup_errors', $value );
		return true;
	}


	/**
	 * Get display startup errors status
	 *
	 * @return: boolean
	 */
	public static function getStartupErrorDisplay() {
		return ini_get( 'display_startup_errors' );
	}


	/**
	 * @override: Default __destruct magic method
	 *
	 * @return: boolean
	 */
	public function __destruct() {
		return true;
	}
}
