<?php 
session_start();
require_once "config.php";
$username = $_SESSION["username"];

?>

<!doctype html>
<html lang="en">
    <head>
    <title>Client Requirements</title>
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
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="user-dashboard.php">Home</a>
        <a href="clientprofile.php">Profile</a>
        <a href="menu.php">Menu</a>
        <a href="read-assignedspace-client.php">My Space</a>
        <a href="read-clientreqs-client.php" class="active">Requirement</a>
        <a href="bills-client.php">Bills</a> 
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class="container">
        <div class="row">
        <div class="mt-5 mb-3 clearfix" style="padding:10px">
                <h2 class="pull-left" style="margin-right: 730px;">Client Requirements</h2>
                <a href="create-clientreqs.php" class="btn btn-info pull-right" style="padding: 10px; color: white; "><i class="fa fa-plus"></i> Upload</a>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                <table class="table table-bordered table-light table-striped text-center" style="padding:10px">
                                <thead style='background-color: maroon; color: white;' >
                            <tr>
                                <!-- <th scope="col">Client ID</th> -->
                                <th scope="col">Health Clearance</th>
                                <th scope="col">Mayor's Permit</th>
                                <th scope="col">BIR</th>
                                <th scope="col">SSS</th>
                                <th scope="col">PhilHealth</th>
                                <th scope="col">Pag-IBIG</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php
                                    $query = "SELECT * FROM client_requirements WHERE client_id = '$username'";
                                    $result = mysqli_query($con, $query);
                                
                                    if (mysqli_num_rows($result) > 0) {
                                      while($row = mysqli_fetch_assoc($result)) {                 
                            ?> 

                            <tr>
                                <!-- <td><?php echo $row['client_id'];?></td> -->
                                <td><?php echo $row['health_clr'];?></td>                
                                <td><?php echo $row['mayors_prm'];?></td>
                                <td><?php echo $row['bir'];?></td>
                                <td><?php echo $row['sss'];?></td>
                                <td><?php echo $row['philhealth'];?></td>
                                <td><?php echo $row['pag_ibig'];?></td>
                            </tr>
                            <?php
                                      }
                                    }
                                    else {
                                  // Redirect to login page
                                  header("Location: user-dashboard.php");
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div> 
        
    </div>
    <!-- Bootstrap -->   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
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