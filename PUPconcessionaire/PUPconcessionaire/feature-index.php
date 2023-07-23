<?php 
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

require_once "config.php";
if(isset($_GET['delid']))
{
    $did = $_GET['delid'];
    $sql = mysqli_query($con,"DELETE FROM `space_features` WHERE space_id = '$did'");

    echo "<script>alert('Deleted successfully!');</script>";
    echo "<script>window.location='feature-index.php';</script>";
}
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Space Features</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="styles.css">
    <style>
                #archive{
            color: maroon;
            float: right;
            margin-right: 17%;
        }
        input[type="text"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        width: 300px;
        font-size: 16px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
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
        button[name="submit"]:hover {
        background-color: #0069d9;
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
        <a href="admin-dashboard.php">Home</a>
        <a href="adminprofile.php">Profile</a>
        <a href="client-accounts.php">Accounts</a>
        <a href="client-list.php">Clients</a>
        <a href="student-list.php">Students</a>
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
        <div class="wrapper" style="padding-left: 85px; padding-right: 85px;">
            <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div>
                <form action="feature-index.php" method="post" style="margin-top:50px;">
                    <input
                        type="text"
                        placeholder="Search space id"
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

                            $sql = "SELECT * FROM space_features WHERE space_id LIKE ?";

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
                                            echo "<th>Space ID</th>";
                                            echo "<th>Length (M)</th>";
                                            echo "<th>Width (M)</th>";
                                            echo "<th>Height (M)</th>";
                                            echo "<th>Capacity</th>";
                                            echo "<th>No. Lights</th>";
                                            echo "<th>No. Sinks</th>";
                                            echo "<th>No. Windows</th>";
                                            echo "<th>No. Sockets</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_array()){
                                        echo "<tr>";
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
                                                echo '<a href="feature-edit.php?id='. $row['space_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                                echo '<a href="feature-index.php?id='. $row['space_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
                <h2 class="pull-left">Space Features</h2>
                <a href="features-add_new.php" class="btn btn-info pull-right" style="padding:10px; color: white;"><i class="fa fa-plus" style="font-size: 18px;"></i> Create Space</a>
                <a href="archive-space.php" id="archive" class="btn btn-info pull-right" style="padding: 10px; color: white; margin-right: 15px;"><i class="fa fa-archive fa-lg"></i> Archive</a>
            </div>
        </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-light table-striped text-center" style="padding:10px">
                                <thead style='background-color: maroon; color: white;' >
                            <tr>
                                <th scope="col">Space ID</th>
                                <th scope="col">Length (M)</th>
                                <th scope="col">Width (M)</th>
                                <th scope="col">Height (M)</th>
                                <th scope="col">Capacity</th>
                                <th scope="col">No. Lights</th>
                                <th scope="col">No. Sinks</th>
                                <th scope="col">No. Windows</th>
                                <th scope="col">No. Sockets</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                                require_once "config.php";
                                $sql = mysqli_query($con, "SELECT * FROM `space_features`");
                                    $count = 1;
                                    $row = mysqli_num_rows($sql);
                                    if($row > 0)
                                    {
                                        while ($row = mysqli_fetch_array($sql))
                                        {                              
                            ?> 

                            <tr>
                                <td><?php echo $row['space_id'];?></td>
                                <td><?php echo $row['dimension_length'];?></td>
                                <td><?php echo $row['dimension_width'];?></td>
                                <td><?php echo $row['dimension_height'];?></td>
                                <td><?php echo $row['capacity'];?></td>
                                <td><?php echo $row['lights'];?></td>
                                <td><?php echo $row['sinks'];?></td>
                                <td><?php echo $row['windows'];?></td>
                                <td><?php echo $row['sockets'];?></td>                  
                                <td>
                                    <a href="feature-edit.php?editid=<?php echo htmlentities($row['space_id']);?>" class="link-dark" class="mr-3" title="Update Record" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-pencil"></span></a>
                                    <a href="feature-index.php?delid=<?php echo htmlentities($row['space_id']);?>" class="link-dark" title="Delete Record" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            <?php
                                        $count = $count+1;
                                        }
                                    }
                            ?>
                        </tbody>
                    </table>
                </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    
    <!-- Bootstrap -->   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
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
</body>
</html>