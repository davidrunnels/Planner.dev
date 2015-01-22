<?php

require_once '../inc/address_data_store.php';

$error_message = [];
$fields = [];

	$address_object = new AddressDataStore("address_book.csv");

	$addressBook = $address_object->read();

	if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) 
	{
		// Set the destination directory for uploads
		$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

		// Grab the filename from the uploaded file by using basename
		$filename = basename($_FILES['file1']['name']);


		if (substr($filename, -3) == "csv") {

			// Create the saved filename using the file's original name and our upload directory
			$savedFilename = $uploadDir . $filename;

			// Move the file from the temp location to our uploads directory
			move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

			$address_new_file = new AddressDataStore($savedFilename);

			$address_array_uploads = $address_object->read();
			$addressBook = array_merge($addressBook, $address_array_uploads);
			$address_object->write($addressBook);

		} else {
			throw new Exception("File is not a csv file.");
		}
	}

	//Add data from form to $addressBook array.

	if (!empty($_POST)) {
		
		$sanitizedArray = $address_object->sanitize($_POST);

		try {
			foreach ($sanitizedArray as $key => $value) {
				$validString = $address_object->validateInput($value);
				$validAddressArray[] = $validString;
			}
			$addressBook[] = $validAddressArray;
			$address_object->write($addressBook);
		} catch (Exception $e){
				$error_message = $e->getMessage();
				echo "<p> $error_message </p>";
		} 
	}

		// 	if (!empty($value)) {
		// 		
		// 	} else {

		// 		try {

		// 			$address_object->validateAddressbookInput($value);
		// 		}
				
		// 		catch (InvalidAddressbookInputException $e) {
		// 			echo $e->getMessage();
		// 			throw new Exception("<p>You must complete {$key} field.</p>");
		// 		}
		// 	}
		// }

	if(isset($_GET['remove'])) {
		$key = $_GET['remove'];
		unset($addressBook[$key]);
		$addressBook = array_values($addressBook);
		$address_object->write($addressBook);
	}

	// unset($address_object);
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

	<div class="container">

	<!-- <ul>
	<? foreach ($addressBook as $key => $value): ?>
	<li><?= $value; ?><a href="/address_book.php?remove=<?= $key; ?>">X</a></li>
	<? endforeach; ?>

</ul> -->
<div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<table>
				<tr>
					<th><h4>Name</h4></th>
					<th><h4>Address</h4></th>
					<th><h4>City</h4></th>
					<th><h4>State</h4></th>
					<th><h4>Zip</h4></th>
					<th><h4>Phone</h4></th>
				</tr>
				<!-- Start working with php, and echoing out the data from $addressBook -->
				<tr>
					
					<? foreach ($addressBook as $key => $fields) : ?>

					<tr>
						<? foreach ($fields as $value) : ?>
						<td><?= $value; ?></td>

					<? endforeach; ?>
					<td><a class="remove" href="/address_book.php?remove=<?= $key; ?>">
						<i class="fa fa-minus-square-o"></i>
						<i class="fa fa-minus-square"></i>
						</a>
					</td>

					</tr>
				<? endforeach; ?>

				</tr>
			</table>
		</div>
	</div>
</div>

<div class="row clearfix">
	<div class="col-md-4 column">
		<h4>Add items to the Address Book</h4>
		<form method="POST" action="address_book.php">
			<div class="form-group">
				<label for="name">Name<br></label>
				<input class="form-control" id="name" name="name" type="text">
			</div>
			<div class="form-group">
				<label for="street">Address<br></label>
				<input class="form-control" id="street" name="street" type="text">
			</div>
			<div class="form-group">
				<label for="city">City<br></label>
				<input class="form-control" id="city" name="city" type="text">
			</div>
			<div class="form-group">
				<label for="state">State<br></label>
				<input class="form-control" id="state" name="state" type="text">
			</div>
			<div class="form-group">
				<label for="zip">Zip Code<br></label>
				<input class="form-control" id="zip" name="zip" type="text">
			</div>
			<div class="form-group">
				<label for="phone">Phone Number<br></label>
				<input class="form-control" id="phone" name="phone" type="text">
			</div>

			<div class="form-group">
				<input type="submit" value="add">
			</div>
		</form>
	</div>
	<div class="col-md-3 column">
		<form method="POST" enctype="multipart/form-data" action="/address_book.php">
			<p>
				<label for="file1"><h4>Upload a file: </h4><br></label>
				<input type="file" id="file1" name="file1">
			</p>
			<p>
				<input type="submit" value="Upload">
			</p>
		</form>
	</div>
</div>
<div class="col-md-3 column">
</div>
</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

