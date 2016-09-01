<?php

/**
 * Database class
 */


class Database	{


	/**
	 * Default class constants
	 *
	 * @var: constant ARR_A
	 * @var: constant ARR_N
	 * @var: constant OBJ
	 */
	const ARR_A = 'ARRAY_A';
	const ARR_N = 'ARRAY_N';
	const OBJ = 'OBJECT';


	/**
	 * Default class variables
	 *
	 * @var: $_conn
	 * @var: $_db
	 * @var: $_query
	 * @var: $_elapsed_time
	 * @var: static $_instance
	 */
	private $_conn, $_db, $_query, $_elapsed_time;
	private static $_instance;


	/**
	 * @override: Default constructor method
	 *
	 * @uses: DBConfig::dbHost()
	 * @uses: DBConfig::dbUser()
	 * @uses: DBConfig::dbPassword()
	 * @uses: DBConfig::dbName()
	 * @uses: mysqli_connect
	 *
	 * @return: class|object
	 */
	public function __construct()	{

		// Register default shutdown method
		register_shutdown_function( array($this, '__destruct') );

		// Connect, select database
		$this->_conn = mysqli_connect(
			DBConfig::dbHost(),
			DBConfig::dbUser(),
			DBConfig::dbPassword(),
			DBConfig::dbName()
		);

		if ( mysqli_connect_errno( $this->_conn ) )
			die('Error connecting the database. ' . mysqli_connect_error());

		return $this;
	}


	/**
	 * Default static method to get/set an active connection
	 *
	 * @param: boolean $link
	 * @return: class instance
	 */
	public static function getConnection( $link = false ) {

		// Setup a new class object if none exists
		if ( !(static::$_instance instanceof Database) )
			static::$_instance = new Database;

		// Return resouce link
		if ( $link )
			return static::getDBLink();

		// Returns instance of class with database handle
		return static::$_instance;
	}


	/**
	 * Get database handle
	 *
	 * @return: resource link|boolean
	 */
	public function getDBLink() {
		if ( static::getConnection()->_conn )
			return static::getConnection()->_conn;
		return false;
	}


	/**
	 * Query the database with given query
	 * Calculates the query elapsed time
	 *
	 * @uses: AppFunction::getTimeInMS()
	 * @uses: mysqli_query()
	 *
	 * @param: string $query
	 *
	 * @return: database resource
	 */
	public function query( $query = '' )	{
		if ( $this->_conn && !empty( $query ) )	{

			// Start timing the query
			$start = AppFunction::getTimeInMS();

			// Run query
			$this->_query = @mysqli_query( $this->_conn, $query );

			// End timing the query
			$end = AppFunction::getTimeInMS();

			// Calculate elapsed time
			$elapsedTime = ($end - $start);

			// Set elapsed time
			$this->setElapsedTime($elapsedTime);

			// Die if error and return
			if ( mysqli_errno( $this->_conn ) )
				die('Unable to query the database. ' . mysqli_error($this->_conn));

			return $this->_query;
		}
	}


	/**
	 * Fetch result from given resource
	 *
	 * @param: resource $result
	 * @param: class|object $class
	 * @param: string|constant $type
	 *
	 * @uses: mysqli_fetch_array
	 * @uses: mysqli_fetch_object
	 *
	 * @return: resource|class|object|array
	 */
	public function fetch( $result, $class = null, $type = null )	{

		// Set default type
		if ( $type === null )
			$type = static::OBJ;

		// Fetch the results based on given output type
		if ( $type == static::ARR_A )
			return @mysqli_fetch_array( $result, MYSQLI_ASSOC );

		elseif ( $type == static::ARR_N )
			return @mysqli_fetch_array( $result, MYSQLI_NUM );

		else
			return $class ? @mysqli_fetch_object( $result, $class ) : @mysqli_fetch_object( $result );
	}


	/**
	 * Fetch all results from given resource
	 *
	 * @param: resource $result
	 * @param: class|object $class
	 * @param: string|constant $type
	 *
	 * @return: resource|class|object|array
	 */
	public function fetchAll( $result, $class = null, $type = null )	{

		$results = array();

		if ( $type === null )
			$type = static::OBJ;

		if ( ! $result ) {
			$results = false;
		}
		else {
			while ( $row = $this->fetch($result, $class, $type) ) {
				$results[] = $row;
			}
		}

		return $results;
	}


	/**
	 * Number of rows for given resource using
	 *
	 * @uses: mysqli_num_rows
	 * @return: integer
	 */
	public function num_rows( $result )	{
		return @mysqli_num_rows( $result );
	}


	/**
	 * Number of affected rows
	 *
	 * @uses: mysqli_affected_rows
	 * @return: integer
	 */
	public function affected_rows()	{
		if ( $this->_conn )
			return @mysqli_affected_rows( $this->_conn );
	}


	/**
	 * Free database resource
	 *
	 * @uses: mysqli_free_results
	 * @return: boolean
	 */
	public function free_results( $result )	{
		if ( !empty($result) )
			return @mysqli_free_result( $result );
	}


	/**
	 * Last insert record ID
	 *
	 * @uses: mysqli_insert_id
	 * @return: integer
	 */
	public function insert_id()	{
		return @mysqli_insert_id( $this->_conn );
	}


	/**
	 * Set query elapsed time
	 *
	 * @param: timestamp $time
	 * @param: boolean $toSeconds
	 *
	 * @return: boolean
	 */
	private function setElapsedTime($time, $toSeconds = true) {
		if ( $toSeconds )
			$this->_elapsed_time = ($time / 1000);
		else
			$this->_elapsed_time = $time;

		return true;
	}


	/**
	 * Get query elapsed time
	 *
	 * @return: double
	 */
	public function getElapsedTime() {
		return $this->_elapsed_time;
	}


	/**
	 * Close connection
	 *
	 * @uses: mysqli_close
	 * @return: boolean
	 */
	public function close()	{
		if ( isset( $this->_conn ) )
			return @mysqli_close( $this->_conn );
	}


	/**
	 * @override: Default destruct method
	 *
	 * @return: boolean
	 */
	public function __destruct()	{
		return true;
	}
}