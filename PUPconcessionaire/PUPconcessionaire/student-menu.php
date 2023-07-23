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

$sql2 = "SELECT * FROM assigned_space";
$all_client = $con->query($sql2);
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
    <style >
        
        .space {
            background-color: whitesmoke;
            margin-top: 16px;
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom: 16px;
            padding: 16px;
            height: 720px;
        }
        main {
            width: 95%;
            display: flex;
            flex-wrap:wrap;
            justify-content: space-between;
            margin:auto;
        }
        
        main .card { 
            max-width: 600px;
            flex: 1 1 300px;
            text-align: center;
            max-height: 300px;
            border: 1px solid lightgray;
            margin: 20px;
        }

         main .card .image{
            height: 70%;
        }

        main .card .image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        main .card .caption{
            padding-left: 1em;
            text-align: left;
            height: 10%;
        }
        main .card .caption p{
            font-size: 20px;
        }


        main .card a{
            width: 50%;
        }

    </style>
</head>
<body>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->           
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="student-dashboard.php">Home</a>
        <a href="student-menu.php" class="active">Menu</a>
        <a href="student-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class = "space">
    <?php
        $sql = "SELECT * FROM assigned_space";
                    if($result = $con->query($sql)){
                        if($result->num_rows > 0){
                            echo '<table class="table table-bordered table-light table-striped text-center" style="padding:10px">';
                                echo "<thead style='background-color: maroon; color: white;' >";
                                    echo "<tr>";
                                    echo "<th>Store</th>";
                                        echo "<th>Menu</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                    echo "<td>" . $row['space_id'] . "</td>";
                                    echo "<td>";
                                        echo '<a href="extended-menu.php?id='. $row['client_id'] .'" class="mr-3" title="See menu" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-bars""></span></a>';
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    $con->close();
        ?>
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