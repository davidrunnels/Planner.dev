<?php

define('DB_HOST', '127.0.0.1');

define('DB_NAME', 'address_db');

define('DB_USER', 'codeup');

define('DB_PASS', 'codeup');

require_once('db_connect.php');

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$people = [
	[
		'first_name' => 'Barack',
		'last_name' => 'Obama',
		'phone' => '8887773333',
	], [
		'first_name' => 'Stan',
		'last_name' => 'Lee',
		'phone' => '8887774444',
	], [
		'first_name' => 'George',
		'last_name' => 'Lucas',
		'phone' => '8887776666'
	]

];

$stmt = $dbc->prepare('INSERT INTO people (first_name, last_name, phone)
	VALUES (:first_name, :last_name, :phone)');

foreach ($people as $person) {
    $stmt->bindValue(':first_name', $person['first_name'], PDO::PARAM_STR);
    $stmt->bindValue(':last_name',  $person['last_name'], PDO::PARAM_STR);
    $stmt->bindValue(':phone', $person['phone'], PDO::PARAM_STR);

    $stmt->execute();

}

