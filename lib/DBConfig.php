<?php

/**
 * Database configuration
 */

class DBConfig {


	/**
	 * Define default static variables
	 *
	 * @var: static $_dbType
	 * @var: static $_dbHost
	 * @var: static $_dbName
	 * @var: static $_dbUser
	 * @var: static $_dbPassword
	 * @var: static $_dbTablePrefix
	 * @var: static $_dbTables
	 */
	protected static $_dbType, $_dbHost, $_dbName,
					 $_dbUser, $_dbPassword,
					 $_dbTablePrefix, $_dbTables;


	/**
	 * @override: Default __construct method
	 */
	public function __construct() {

		static::$_dbType = null;
		static::$_dbHost = null;
		static::$_dbName = null;
		static::$_dbUser = null;
		static::$_dbPassword = null;
		static::$_dbTablePrefix = null;
		static::$_dbTables = array();

		// Register default shutdown function
		register_shutdown_function( array($this, '__destruct') );
	}


	/**
	 * Set database type
	 *
	 * @param: string $type
	 * @return: boolean
	 */
	public static function setType( $type ) {
		static::$_dbType = $type;
		return true;
	}


	/**
	 * Set database host
	 *
	 * @param: string $host
	 * @return: boolean
	 */
	public static function setHost( $host ) {
		static::$_dbHost = $host;
		return true;
	}


	/**
	 * Set database name
	 *
	 * @param: string $name
	 * @return: boolean
	 */
	public static function setName( $name ) {
		static::$_dbName = $name;
		return true;
	}


	/**
	 * Set database user
	 *
	 * @param: string $user
	 * @return: boolean
	 */
	public static function setUser( $user ) {
		static::$_dbUser = $user;
		return true;
	}


	/**
	 * Set database password
	 *
	 * @param: string $password
	 * @return: boolean
	 */
	public static function setPassword( $password ) {
		static::$_dbPassword = $password;
		return true;
	}


	/**
	 * Set database tables prefix
	 *
	 * @param: string $prefix
	 * @return: boolean
	 */
	public static function setTablePrefix( $prefix ) {
		static::$_dbTablePrefix = $prefix;
		return true;
	}


	/**
	 * Set database tables
	 *
	 * @param: string|array $table
	 * @return: boolean
	 */
	public static function setTables( $table ) {

		if ( is_array($table) ) {
			foreach ($table as $tbl) {
				$key = strtolower($tbl) . 'Table';
				if ( !( isset(static::$_dbTables[$key]) ) ) {
					static::$_dbTables[$key] = static::dbTablePrefix() . $tbl;
				}
			}
		}

		if ( is_scalar($table) ) {
			$key = strtolower($table) . 'Table';
			if ( !( isset(static::$_dbTables[$key]) ) ) {
				static::$_dbTables[$key] = static::dbTablePrefix() . $table;
			}
		}

		return true;
	}


	/**
	 * Get database type
	 *
	 * @return: string
	 */
	public static function dbType() {
		return static::$_dbType;
	}


	/**
	 * Get database host
	 *
	 * @return: string
	 */
	public static function dbHost() {
		return static::$_dbHost;
	}


	/**
	 * Get database name
	 *
	 * @return: string
	 */
	public static function dbName() {
		return static::$_dbName;
	}


	/**
	 * Get database user
	 *
	 * @return: string
	 */
	public static function dbUser() {
		return static::$_dbUser;
	}


	/**
	 * Get database password
	 *
	 * @return: string
	 */
	public static function dbPassword() {
		return static::$_dbPassword;
	}


	/**
	 * Get database tables prefix
	 *
	 * @return: string
	 */
	public static function dbTablePrefix() {
		return static::$_dbTablePrefix;
	}


	/**
	 * Get specific database table
	 *
	 * @param: string $table
	 * @return: string
	 * @throws: Exception
	 */
	public static function dbTable( $table ) {
		$key = strtolower($table) . 'Table';
		if ( !isset(static::$_dbTables[$key]) )
			throw new Exception('Invalid table name.');

		return static::$_dbTables[$key];
	}


	/**
	 * Get database tables
	 *
	 * @return: array
	 */
	public static function dbTables() {
		return static::$_dbTables;
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
