<?php

$todo_array = [];
$key = [];
$removeItem = [];

function savefile($filename, $array) {
	$handle = fopen($filename, 'w');
	foreach($array as $item) {
		fwrite($handle, $item . PHP_EOL);
	}
	fclose($handle);
	$saveMessage = "Save Successful.";
	echo "<script type='text/javascript'>console.log('$saveMessage');</script>";
}   

function openfile($filename){
	$contentsarray = [];
	if(filesize($filename) != 0) {
		$handle = fopen($filename, 'r');
		$contents = trim(fread($handle, filesize($filename)));
		$contentsarray = explode("\n", $contents);
		fclose($handle);
	} 
	return $contentsarray;

}

$todo_array = openfile('data/todo.txt');

if(isset($_POST['addItem'])) {
	$todo_array[] = htmlentities(strip_tags($_POST['addItem']));
	savefile('data/todo.txt', $todo_array);

}

if(isset($_GET['remove'])) {
	$key = $_GET['remove'];
	unset($todo_array[$key]);
	$todo_array = array_values($todo_array);
	savefile('data/todo.txt', $todo_array);
}

?>

<?php


// Verify there were uploaded files and no errors

if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
    // Set the destination directory for uploads
	$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
	$filename = basename($_FILES['file1']['name']);

	if (substr($filename, -3) == "txt") {

    // Create the saved filename using the file's original name and our upload directory
		$savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
		move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

		$todo_array_uploads = openfile('data/todo.txt');
		$todo_array = array_merge($todo_array, $todo_array_uploads);
		savefile('data/todo.txt', $todo_array);
	}	else {
		echo "File is not a text file.";
	}
}

?>

<!DOCTYPE html>	
<html>

<head>
	<title>TODO List</title>
	<link href='http://fonts.googleapis.com/css?family=Amatic+SC:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/styles.css">
</head>

<body>
	<h2>TODO List</h2>

	<ul>
		<? foreach ($todo_array as $key => $value): ?>
			<li><?= $value; ?><a href="/todo_list.php?remove=<?= $key; ?>">COMPLETE</a></li>
		<? endforeach; ?>

	</ul>

	<!-- // <ul>
	// 	<li>Wake</li>
	// 	<li>Shower</li>
	// 	<li>Dress</li>
	// 	<li>Code</li>
	// </ul> -->



	<h3>Update your TODO list</h3>
	<form method="POST" action="todo_list.php">
		<p>
			<label for="addItem">Add an item: </label>
			<input id="addItem" name="addItem" type="text">
		</p>
		
		<button type="submit" id="submit1">Send</button><br><br>

	</form>

	<form method="POST" enctype="multipart/form-data" action="/todo_list.php">
		<p>
			<label for="file1">Upload a file: <br></label>
			<input type="file" id="file1" name="file1">
		</p>
		<p>
			<input type="submit" value="Upload">
		</p>
	</form>
</body>

</html>