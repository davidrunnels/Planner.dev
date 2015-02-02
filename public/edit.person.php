<?php

define("DB_HOST", "127.0.0.1");
define("DB_NAME", "address_db");
define("DB_USER", "codeup");
define("DB_PASS", "codeup");

// Require the file that connects to the database.
require '../db_connect.php';
require '../inc/person.class.php';

if($_POST) {
    $newPerson = new Person($dbc);
    $newPerson->first_name = $_POST['first_name'];
    $newPerson->last_name = $_POST['last_name'];
    $newPerson->phone = $_POST['phone'];
    $newPerson->id = $_POST['id'];
    $newPerson->update();
}

if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    $person = Person::find($p_id, $dbc);
} else {
    $p_id = $_POST['id'];
    $person = Person::find($p_id, $dbc);
}
 
?>

<!DOCTYPE html>

<html>
<head>
    <title>Edit Person</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>

<body>

<div class="container">

    <h1>db Edit Person</h1>

    <table class="table">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
        </tr>

<?php   
        echo "<tr>";
        echo "<td>{$person->first_name}</td>";
        echo "<td>{$person->last_name}</td>";
        echo "<td>{$person->phone}</td>";
?>
    </table>
   


<!-- Add Person Form -->
<form class ="form-horizontal" method="POST" action="/edit.person.php">
        <h3>Edit Person:</h3>
        <div class="form-group">
            <label for="first_name">Name: </label>
            <input id="first_name" class="form-control" name="first_name" type="text" value="<?= $person->first_name ?>" placeholder="First Name">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name: </label>
            <input id="last_name" class="form-control" name="last_name" type="text" value="<?= $person->last_name ?>" placeholder="Last Name">
        </div>
        <div class="form-group">
            <label for="phone">Phone # </label>
            <input id="phone" class="form-control" name="phone" type="text" value="<?= $person->phone ?>" placeholder="phone">
        </div>
        <div class="form-group">
<!--             <label for="phone">Phone # </label> -->
            <input type='hidden' id="id" class="form-control" name="id" type="text" value="<?= $person->id ?>" placeholder="id">
        </div>
        
       
        <button type="submit" class="btn btn-default">Submit Changes</button>
    </form>
</div>

<br>

<div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <a href="/index.php" class="btn btn-primary btn-lg active" role="button">Return to Address Book</a>
        </div>
    </div>


</body>
</html>