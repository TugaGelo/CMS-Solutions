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
    $rent_bill = $_POST['rent_bill'];
    $misc_bill = $_POST['misc_bill'];
    $penalty = $_POST['penalty'];
    $security_dep = $_POST['security_dep'];

    $stmt = $con->prepare("CALL update_space_bill(?, ?, ?, ?, ?)");
    $stmt->bind_param("sdddd", $eid, $rent_bill, $misc_bill, $penalty, $security_dep);
    if($stmt->execute()) {
        echo "<script>alert('Update successfully!');</script>";
        echo "<script>document.location = 'spacebill-index.php';</script>";
    } else {
        echo "<script>alert('Something went wrong!');</script>";
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Space Bill</title>
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
        <a href="clientreqs-index.php">Requirements</a>
        <a href="feature-index.php">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="bills.php" class="active">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <section class="vh-100" style=" padding-top: 0px;">
    <div class='profile_form' class="container d-flex justify-content-center"  class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
    <form class='form' action="" method="post">
    <h2>Space Bill Information</h2>
                <?php 
                    $eid = $_GET['editid'];
                    $sql = mysqli_query($con, "SELECT * FROM  `space_bill` WHERE bill_id = '$eid'");
                    while($row=mysqli_fetch_array($sql))
                    {          
                ?>

                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <label class="form-label">Rent Fee</label>
                        <input type="number" class="form-control" name="rent_bill" step=".01" value="<?php echo $row['rent_bill'];?>">
                    </div>    
                
                    <div class="col">
                        <label class="form-label">Miscellaneous Fee</label>
                        <input type="number" class="form-control" name="misc_bill" step=".01" value="<?php echo $row['misc_bill'];?>">
                    </div>

                </div>

                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <label class="form-label">Penalty Fee</label>
                        <input type="number" class="form-control" name="penalty" step=".01" value="<?php echo $row['penalty'];?>">
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Security Deposit</label>
                        <input type="number" class="form-control" name="security_dep" step=".01" value="<?php echo $row['security_dep'];?>">
                    </div>
                    
                </div>
                
                <?php 
                    }
                ?>

                <div class='form_buttons'>
                    <button class='save' type="submit" class="btn btn-success" name="update">Update</button>
                    <button>
                    <a class='cancel' href="spacebill-index.php" class="btn btn-danger">Cancel</a>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </section>
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