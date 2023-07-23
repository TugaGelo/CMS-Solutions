<?php 
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

require_once "config.php";
$eid = $_GET['editid'];

if(isset($_POST['update']))
{
    $eid = $_GET['editid'];
    $health_clearance = $_POST['health_clr'];
    $mayors = $_POST['mayors_prm'];
    $BIR = $_POST['BIR'];
    $SSS = $_POST['SSS'];
    $Philhealth = $_POST['Philhealth'];
    $pag_ibig = $_POST['pag_ibig'];
    // $status = $_POST['status'];


    $sql1 =mysqli_query($con,"UPDATE `client_requirements` SET `health_clr`='$health_clearance',
                                                                `mayors_prm`='$mayors',
                                                                `BIR`='$BIR',
                                                                `SSS`='$SSS',
                                                                `Philhealth`='$Philhealth',
                                                                `pag_ibig`='$pag_ibig'
                                                           WHERE client_id='$eid'");
    if($sql1)
    {
        echo "<script>alert('Update successfully!');</script>";
        echo "<script>document.location = 'clientreqs-index.php';</script>";
    }

    else
    {
        echo "<script>alert('Something went wrong!');</script>";
    }
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Requirements</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <a href="student-list.php">Students</a>
        <a href="assignedspace-index.php">Assigned</a>
        <a href="clientreqs-index.php" class="active">Requirements</a>
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
    <section class="vh-100" style=" padding-top: 0px;">
    <div class='profile_form' class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form class='form' action="" method="post">
            <h2>Requirement Information</h2>
                <?php 
                    $eid = $_GET['editid'];
                    $sql = mysqli_query($con, "SELECT * FROM  `client_requirements` WHERE client_id = '$eid'");
                    while($row=mysqli_fetch_array($sql))
                    {          
                ?>

                <div class="row mb-3">
                    <div class="form-group">
                        <div class="col">
                        <label class="form-label">Health Clearance</label>
                        <select style="width: 442px; height: 42px; margin-top: 15px" name="health_clr">
                            <option value="Pending" <?php if ($row['health_clr'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Approved" <?php if ($row['health_clr'] == 'Approved') echo 'selected'; ?>>Approved</option>
                            <option value="Denied" <?php if ($row['health_clr'] == 'Denied') echo 'selected'; ?>>Denied</option>
                        </select>
                        </div>
                        <br>
                        <div class="col">
                            <label class="form-label">Mayor's Permit</label>
                            <select style="width: 442px; height: 42px; margin-top: 15px" name="mayors_prm">
                                <option value="Pending" <?php if ($row['mayors_prm'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Approved" <?php if ($row['mayors_prm'] == 'Approved') echo 'selected'; ?>>Approved</option>
                                <option value="Denied" <?php if ($row['mayors_prm'] == 'Denied') echo 'selected'; ?>>Denied</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group">
                        <div class="col">
                            <label class="form-label">BIR</label>
                            <select style="width: 442px; height: 42px; margin-top: 15px" name="BIR">
                                <option value="Pending" <?php if ($row['bir'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Approved" <?php if ($row['bir'] == 'Approved') echo 'selected'; ?>>Approved</option>
                                <option value="Denied" <?php if ($row['bir'] == 'Denied') echo 'selected'; ?>>Denied</option>
                            </select>
                        </div>
                        <br>
                        <div class="col">
                            <label class="form-label">SSS</label>
                            <select style="width: 442px; height: 42px; margin-top: 15px" name="SSS">
                                <option value="Pending" <?php if ($row['sss'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Approved" <?php if ($row['sss'] == 'Approved') echo 'selected'; ?>>Approved</option>
                                <option value="Denied" <?php if ($row['sss'] == 'Denied') echo 'selected'; ?>>Denied</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group">
                        <div class="col">
                            <label class="form-label">Philhealth</label>
                            <select style="width: 442px; height: 42px; margin-top: 15px" name="Philhealth">
                                <option value="Pending" <?php if ($row['philhealth'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Approved" <?php if ($row['philhealth'] == 'Approved') echo 'selected'; ?>>Approved</option>
                                <option value="Denied" <?php if ($row['philhealth'] == 'Denied') echo 'selected'; ?>>Denied</option>
                            </select>
                        </div>
                        <br>
                        <div class="col">
                            <label class="form-label">Pag-IBIG</label>
                            <select style="width: 442px; height: 42px; margin-top: 15px" name="pag_ibig">
                                <option value="Pending" <?php if ($row['pag_ibig'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Approved" <?php if ($row['pag_ibig'] == 'Approved') echo 'selected'; ?>>Approved</option>
                                <option value="Denied" <?php if ($row['pag_ibig'] == 'Denied') echo 'selected'; ?>>Denied</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                ?>

                <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                    <button class='save'type="submit" class="btn btn-success" name="update">Update</button>
                    <button class='cancel'>
                    <a href="clientreqs-index.php">Cancel</a>
                    </button>
                </div>
            </form>
            </section>
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