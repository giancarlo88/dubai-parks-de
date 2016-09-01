<?php

/**
 * Invite class
 */

class Invite extends BaseApp	{

	/**
	 * Set default constants
	 *
	 * @var: const TABLE
	 */

	const TABLE = 'invite';

	/**
	 * Default __construct method
	 *
	 * @override: Parent class __construct
	 */
	public function __construct()	{
		return parent::__construct( array(
				'request_id' => '',
				'full_request_id' => '',
				'invited_id' => '',
				'invited_email' => '',
				'user_id' => 0,
				'created_at' => time(),
				'updated_at' => time()
			)
		);
	}



	/**
	 * Get data by record ID
	 *
	 * @uses: Database::getConnection()
	 * @param: integer|string $id
	 * @return: object|array
	 */
	public static function getById( $id )	{

		// Setup query
		$query = sprintf("SELECT
			`id`,
			`request_id`,
			`full_request_id`,
			`invited_id`,
			`invited_email`,
			`user_id`,
			`created_at`,
			`updated_at`
		");

		// Build query
		$completeQuery = static::buildSimpleQuery( $query, $id );

		// Execute query
		$result = Database::getConnection()->query( $completeQuery );

		// Confirm number of rows returned
		if ( Database::getConnection()->num_rows( $result ) )	{

			// Fetch result
			$row = Database::getConnection()->fetch( $result );

			// Fetch data
			$record = static::mapDataToClass( __CLASS__, $row );
		}

		else
			return false;

		// Free results/memory
		Database::getConnection()->free_results($result);

		return $record;
	}


	/**
	 * Get all data with limit and given conditions
	 *
	 * @uses: Database::getConnection()
	 * @param: array $config
	 * @return: mix|array|object
	 */
	public static function getAll( $config = array() )	{

		// Setup empty array for results
		$records = array();

		// Setup query parameters
		$query = sprintf("SELECT
			SQL_CALC_FOUND_ROWS
			`id`,
			`request_id`,
			`full_request_id`,
			`invited_id`,
			`invited_email`,
			`user_id`,
			`created_at`,
			`updated_at`
		");

		// Build query
		$completeQuery = static::buildComplexQuery( $query, $config );

		// Execute query
		$result = Database::getConnection()->query( $completeQuery );

		// Execute secondary query
		$number_of_rows = Database::getConnection()->query('SELECT FOUND_ROWS() AS `rows`');

		// Confirm number of rows returned
		if ( Database::getConnection()->num_rows($result) )	{

			// Fetch and loop through results
			while ( $row = Database::getConnection()->fetch($result) ) {

				// Fetch data
				$record = static::mapDataToClass( __CLASS__, $row );

				// Add data to parent array
				$records['data'][] = $record;

				// Free memory
				unset($record);
			}

			// Fetch total number of rows
			$total = Database::getConnection()->fetch($number_of_rows);

			// Add number of rows found to parent array
			$records['total'] = $total->rows;
		}

		else
			return false;

		// Free results/memory
		Database::getConnection()->free_results($result);
		Database::getConnection()->free_results($number_of_rows);

		return $records;
	}


	/**
	 * INSERT or UPDATE a record
	 * If an ID is given and record exists in Database then that
	 * record will be updated, for selected attributes, otherwise
	 * a new record is created.
	 *
	 * @uses: Database::getConnection()
	 * @return: int|boolean
	 */
	public function save()	{
		if ( $this->id )	{
			$query = sprintf("UPDATE `%s`.`%s` SET ", DBConfig::dbName(), DBConfig::dbTable(static::TABLE));
			$query .= sprintf( " `request_id` = '%s',", $this->request_id );
			$query .= sprintf( " `full_request_id` = '%s',", $this->full_request_id );
			$query .= sprintf( " `invited_id` = '%s',", $this->invited_id );
			$query .= sprintf( " `invited_email` = '%s',", $this->invited_email );
			$query .= sprintf( " `user_id` = %d,", $this->user_id );
			$query .= sprintf( " `updated_at` = %s", 'NOW()' );
			$query .= sprintf( " WHERE `id` = %d", $this->id );

			Database::getConnection()->query( $query );

			return Database::getConnection()->affected_rows();
		}
		else	{
			$query = sprintf( "INSERT INTO `%s`.`%s` ", DBConfig::dbName(), DBConfig::dbTable(static::TABLE) );
			$query .= sprintf( "(`request_id`, `full_request_id`, `invited_id`, `invited_email`, `user_id`, `updated_at`)  VALUES (" );
			$query .= sprintf( "'%s',", $this->request_id );
			$query .= sprintf( "'%s',", $this->full_request_id );
			$query .= sprintf( "'%s',", $this->invited_id );
			$query .= sprintf( "'%s',", $this->invited_email );
			$query .= sprintf( "%d,", $this->user_id );
			$query .= sprintf( "%s", 'NOW()' );
			$query .= sprintf( ")" );

			if ( Database::getConnection()->query( $query ) )	{
				$this->id = Database::getConnection()->insert_id();
				return true;
			}
			else	{
				return false;
			}
		}
	}


	/**
	 * Delete a record by Id
	 *
	 * @uses: Database::getConnection()
	 * @return: int|boolean
	 */
	public function delete() {

		if ( $this->id ) {
			$query = sprintf("DELETE FROM `%s`.`%s`", DBConfig::dbName(), DBConfig::dbTable(static::TABLE));
			$query .= sprintf(" WHERE `id` = %d", AppFunction::sanitize($this->id));

			if ( Database::getConnection()->query( $query ) )
				return Database::getConnection()->affected_rows();
		}

		return false;
	}
}