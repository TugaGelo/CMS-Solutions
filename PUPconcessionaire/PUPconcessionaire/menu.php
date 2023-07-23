<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: concessionaire.php");
    exit;
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        #archive{
            color: maroon;
            float: right;
            margin-right: 20px;
        }
        /* Style for the search input */
        input[type="text"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        width: 300px;
        font-size: 16px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Style for the search button */
        button[name="submit"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-left: 10px;
        background-color: #007bff;
        color: #fff;    
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Style for the button when it is hovered over */
        button[name="submit"]:hover {
        background-color: #0069d9;
        }

    </style>
</head>
<body> 
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="user-dashboard.php">Home</a>
        <a href="clientprofile.php">Profile</a>
        <a href="menu.php" class="active">Menu</a>
        <a href="read-assignedspace-client.php">My Space</a>
        <a href="read-clientreqs-client.php" >Requirement</a>
        <a href="bills-client.php">Bills</a> 
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class="wrapper" style="padding-left: 85px; padding-right: 85px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix" style="padding:10px">
                    <h2 class="pull-left">Menu</h2>
                    <a href="menu-upload.php" class="btn btn-info pull-right" style="padding:10px"><i class="fa fa-plus"></i> New Menu Item</a>
                </div>
                <div class="table-responsive">
                <?php
                // Include config file
                require_once "config.php";
                
                // Attempt select query execution
                $sql = "SELECT * FROM inventory WHERE client_id='$username'";
                if($result = $con->query($sql)){
                    if($result->num_rows > 0){
                        echo '<table class="table table-bordered table-light table-striped text-center" style="padding:10px">';
                            echo "<thead style='background-color: maroon; color: white;' >";
                                echo "<tr>";
                                echo "<th>Name</th>";
                                echo "<th>Price</th>";
                                echo "<th>Quantity</th>";
                                echo "<th>Image</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = $result->fetch_array()){
                                echo "<tr>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . $row['img'] . "</td>";        
                                    echo "<td>";
                                        echo '<a href="update-menu.php?id='. $row['inventory_id'] .'" class="mr-3" title="Update Item" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-pencil"></span></a>';
                                        echo '<a href="delete-menu.php?id='. $row['inventory_id'] .'" title="Delete Item" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-trash"></span></a>';
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