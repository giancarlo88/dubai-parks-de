<?php

/**
 * Base App class
 * This app describes basic methods for child classes
 */


class BaseApp	{


	/**
	 * Define default variables
	 *
	 * @var: int $id
	 * @var: array $fields
	 */
	protected $id;
	protected $fields;


	/**
	 * @override: Default __contruct method
	 *
	 * @param: array $fields
	 */
	public function __construct( $fields = array() )	{
		$this->id = null;
		$this->fields = $fields;

		// @override; Define default shutdown function
		register_shutdown_function( array($this, '__destruct') );
	}


	/**
	 * @override: Default magic __get method
	 *
	 * @param: string $field
	 *
	 * @return: string|array|object
	 */
	public function __get( $field )	{
		if ( $field == 'id' )	{
			return $this->id;
		}	else	{
			return $this->fields[$field];
		}
	}


	/**
	 * @override: Default magic __set method
	 *
	 * @param: string $field
	 * @param: mix $value
	 *
	 * @return: class instance
	 */
	public function __set( $field, $value )	{
		if ( array_key_exists( $field, $this->fields ) )	{
			$this->fields[$field] = $value;
		}
		return $this;
	}


	/**
	 * Build simple query with given ID
	 *
	 * @param: string $query
	 * @param: int $id
	 *
	 * @return: string|boolean
	 */
	public static function buildSimpleQuery( $query, $id ) {
		if ( ! $query || ! $id )
			return false;

		$query .= sprintf(" FROM `%s`.`%s`", DBConfig::dbName(), DBConfig::dbTable( static::TABLE ));
		$query .= sprintf(" WHERE `id` = %d", AppFunction::sanitize( $id ));

		return $query;
	}


	/**
	 * Build query to add given conditions
	 *
	 * @param: string $query
	 * @param: array $config
	 *
	 * @return: string|boolean
	 */
	public static function buildComplexQuery( $query, $config ) {

		if ( ! isset($config['offset']) )
			$config['offset'] = 0;

		if ( ! isset($config['limit']) )
			$config['limit'] = 25;

		if ( ! isset($config['conditions']) )
			$config['conditions'] = array();

		if ( ! isset($config['order_by']) )
			$config['order_by'] = 'created_at';

		if ( ! isset($config['type']) )
			$config['type'] = 'AND';

		if ( ! $query )
			return false;

		if ( !isset($config['type']) || ($config['type'] !== 'AND' && $config['type'] !== 'OR' && $config['type'] !== 'LIKE') )
			return false;

		$query .= sprintf(" FROM `%s`.`%s`", DBConfig::dbName(), DBConfig::dbTable( static::TABLE ));

		if ( isset($config['conditions']) && count($config['conditions']) > 0 ) {
			$query .= sprintf(" WHERE ");
			$remainingCondition = count($config['conditions']);
			$conditions = $config['conditions'];
			foreach ($conditions as $key => $value) {
				if ( $config['type'] === 'LIKE' ) {
					$query .= sprintf("`%s` LIKE '%%%s%%'", AppFunction::sanitize($key), AppFunction::sanitize($value));
					$remainingCondition--;

					if ( $remainingCondition ) {
						$query .= sprintf(" %s ", 'OR');
					}
				}
				else {
					$query .= sprintf("`%s` = '%s'", AppFunction::sanitize($key), AppFunction::sanitize($value));
					$remainingCondition--;

					if ( $remainingCondition ) {
						$query .= sprintf(" %s ", $config['type']);
					}
				}
			}
		}
		else {
			$query .= sprintf(" WHERE 1");
		}

		//Set ORDER BY
		if ( isset($config['order_by']) && $config['order_by'] )
			$query .= sprintf(" ORDER BY `%s` DESC", $config['order_by']);
		else
			$query .= sprintf(" ORDER BY `%s` DESC", 'id');

		// Set LIMIT
		if ( isset($config['offset']) && isset($config['offset']) && $config['offset'] && $config['offset'] )
			$query .= sprintf(" LIMIT %d, %d", $config['offset'], $config['limit']);
		else
			$query .= sprintf(" LIMIT %d, %d", 0, 25);

		return $query;
	}


	/**
	 * Map result rows to given object
	 *
	 * @param: Class|Object $class
	 * @param: Object $row
	 *
	 * @return: Class|Object
	 */
	public static function mapDataToClass( $class, $row ) {

		if ( ! class_exists($class) || ! $row )
			return false;

		// Set new instance of class
		$obj = new $class;

		// Map row data to class instance
		foreach ($row as $key => $value) {
			$obj->{$key} = $value;
		}

		return $obj;
	}


	/**
	 * @override: Default __destruct method
	 *
	 * @return: boolean
	 */
	public function __destruct()	{
		return true;
	}

}