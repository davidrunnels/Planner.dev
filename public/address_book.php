<?php

class AddressDataStore
{
	public $filename = '';

	function readAddressBook()
	{
		$addressBook = [];
         // Code to read file $this->filename
		if (($handle = fopen($this->filename, "r")) !== FALSE) {
			while(!feof($handle)) {
				$row = fgetcsv($handle);

				if (!empty($row)) {
					$addressBook[] = $row;
				}
			}

			fclose($handle);
		}

		return $addressBook;
	}

	function writeAddressBook($addressesArray)
	{
         // Code to write $addressesArray to file $this->filename
		$handle = fopen($this->filename, 'w');
			// var_dump($array);
		foreach ($addressesArray as $fields) {
			fputcsv($handle, $fields);
		}
		fclose($handle);
	}

		// $fileName = 'address_book.csv';


	function sanitize($array) {
		foreach ($array as $key => $value) {
        		$array[$key] = htmlspecialchars(strip_tags($value));  // Overwrite each value.
        	}
        	return $array;
        }
    }

    $address_book = new AddressDataStore();

    $address_book->filename = "address_book.csv";

    // var_dump($address_book);

    $addressBook = $address_book->readAddressBook();

	// print_r($addressBook);

	//Add data from form to $addressBook array.

    if (!empty($_POST)) {
	//work with post data
	// var_dump($_POST);
    	$_POST = $address_book->sanitize($_POST);
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
    	$address_book->writeAddressBook($addressBook);
    }

// var_dump($addressBook);

    if(isset($_GET['remove'])) {
    	$key = $_GET['remove'];
    	unset($addressBook[$key]);
    	$addressBook = array_values($addressBook);
    	$address_book->writeAddressBook($addressBook);
    }
    ?>

    <html>
    <head>
    	<title>Address Book</title>
    	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <!-- Font Awesome -->

      <link rel="stylesheet" href="/font-awesome-4.2.0/css/font-awesome.min.css">

      <!-- Padding -->
     <!-- <style type="text/css">
      body { 
        padding-top: 70px; 
      }
  </style> -->

  <link rel="stylesheet" href="/css/sites.css">
</head>	
<body>

	<!-- <ul>
	<? foreach ($addressBook as $key => $value): ?>
	<li><?= $value; ?><a href="/address_book.php?remove=<?= $key; ?>">X</a></li>
	<? endforeach; ?>

</ul> -->
<div>
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
			<td><a href="/address_book.php?remove=<?= $key; ?>"><i class="fa fa-check"></i></a></td>
		</tr>
	<? endforeach; ?>
</tr>
</table>
</div>

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


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

