<?php

define('DB_HOST', '127.0.0.1');

define('DB_NAME', 'planner');

define('DB_USER', 'codeup');

define('DB_PASS', 'codeup');

require_once('db_connect.php');

$query = 'CREATE TABLE todo_list(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	item VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
)';

$dbc->exec($query);
