<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}
// Include config file
require_once "config.php";

$username = $_SESSION["username"];
$client_id = '';

$query = "SELECT client_id FROM client WHERE client_id = '$username'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $client_id = $row['client_id'];
  }
}

if ($username === $client_id) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = mysqli_real_escape_string($con, $_POST['client_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['contact_no']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $update_query = "UPDATE client SET name = '$name', company = '$company', address = '$address', contact_no = '$phone', email = '$email' WHERE client_id = '$client_id'";

    if (mysqli_query($con, $update_query)) {
      // Information updated successfully
      header("Location: clientprofile.php");
    } else {
      // Error updating information
      echo "Error: " . $update_query . "<br>" . mysqli_error($con);
    }
  }
} 
else {
  // Redirect to login page
  header("Location: user-dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="styles.css">
    <title>Profile</title>
</head>
<body>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->           
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="user-dashboard.php">Home</a>
        <a href="clientprofile.php" class="active">Profile</a>
        <a href="menu.php">Menu</a>
        <a href="read-assignedspace-client.php">My Space</a>
        <a href="read-clientreqs-client.php">Requirement</a>
        <a href="bills-client.php">Bills</a> 
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <?php
    $query = "SELECT * FROM client WHERE client_id = '$client_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "
          <div class='profile_form'>
            <form class='form' action='clientprofile.php' method='post'>
              <input type='hidden' name='client_id' value='" . $row['client_id'] . "'>
              <h2>Profile Information</h2>
              <div class='form_group'>
                <label>Name:</label>
                <input type='text' name='name' value='" . $row['name'] . "'>
              </div>
              <div class='form_group'>
              <label>Company:</label>
              <input type='text' name='company' value='" . $row['company'] . "'>
              </div>
              <div class='form_group'>
              <label>Address:</label>
              <input type='text' name='address' value='" . $row['address'] . "'>
              </div>
              <div class='form_group'>
              <label>Contact Number:</label>
              <input type='text' name='contact_no' value='" . $row['contact_no'] . "'>
              </div>
              <div class='form_group'>
                <label>Email:</label>
                <input type='text' name='email' value='" . $row['email'] . "'>
              </div>
              <div class='form_buttons'>
                <button class='save' type='submit'>Save</button>
                <button class='cancel'>
                  <a href='admin-dashboard.php'>Cancel</a>
                </button>
              </div>
            </form>
          </div>";
      }
    }
    ?>
</body>
<script>
    /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
</html>