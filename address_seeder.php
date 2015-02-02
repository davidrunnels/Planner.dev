<?php

define('DB_HOST', '127.0.0.1');

define('DB_NAME', 'address_db');

define('DB_USER', 'codeup');

define('DB_PASS', 'codeup');

require_once('db_connect.php');

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$addresses = [
	[
		'street' => '1600 Pennsylvania Avenue NW',
		'apt' => NULL,
		'city' => 'Washington',
		'state' => 'DC',
		'zip' => '20500',
		'plus_four' => NULL,
		'person_id' => '1'
	], [
		'street' => 'P.O. Box 1527',
		'apt' => NULL,
		'city' => 'Long Island City',
		'state' => 'NY',
		'zip' => '11101',
		'plus_four' => NULL,
		'person_id' => '2'
	], [
		'street' => 'P.O. Box 29901',
		'apt' => NULL,
		'city' => 'San Francisco',
		'state' => 'CA',
		'zip' => '94129',
		'plus_four' => '0901',
		'person_id' => '3'
	]

];

$stmt = $dbc->prepare('INSERT INTO address (street, apt, city, state, zip, plus_four, person_id)
	VALUES (:street, :apt, :city, :state, :zip, :plus_four, :person_id)');

foreach ($addresses as $address) {
    $stmt->bindValue(':street', $address['street'], PDO::PARAM_STR);
    $stmt->bindValue(':apt',  $address['apt'], PDO::PARAM_STR);
    $stmt->bindValue(':city', $address['city'], PDO::PARAM_STR);
    $stmt->bindValue(':state', $address['state'], PDO::PARAM_STR);
    $stmt->bindValue(':zip', $address['zip'], PDO::PARAM_STR);
    $stmt->bindValue(':plus_four', $address['plus_four'], PDO::PARAM_STR);
    $stmt->bindValue(':person_id', $address['person_id'], PDO::PARAM_STR);

    $stmt->execute();

}
