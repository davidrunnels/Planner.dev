<?php

define('DB_HOST', '127.0.0.1');

define('DB_NAME', 'address_db');

define('DB_USER', 'codeup');

define('DB_PASS', 'codeup');

require_once('db_connect.php');

$query = 'CREATE TABLE address(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	street VARCHAR(127) NOT NULL,
	apt VARCHAR(15) NULL,
	city VARCHAR(63) NOT NULL,
	state CHAR(2) NOT NULL,
	zip CHAR(5) NOT NULL,
	plus_four CHAR(4),
	person_id INT(11) UNSIGNED NOT NULL,
	PRIMARY KEY (id)
)';

$dbc->exec($query);
