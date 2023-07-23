<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: concessionaire.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clients</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
   <style>
    body {
        margin: 0;
            }

        ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 20%;
        background-color: #f1f1f1;
        position: fixed;
        height: 100%;
        overflow: auto;
        }

        li a {
        display: block;
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
        }

        li a.active {
        background-color: #04AA6D;
        color: white;
        }

        li a:hover:not(.active) {
        background-color: #555;
        color: white;
        }
    </style>
</head>
<body> 
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
            <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="admin-dashboard.php">Home</a>
        <a href="adminprofile.php">Profile</a>
        <a href="client-accounts.php">Accounts</a>
        <a href="client-list.php">Clients</a>
        <a href="assignedspace-index.php">Assigned</a>
        <a href="clientreqs-index.php">Requirements</a>
        <a href="feature-index.php" class="active">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <div>   
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div>              
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Archives</h2>
                    <a href="delete-all-archive-space.php" class="btn btn-dark mb-3">Delete All</a>
                </div>
                <?php
                // Include config file
                require_once "config.php";
                
                // Attempt select query execution
                $sql = "SELECT * FROM archive_space";
                if($result = $con->query($sql)){
                    if($result->num_rows > 0){
                        echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                                echo "<tr>";
                                echo "<th>ID</th>";
                                echo "<th>Space ID</th>";
                                echo "<th>Dimension Length</th>";
                                echo "<th>Dimension Width</th>";
                                echo "<th>Dimension Height</th>";
                                echo "<th>Capacity</th>";
                                echo "<th>Lights</th>";
                                echo "<th>Sinks</th>";
                                echo "<th>Windows</th>";
                                echo "<th>Sockets</th>";
                                    echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = $result->fetch_array()){
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['space_id'] . "</td>";
                                echo "<td>" . $row['dimension_length'] . "</td>";
                                echo "<td>" . $row['dimension_width'] . "</td>";
                                echo "<td>" . $row['dimension_height'] . "</td>";
                                echo "<td>" . $row['capacity'] . "</td>";
                                echo "<td>" . $row['lights'] . "</td>";
                                echo "<td>" . $row['sinks'] . "</td>";
                                echo "<td>" . $row['windows'] . "</td>";
                                echo "<td>" . $row['sockets'] . "</td>";
                                    echo "<td>";
                                        echo '<a href="restore-space.php?id='. $row['space_id'] .'" title="Restore Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
        </div>        
    </div>
</div>
</div>
</div>
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