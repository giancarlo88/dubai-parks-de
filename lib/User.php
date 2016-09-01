<?php

/**
 * User class
 */

class User extends BaseApp	{

	/**
	 * Set default constants
	 *
	 * @var: const TABLE
	 */

	const TABLE = 'user';

	/**
	 * Default __construct method
	 *
	 * @override: Parent class __construct
	 */
	public function __construct()	{
		return parent::__construct( array(
				'fbid' => '',
				'first_name' => '',
				'last_name' => '',
				'email' => '',
				'phone' => '',
				'tc_subscription' => false,
				'dubaiparks_subscription' => false,
				'from_mobile' => false,
				'from_tablet' => false,
				'browser' => $_SERVER['HTTP_USER_AGENT'],
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'created_at' => time(),
				'updated_at' => time()
			)
		);
	}


	/**
	 * Get concatenated name
	 */
	public function getName() {
		return $this->first_name . ' ' . $this->last_name;
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
			`fbid`,
			`first_name`,
			`last_name`,
			`email`,
			`phone`,
			CAST(`tc_subscription` AS UNSIGNED) AS `tc_subscription`,
			CAST(`dubaiparks_subscription` AS UNSIGNED) AS `dubaiparks_subscription`,
			`from_mobile`,
			`from_tablet`,
			`browser`,
			`ip_address`,
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
			$user = static::mapDataToClass( __CLASS__, $row );
		}

		else
			return false;

		// Free results/memory
		Database::getConnection()->free_results($result);

		return $user;
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
		$users = array();

		// Setup query parameters
		$query = sprintf("SELECT
			SQL_CALC_FOUND_ROWS
			`id`,
			`fbid`,
			`first_name`,
			`last_name`,
			`email`,
			`phone`,
			CAST(`tc_subscription` AS UNSIGNED) AS `tc_subscription`,
			CAST(`dubaiparks_subscription` AS UNSIGNED) AS `dubaiparks_subscription`,
			`from_mobile`,
			`from_tablet`,
			`browser`,
			`ip_address`,
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
				$user = static::mapDataToClass( __CLASS__, $row );

				// Add data to parent array
				$users['data'][] = $user;

				// Free memory
				unset($user);
			}

			// Fetch total number of rows
			$total = Database::getConnection()->fetch($number_of_rows);

			// Add number of rows found to parent array
			$users['total'] = $total->rows;
		}

		else
			return false;

		// Free results/memory
		Database::getConnection()->free_results($result);
		Database::getConnection()->free_results($number_of_rows);

		return $users;
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
			$query .= sprintf( " `fbid` = '%s',", AppFunction::sanitize($this->fbid) );
			$query .= sprintf( " `first_name` = '%s',", AppFunction::sanitize($this->first_name) );
			$query .= sprintf( " `last_name` = '%s',", AppFunction::sanitize($this->last_name) );
			$query .= sprintf( " `email` = '%s',", AppFunction::sanitize($this->email) );
			$query .= sprintf( " `phone` = '%s',", AppFunction::sanitize($this->phone) );
			$query .= sprintf( " `tc_subscription` = %d,", $this->tc_subscription );
			$query .= sprintf( " `dubaiparks_subscription` = %d,", $this->dubaiparks_subscription );
			$query .= sprintf( " `from_mobile` = %d,", $this->from_mobile );
			$query .= sprintf( " `from_tablet` = %d,", $this->from_tablet );
			$query .= sprintf( " `browser` = '%s',", AppFunction::sanitize($this->browser) );
			$query .= sprintf( " `ip_address` = '%s',", AppFunction::sanitize($this->ip_address) );
			$query .= sprintf( " `updated_at` = %s", 'NOW()' );
			$query .= sprintf( " WHERE `id` = %d", $this->id );

			Database::getConnection()->query( $query );

			return Database::getConnection()->affected_rows();
		}
		else	{
			$query = sprintf( "INSERT INTO `%s`.`%s` ", DBConfig::dbName(), DBConfig::dbTable(static::TABLE) );
			$query .= sprintf( "(`fbid`, `first_name`, `last_name`, `email`, `phone`, `tc_subscription`, `dubaiparks_subscription`, `from_mobile`, `from_tablet`, `browser`, `ip_address`, `updated_at`)  VALUES (" );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->fbid) );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->first_name) );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->last_name) );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->email) );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->phone) );
			$query .= sprintf( "%d,", $this->tc_subscription );
			$query .= sprintf( "%d,", $this->dubaiparks_subscription );
			$query .= sprintf( "%d,", $this->from_mobile );
			$query .= sprintf( "%d,", $this->from_tablet );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->browser) );
			$query .= sprintf( "'%s',", AppFunction::sanitize($this->ip_address) );
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