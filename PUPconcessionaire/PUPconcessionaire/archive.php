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
        <a href="client-list.php" class="active">Clients</a>
        <a href="assignedspace-index.php">Assigned</a>
        <a href="clientreqs-index.php">Requirements</a>
        <a href="feature-index.php">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="feature-index.php">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <div>   
    <div class="wrapper" style="padding-left: 85px; padding-right: 85px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div>
                <form action="accounts.php" method="post" style="margin-top:50px;">
                    <input
                        type="text"
                        placeholder="Search Name"
                        name="search"
                        required>
                    <button type="submit" name="submit">Search</button>
                </form>
                    <?php
                        // require_once "config.php";

                        if (isset($_POST['submit'])) {
                            $connection_string = new mysqli("localhost", "root", "", "pupconcessionaire");
                            
                            $searchString = mysqli_real_escape_string($connection_string, trim(htmlentities($_POST['search'])));

                            if ($connection_string->connect_error) {
                                echo "Failed to connect to Database";
                                exit();
                            }

                            if ($searchString === "" || !ctype_alnum($searchString) || $searchString < 3) {
                                echo "Invalid search string";
                                exit();
                            }

                            $searchString = "%$searchString%";

                            $sql = "SELECT * FROM archive WHERE client_id LIKE ?";

                            // Prepare, bind, and execute the query
                            $prepared_stmt = $connection_string->prepare($sql);
                            $prepared_stmt->bind_param('s', $searchString);
                            $prepared_stmt->execute();

                            // Fetch the result
                            $result = $prepared_stmt->get_result();


                            if($result->num_rows > 0){
                                echo '<table class="table table-bordered table-striped">';
                                    echo "<thead>";
                                        echo "<tr>";
                                            // echo "<th>ID</th>";
                                            echo "<th>Client ID</th>";
                                            echo "<th>Full Name</th>";
                                            echo "<th>Company</th>";
                                            echo "<th>Address</th>";
                                            echo "<th>Contact Number</th>";
                                            echo "<th>Email</th>";
                                            echo "<th>Status</th>";
                                            echo "<th>Date</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_array()){
                                        echo "<tr>";
                                            // echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['client_id'] . "</td>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['company'] . "</td>";
                                            echo "<td>" . $row['address'] . "</td>";
                                            echo "<td>" . $row['contact_no'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "<td>" . $row['status'] . "</td>";
                                            echo "<td>" . $row['date'] . "</td>";
                                            echo "<td>";
                                                echo '<a href="restore.php?id='. $row['client_id'] .'" title="Restore Record" data-toggle="tooltip"><span class="fa fa-trash"></span></span></a>';
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
                        } 
                    ?>
                </div>

                
                <div class="mt-5 mb-3 clearfix" style="padding:10px">
                    <h2 class="pull-left">Archives</h2>
                    <a href="delete-all-archives.php" class="btn btn-info pull-right" style="padding:10px"><i class="fa fa-trash"></i> Delete All</a>
                </div>
                <?php
                // Include config file
                require_once "config.php";
                
                // Attempt select query execution
                $sql = "SELECT * FROM archive";
                if($result = $con->query($sql)){
                    if($result->num_rows > 0){
                        echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                                echo "<tr>";
                                // echo "<th>ID</th>";
                                echo "<th>Client ID</th>";
                                echo "<th>Full Name</th>";
                                echo "<th>Company</th>";
                                echo "<th>Address</th>";
                                echo "<th>Contact Number</th>";
                                echo "<th>Email</th>";
                                echo "<th>Status</th>";
                                echo "<th>Date</th>";
                                    echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = $result->fetch_array()){
                                echo "<tr>";
                                // echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['client_id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['company'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['contact_no'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>";
                                        echo '<a href="restore.php?id='. $row['client_id'] .'" title="Restore Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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