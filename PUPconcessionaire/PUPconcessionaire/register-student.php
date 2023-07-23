<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$stud_id = $fullname = $age = $year = $section = $address = "";
$stud_id_err = $fullname_err = $age  =  $year_err = $section_err = $address_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // validate username/client id
    if(empty(trim($_POST["stud_id"]))){
        $stud_id_err = "Please enter student id.";}
    else{
        $stud_id = trim($_POST["stud_id"]);
    }

    //validate name
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter student's full name.";}
    else{
        $fullname = trim($_POST["fullname"]);
    }

    //validate company
    if(empty(trim($_POST["age"]))){
        $age_err = "Please enter student's age.";}
    else{
        $age = trim($_POST["age"]);
    }

    //validate address
    if(empty(trim($_POST["year"]))){
        $year_err = "Please enter student's year.";}
    else{
        $year = trim($_POST["year"]);
    }

    //validate contact number
    if(empty(trim($_POST["section"]))){
        $section_err = "Please enter student's section.";}
    else{
        $section = trim($_POST["section"]);
    }

    //validate email
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter student's address.";}
    else{
        $address = trim($_POST["address"]);
    }
    
    // Check input errors before inserting in database
    if(empty($stud_id_err) && empty($fullname_err) && empty($age_err) && empty($year_err) && empty($section_err)&& empty($address_err)){
        
        // Prepare an insert statement
        $sql = "CALL add_student(?, ?, ?, ?, ?, ?)";
         
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("isisss", $param_stud_id, $param_fullname, $param_age, $param_year, $param_section, $param_address);
            
            // Set parameters
            $param_stud_id = $stud_id;
            $param_fullname = $fullname;
            $param_age = $age;
            $param_year = $year;
            $param_section = $section;
            $param_address = $address;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to accounts page
                header("location: student-list.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $con->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="authentication.css">
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
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
        <section class="vh-100" style=" padding-top: 0px;">
        <!-- <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="./images/1.jpg"
                class="img-fluid" alt="Sample image">
            </div> -->
            <div class='profile_form' class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

            <form class='form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Student Information</h2>
            <div class="form-group">
                    <label>Student ID</label>
                    <input type="text" name="stud_id" class="form-control <?php echo (!empty($stud_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stud_id; ?>">
                    <span class="invalid-feedback"><?php echo $stud_id_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullname; ?>">
                    <span class="invalid-feedback"><?php echo $fullname_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                    <span class="invalid-feedback"><?php echo $age_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <input type="text" name="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                    <span class="invalid-feedback"><?php echo $year_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Section</label>
                    <input type="text" name="section" class="form-control <?php echo (!empty($section_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $section; ?>">
                    <span class="invalid-feedback"><?php echo $section_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                    <span class="invalid-feedback"><?php echo $address_err; ?></span>
                </div>
                <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                <button class='save' type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Create</button>
                <button class='cancel'>
                  <a href='client-list.php'>Cancel</a>
                </button>
                <!-- <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="userlogin.php"
                    class="link-danger">Login here</a></p> -->
                </div>
            </form>
        <!-- </div>
            </div>
        </div> -->
        </section>
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