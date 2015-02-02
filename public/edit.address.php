<?php

define("DB_HOST", "127.0.0.1");
define("DB_NAME", "address_db");
define("DB_USER", "codeup");
define("DB_PASS", "codeup");

// Require the file that connects to the database.
require '../db_connect.php';
require '../inc/address.class.php';

if($_POST) {
  $newAddress = new Address($dbc);
  $newAddress->street = $_POST['street'];
  $newAddress->apt = $_POST['apt'];
  $newAddress->city = $_POST['city'];
  $newAddress->state = $_POST['state'];
  $newAddress->zip = $_POST['zip'];
  $newAddress->plus_four = $_POST['plus_four'];
  $newAddress->id = $_POST['id'];
  $newAddress->update();
}


if (isset($_GET['id'])) {
  $a_id = $_GET['id'];
  $address = Address::find($a_id, $dbc);
} else {
    // var_dump($p_id);
  $a_id = $_POST['id'];
  $address = Address::find($a_id, $dbc);
}


?>

<!DOCTYPE html>

<html>
<head>
  <title>Edit Address</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>

<body>

  <div class="container">

    <h1>db Edit Address</h1>


    <div class="row clearfix">
      <div class="col-md-12 column">

        <table class="table">
          <tr>
            <th>Address</th>
          </tr>
          
          <?php


          echo "<tr>";
                        // echo "<td>{$address['first_name']}</td>";
                        // echo "<td>{$address['last_name']}</td>";
                        // echo "<td>{$address['phone']}</td>";
          echo "<td>{$address->street} " . "{$address->apt}<br>" . "{$address->city}, "  .  "{$address->state} " . "{$address->zip}" . " {$address->plus_four}</td>";

          

          ?>
        </table>
      </div>
    </div>

    


    

    <!-- Add Address Form -->
    <form class="form-horizontal" method="POST" action="/edit.address.php">
      <fieldset>

        <!-- Form Name -->
        <legend>Edit Address</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="street">Street</label>  
          <div class="col-md-6">
            <input id="street" name="street" type="text" value="<?= $address->street ?>" placeholder="street" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="apt">Apt.</label>  
          <div class="col-md-2">
            <input id="apt" name="apt" type="text" value="<?= $address->apt ?>" placeholder="apt" class="form-control input-md">
            
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="city">City</label>  
          <div class="col-md-5">
            <input id="city" name="city" type="text" value="<?= $address->city ?>" placeholder="city" class="form-control input-md" required="">
            
          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="state">State</label>
          <div class="col-md-2">
            <select id="state" name="state" value="<?= $address->state ?>" class="form-control">
              <option value="AL">AL</option>
              <option value="AK">AK</option>
              <option value="AZ">AZ</option>
              <option value="AR">AR</option>
              <option value="CA">CA</option>
              <option value="CO">CO</option>
              <option value="CT">CT</option>
              <option value="DE">DE</option>
              <option value="FL">FL</option>
              <option value="GA">GA</option>
              <option value="HI">HI</option>
              <option value="ID">ID</option>
              <option value="IL">IL</option>
              <option value="IN">IN</option>
              <option value="IA">IA</option>
              <option value="KS">KS</option>
              <option value="KY">KY</option>
              <option value="LA">LA</option>
              <option value="ME">ME</option>
              <option value="MD">MD</option>
              <option value="MA">MA</option>
              <option value="MI">MI</option>
              <option value="MN">MN</option>
              <option value="MS">MS</option>
              <option value="MO">MO</option>
              <option value="MT">MT</option>
              <option value="NE">NE</option>
              <option value="NV">NV</option>
              <option value="NH">NH</option>
              <option value="NJ">NJ</option>
              <option value="NM">NM</option>
              <option value="NY">NY</option>
              <option value="NC">NC</option>
              <option value="ND">ND</option>
              <option value="OH">OH</option>
              <option value="OK">OK</option>
              <option value="OR">OR</option>
              <option value="PA">PA</option>
              <option value="RI">RI</option>
              <option value="SC">SC</option>
              <option value="SD">SD</option>
              <option value="TN">TN</option>
              <option value="TX">TX</option>
              <option value="UT">UT</option>
              <option value="VT">VT</option>
              <option value="VA">VA</option>
              <option value="WA">WA</option>
              <option value="WV">WV</option>
              <option value="WI">WI</option>
              <option value="WY">WY</option>
            </select>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="zip">Zip Code</label>  
          <div class="col-md-4">
            <input id="zip" name="zip" type="text" value="<?= $address->zip ?>" placeholder="Zip Code" class="form-control input-sm" required="">
            
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="plus_four">plus 4</label>  
          <div class="col-md-4">
            <input id="plus_four" name="plus_four" type="text" value="<?= $address->plus_four ?>" placeholder="plus four" class="form-control input-md">
            
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="id">id</label>  
          <div class="col-md-2">
            <input id="id" name="id" type="text" value="<?= $address->id ?>" placeholder="id" class="form-control input-md">   
          </div>
        </div>

      </fieldset>
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