<?php
// Initialize the session
session_start();
// Include config file
require_once "config.php";

$username = $_SESSION["username"];

$query = "SELECT username FROM admin_login WHERE username = '$username'";
$result = mysqli_query($con, $query);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $username = mysqli_real_escape_string($con, $_POST['username']);

  $update_query = "CALL UpdateAdminLogin('$fullname', '$email', '$username')";

  if (mysqli_query($con, $update_query)) {
    // Information updated successfully
    header("Location: adminprofile.php");
  } else {
    // Error updating information
    echo "Error: " . $update_query . "<br>" . mysqli_error($con);
  }
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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <title>Profile</title>
</head>
<body>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->           
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="admin-dashboard.php">Home</a>
        <a href="adminprofile.php" class="active">Profile</a>
        <a href="client-accounts.php">Accounts</a>
        <a href="client-list.php">Clients</a>
        <a href="student-list.php">Students</a>
        <a href="assignedspace-index.php">Assigned</a>
        <a href="clientreqs-index.php">Requirements</a>
        <a href="feature-index.php">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <?php
    $query = "SELECT * FROM admin_login WHERE username = '$username'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "
          <div class='profile_form'>
            <form class='form' action='adminprofile.php' method='post'>
              <input type='hidden' name='id' value='" . $row['id'] . "'>
              <h2>Profile Information</h2>
              <div class='form_group'>
                <label>Name:</label>
                <input type='text' name='fullname' value='" . $row['fullname'] . "'>
              </div>
              <div class='form_group'>
                <label>Email:</label>
                <input type='text' name='email' value='" . $row['email'] . "'>
              </div>
              <div class='form_group'>
                <label>Username:</label>
                <input type='text' name='username' value='" . $row['username'] . "'>
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
    else {
  // Redirect to login page
  header("Location: admin-dashboard.php");
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