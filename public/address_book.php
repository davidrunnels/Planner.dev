<?php

$fileName = 'address_book.csv';

function savefile($filename, $array) {
	$handle = fopen('address_book.csv', 'w');
	// var_dump($array);
	foreach ($array as $fields) {
		fputcsv($handle, $fields);
	}
	fclose($handle);
	// return $array;
}

function sanitize($array) {
    foreach ($array as $key => $value) {
        $array[$key] = htmlspecialchars(strip_tags($value));  // Overwrite each value.
    }
    return $array;
}

$filename = 'address_book.csv';

$handle = fopen($filename, 'r');

$addressBook = [];

while(!feof($handle)) {
	$row = fgetcsv($handle);

	if (!empty($row)) {
		$addressBook[] = $row;
	}
}

fclose($handle);

// print_r($addressBook);


// $addressBook = [
// ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500', '8887776666'],
// ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101', '8887776666'],
// ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901', '8887776666']
// ];

// Check for $_POST Request.


// Check for empty field


	//Add data from form to $addressBook array.

if (!empty($_POST)) {
	//work with post data
	// var_dump($_POST);
	$_POST = sanitize($_POST);
	foreach ($_POST as $key => $value) {
		if (!empty($value)) {
			$fields[] = $value;
		} else {
			echo ("<p>You must complete {$key} field.</p>");
		}
	}

	// $fields = [ $_POST['name'], $_POST['street'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['phone'] ];
	// var_dump($fields);

	// add to array

	array_push($addressBook, $fields);
	// var_dump($addressBook);
 	// save to file
	savefile($fileName, $addressBook);
}

// var_dump($addressBook);

if(isset($_GET['remove'])) {
	$key = $_GET['remove'];
	unset($addressBook[$key]);
	$addressBook = array_values($addressBook);
	savefile('address_book.csv', $addressBook);
}
?>

<html>
<head>
	<title>Address Book</title>
</head>	
<body>

	<!-- <ul>
	<? foreach ($addressBook as $key => $value): ?>
	<li><?= $value; ?><a href="/address_book.php?remove=<?= $key; ?>">X</a></li>
	<? endforeach; ?>

</ul> -->

<table>
	<tr>
		<th>Name</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Phone</th>
	</tr>
	<!-- Start working with php, and echoing out the data from $addressBook -->
	<tr>
		<? foreach ($addressBook as $key => $fields) : ?>
		<tr>
			<? foreach ($fields as $value) : ?>
			<td><?= $value; ?></td>
			
		<? endforeach; ?>
		<td><a href="/address_book.php?remove=<?= $key; ?>">X</a></td>
	</tr>
<? endforeach; ?>
</tr>
</table>

<h4>Add items to the Address Book</h4>
<form method="POST" action="address_book.php">
	<p>
		<label for="name">Name</label>
		<input id="name" name="name" type="text">
	</p>
	<p>
		<label for="street">Address</label>
		<input id="street" name="street" type="text">
	</p>
	<p>
		<label for="city">City</label>
		<input id="city" name="city" type="text">
	</p>
	<p>
		<label for="state">State</label>
		<input id="state" name="state" type="text">
	</p>
	<p>
		<label for="zip">Zip Code</label>
		<input id="zip" name="zip" type="text">
		<p>
			<label for="phone">Phone Number</label>
			<input id="phone" name="phone" type="text">
		</p>
	</p>
	<p>
		<input type="submit" value="add">
	</p>
</form>

</body>
</html>



