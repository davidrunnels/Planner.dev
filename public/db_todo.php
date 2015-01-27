<?php

require_once('../inc/filestore.php');

$filename = 'data/todo.txt';

$todo_object = new Filestore($filename);

define('DB_HOST', '127.0.0.1');

define('DB_NAME', 'planner');

define('DB_USER', 'codeup');

define('DB_PASS', 'codeup');

require_once('../db_connect.php');

// add item from user input
if(!empty($_POST)){
		// Verify there were uploaded files and no errors


	$stmt = $dbc->prepare('INSERT INTO todo_list (item)
		VALUES (:item)');

	$stmt->bindValue(':item', $_POST['item'], PDO::PARAM_STR);

	$stmt->execute();

}

// upload a file to the to do list
if(!empty($_FILES)){

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

			foreach ($todo_array_uploads as $value) {

				$stmt = $dbc->prepare('INSERT INTO todo_list (item)
					VALUES (:item)');

				$stmt->bindValue(':item', $_POST['file_upload'], PDO::PARAM_STR);

				$stmt->execute();
			}
			

		}	else 	{
			throw new Exception("File is not a text file.");
		}

	}
}



// remove an item from the list
if(isset($_GET['remove'])) {
	$key = $_GET['remove'];
	$query = "DELETE 
	FROM todo_list 
	WHERE id = :id";
	$stmt = $dbc->prepare($query);
	$stmt->bindValue(':id', $key, PDO::PARAM_INT);
	$stmt->execute();
}

try {

    // Find out how many items are in the table
	$total = $dbc->query('SELECT COUNT(*)
		FROM todo_list')->fetchColumn();

    // How many items to list per page
	$limit = 10;

    // How many pages will there be
	$pages = ceil($total / $limit);

    // What page are we currently on?
	$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
			),
		)));

    // Calculate the offset for the query
	$offset = ($page - 1)  * $limit;

    // Some information to display to the user
	$start = $offset + 1;
	$end = min(($offset + $limit), $total);

    // The "back" link
	$prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
	$nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
	echo '<div class="pagination" id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

    // Prepare the paged query
	$stmt = $dbc->prepare('SELECT * 
		FROM todo_list  
		LIMIT :limit 
		OFFSET :offset
		');

    // Bind the query params
	$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

    // Do we have any results?
	if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$iterator = new IteratorIterator($stmt);

	}

} catch (Exception $e) {
	echo '<p>', $e->getMessage(), '</p>';
}

$dbcResult = $dbc->prepare("SELECT * FROM todo_list");
$dbcResult->execute();
$array_todo = $dbcResult->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>To Do List</title>

	<!-- Bootstrap -->
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Font Awesome -->

    <link rel="stylesheet" href="/font-awesome-4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
	<div class="container-fluid">
		<h1><u>To Do List</u></h1>


		<!-- // Display the results -->
		<ul>
			<? foreach ($iterator as $value): ?>
			<li>
				<?= $value['item']?>
				<a href="/db_todo.php?remove=<?= $value['id']?>">Remove</a>
			</li>
			<?endforeach?>
		</ul>

		<div id="form_container">

			<h3>Update To Do Items:</h3>
			<form method="POST" action="db_todo.php">
				<div class="form_description">
					<p>Add a to do item.</p>
				</div>                      
				<ul >

					<li id="add_item" >
						<label class="description" for="item">Item to add:</label>
						<div class="form-group">
							<input id="item" name="item" class="element text medium" type="text" maxlength="255" value="" placeholder="ex: take a nap"/> 
						</div> 
					</li> 


					<li class="buttons">
						<input type="submit" name="form_id" value="add">

						<form method="POST" enctype="multipart/form-data" action="/db_todo.php">
							<p>
								<label for="file_upload">Upload a file: <br></label>
								<input type="file" id="file_upload" name="file_upload">
							</p>
							<p>
								<input type="submit" value="upload">
							</p>
						</form>

					</li>
				</ul>
			</form> 
			<div id="footer">

			</div>
		</div>


		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/jquery.min.js"></script>
	</div>

</body>
</html>