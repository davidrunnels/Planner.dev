<?php

define("DB_HOST", "127.0.0.1");
define("DB_NAME", "address_db");
define("DB_USER", "codeup");
define("DB_PASS", "codeup");

// Require the file that connects to the database.
require '../db_connect.php';
require '../inc/person.class.php';

// Input into table from form input
if($_POST) {
    $newPerson = new Person($dbc);
    $newPerson->first_name = $_POST['first_name'];
    $newPerson->last_name = $_POST['last_name'];
    $newPerson->phone = $_POST['phone'];
    $newPerson->insert();
}

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $person = new Person($dbc);
    $person->id= $id;
    $person->delete();
}

$stmt = $dbc->query('SELECT p.id, p.first_name, p.last_name, p.phone, a.id as address_id, a.street, a.apt, a.city, a.state, a.zip, a.plus_four, a.person_id
    FROM people as p
    LEFT JOIN address as a 
    ON p.id = a.person_id');

$peoples = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html>
<head>
    <title>Address Book</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>

<body>

    <div class="container">

        <h1>db Address Book</h1>

        <div class="row clearfix">
            <div class="col-md-12 column">

                <table class="table">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th></th>
                        <th></th>
                        <th>Address</th>
                        <th></th>
                        <th></th>
                    </tr>
                
                <?php
                    foreach ($peoples as $key => $person) {
                        echo "<tr>";
                        echo "<td>{$person['first_name']}</td>";
                        echo "<td>{$person['last_name']}</td>";
                        echo "<td>{$person['phone']}</td>";
                        echo "<td><a href=\"edit.person.php?id={$person['person_id']}\" class=\"btn btn-primary\">Edit</a></td>";?>
                        <td><a href="?remove=<?=$person['person_id']?>" class= "btn btn-danger" role= "button" >Delete</a></td>
                     
                <?      echo "<td>{$person['street']} " . "{$person['apt']}<br>" . "{$person['city']} "  .  "{$person['state']} " . "{$person['zip']}" . " {$person['plus_four']}</td>";
                        echo "<td><a href=\"edit.address.php?id={$person['address_id']}\" class=\"btn btn-info\">Edit</a></td>";?>
                        <td><a href="?remove=<?=$person['address_id']?>" class= "btn btn-danger" role= "button" >Delete</a></td>

                <?   }  ?>

                </table>
            </div>
        </div>
    
    <form class ="form-horizontal" method="POST" action="/index.php">
        <h3>Add A Person:</h3>
        <!-- <div class="row clearfix">
            <div class="col-md-12 column"> -->
            <div class="form-group">
                <label for="first_name">Name: </label>
                <input id="first_name" class="form-control" name="first_name" type="text" placeholder="First Name">
            </div>

            <div class="form-group">
                <label for="last_name">Last Name: </label>
                <input id="last_name" class="form-control" name="last_name" type="text" placeholder="Last Name">
            </div>

            <div class="form-group">
                <label for="phone">Phone # </label>
                <input id="phone" class="form-control" name="phone" type="text" placeholder="Phone">
            </div>

            <button type="submit" class="btn btn-default">Add Person</button>
    </form>
    </div>
</body>
</html>