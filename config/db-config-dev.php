<?php

/**
 * Developer Database configuration
 */


/**
 * Database host
 */
DBConfig::setHost('localhost');


/**
 * Database name
 */
DBConfig::setName('dubai_parks2');


/**
 * Database username
 */
DBConfig::setUser('root');


/**
 * Database password
 */
DBConfig::setPassword('');


/**
 * Database table prefix
 */
DBConfig::setTablePrefix('dubai_parks_de_');


/**
 * Database tables
 */
DBConfig::setTables( array('user', 'invite') );
