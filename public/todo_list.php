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
	$todo_array[] = $_POST['addItem'];
	savefile('data/todo.txt', $todo_array);

    }
 
if(isset($_GET['remove'])) {
	$key = $_GET['remove'];
	unset($todo_array[$key]);
	$todo_array = array_values($todo_array);
	savefile('data/todo.txt', $todo_array);
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
<?php foreach ($todo_array as $key => $value) {
    echo "<li>{$value} <a href=\"/todo_list.php?remove={$key}\">COMPLETE</a></li>";

}
?>
</ul>

	<!-- // <ul>
	// 	<li>Wake</li>
	// 	<li>Shower</li>
	// 	<li>Dress</li>
	// 	<li>Code</li>
	// </ul> -->

		<h2>Update your TODO list</h2>
		<form method="POST" action="todo_list.php">
		<p>
			<label for="addItem">Add an item: </label>
			<input id="addItem" name="addItem" type="text">
		</p>
		
		<button type="submit" id="submit1">Send</button><br><br>
	</form>
</body>

</html>