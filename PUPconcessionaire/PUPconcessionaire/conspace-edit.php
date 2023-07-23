<?php 

require_once "config.php";
$eid = $_GET['editid'];

if(isset($_POST['update']))
{
    $eid = $_GET['editid'];

    $space_id = $_POST['space_id'];
    $date_rented = $_POST['date_rented'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $merch_type = $_POST['merch_type'];

    $sql1 =mysqli_query($con,"UPDATE `concession_space` SET `date_rented`='$date_rented',
                                                            `status`='$status',
                                                            `merch_type`='$merch_type',
                                                            `price`='$price' WHERE space_id='$eid'");
    if($sql1)
    {
        echo "<script>alert('Update successfully!');</script>";
        echo "<script>document.location = 'conspace-index.php';</script>";

        $sql2 =mysqli_query($con,"UPDATE `space_bill` SET `price`='$price' WHERE space_id='$eid'");
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
    <title>Concession Spaces</title>
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
        <a href="conspace-index.php" class="active">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <section class="vh-100" style=" padding-top: 0px;">
    <div class='profile_form' class="container d-flex justify-content-center"  class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form class='form' action="" method="post">
            <h2>Concession Space Information</h2>
                <?php 
                    $eid = $_GET['editid'];
                    $sql = mysqli_query($con, "SELECT * FROM  `concession_space` WHERE space_id = '$eid'");
                    while($row=mysqli_fetch_array($sql))
                    {          
                ?>

                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <label class="form-label">Space ID</label>
                        <input type="text" class="form-control" name="space_id" value="<?php echo $row['space_id'];?>">
                    </div>

                    <div class="col">
                        <label class="form-label">Date Rented</label>
                        <input type="text" class="form-control" name="date_rented" value="<?php echo $row['date_rented'];?>">
                    </div>
                </div>

                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="status" value="<?php echo $row['status'];?>" name="status">
                            <option value="1" class="form-control">Available</option>
                            <option value="0" class="form-control">Not Available</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" step="0.01" value="<?php echo $row['price'];?>">
                    </div>
                </div>
                
                <div class='form_group' class="row mb-3">
                    <div class="col">
                    <div class="form-group">
                            <label class="form-label">Merchandise Type</label>
                            <select name="merch_type" id="" class="form-select" value="<?php echo $row['merch_id'];?>" required>   
                            <?php 
									$categories = $con->query("SELECT * FROM merch_type");
									if($categories->num_rows > 0):
									while($row= $categories->fetch_assoc()) :
									?>
									<option value="<?php echo $row['merch_id'] ?>"><?php echo $row['merch_type'] ?></option>
								<?php endwhile; ?>
								<?php else: ?>
									<option selected="" value="" disabled="">Please check the category list.</option>
								<?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <?php 
                    }
                ?>

                <div class='form_buttons' >
                    <button class='save' type="submit" class="btn btn-success" name="update">Update</button>
                    <button>
                    <a class='cancel' href="read-conspace.php" class="btn btn-danger">Cancel</a>
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