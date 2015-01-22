  <?php

require_once('../inc/filestore.php');

$filename = 'data/todo.txt';

$todo_object = new Filestore($filename);


$todo_array = [];
$key = [];
$removeItem = [];
$addItem = [];
$error = '';

// used $todo_object to read lines into $todo_array
$todo_array = $todo_object->read($todo_array);

$todo_array = $todo_object->read('data/todo.txt');

try{
	if(isset($_POST['addItem'])) {
		if ($_POST['addItem'] == '') {
			throw new Exception("Error Processing Request. You must input something.");
		} elseif (strlen($_POST['addItem']) > 240) {
			throw new Exception("Error Processing Request.  Use 240 characters or less.");
		} elseif (!is_string($_POST['addItem'])) {
			throw new Exception("Error Processing Request.  Must be a string.");
		}
		$todo_array[] = htmlentities(strip_tags($_POST['addItem']));
		$todo_object->write($todo_array);
	}
} catch (UnexpectedTypeException $e) {
    $error = "<p>Error Processing Request. You must input words.</p>";
} catch (Exception $e) {
    $error = "<p>Error Processing Request. You must input something or use 240 characters or less.</p>";
}

echo $error;

if(isset($_GET['remove'])) {
	$key = $_GET['remove'];
	unset($todo_array[$key]);
	$todo_array = array_values($todo_array);
	$todo_object->write($todo_array);
}

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

		$uploaded = new Filestore($savedFilename);

		$todo_array_uploads = $uploaded->read();
		$todo_array = array_merge($todo_array, $todo_array_uploads);
		$todo_object->write($todo_array);
	}	else {
		throw new Exception("File is not a text file.");
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