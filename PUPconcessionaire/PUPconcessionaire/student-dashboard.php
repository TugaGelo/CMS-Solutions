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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>PUP Concessionaire</title>

</head>
<body>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->           
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="student-dashboard.php" class="active">Home</a>
        <a href="student-menu.php">Menu</a>
        <a href="student-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class="container" style="background-color: white; opacity: 90%;">
    <h4 style="color: maroon; margin-top:20px; padding-top: 20px; text-align: center;">VISION</h4>
      <p class="vision">
        The PUP Graduate School envisions itself as a world-class center of graduate education.
      </p>
    </div>
    <div class="container" style="background-color: white; opacity: 90%;">
    <h4 style="color: maroon; margin-top:20px; padding-top: 20px; text-align: center;">MISSION</h4>
      <p class="mission">
      The Center for Continuing Professional Development is committed on enhancing the individual
      professional's knowledge and skills through integrated industry-based professional development experiences in collaboration with the Professional Regulations Commission, the Commission on Higher Education, and other government agencies; to assure its participants have access to innovative strategies in order to solve problems, create solutions and use best practices; through industry-expert trainors who provide multi-lingual, multi-national and multi-modal training programs for academe, government and private firms.
      </p>
    </div>
    <div class="container">
      <img src="img/puplagoon.jpg" alt="PUP LAGOON" style="width:100%;display:block;padding-bottom:20px;">
    </div>
    <footer style="background-color:white;overflow:hidden;">
      <p style="color:maroon;margin-left:30px;margin-top:10px;"><i class="fa fa-envelope"style="margin-left:5px;margin-right:5px;"></i>puplagoon@gmail.com</p>
      <p style="color:maroon;margin-left:30px;margin-top:10px;"><i class="fa fa-phone" style="margin-left:5px;margin-right:5px;"></i>09123456789</p>
      <p style="color:maroon;margin-left:30px;margin-top:10px;">&copy; 2023 PUP LAGOON STA. MESA</p>
    </footer>
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