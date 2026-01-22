<?php

// This is the database connection configuration.
return [
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=mysql_db;dbname=' . getenv('DB_NAME') ?: 'testdrive',
	'emulatePrepare' => true,
	'username' => getenv('DB_USERNAME') ?: 'root',
	'password' => getenv('DB_PASSWORD') ?: '',
	'charset' => 'utf8'
];