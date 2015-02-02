<?php

define('DB_HOST', '127.0.0.1');

define('DB_NAME', 'address_db');

define('DB_USER', 'codeup');

define('DB_PASS', 'codeup');

require_once('db_connect.php');

$query = 'CREATE TABLE people(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(31) NOT NULL,
	last_name VARCHAR(63) NULL,
	phone CHAR(10) NULL,
	PRIMARY KEY (id)
)';

$dbc->exec($query);
