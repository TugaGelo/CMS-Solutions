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
$client_id = $name = $company = $address = $contact_number = $email = $status = "";
$client_id_err = $name_err = $company =  $address_err = $contact_number_err = $email_err = $status_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // validate username/client id
    if(empty(trim($_POST["client_id"]))){
        $client_id_err = "Please enter client id.";}
    else{
        $client_id = trim($_POST["client_id"]);
    }

    //validate name
    if(empty(trim($_POST["fullname"]))){
        $name_err = "Please enter client's full name.";}
    else{
        $name = trim($_POST["fullname"]);
    }

    //validate company
    if(empty(trim($_POST["company"]))){
        $company_err = "Please enter client's company name.";}
    else{
        $company = trim($_POST["company"]);
    }

    //validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter client's address.";}
    else{
        $address = trim($_POST["address"]);
    }

    //validate contact number
    if(empty(trim($_POST["contact_number"]))){
        $contact_number_err = "Please enter client's contact number.";}
    else{
        $contact_number = trim($_POST["contact_number"]);
    }

    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";}
    else{
        $email = trim($_POST["email"]);
    }

    if($_POST["status"]){
        $status = $_POST["status"];
    }
    
    // Check input errors before inserting in database
    if(empty($client_id_err) && empty($name_err) && empty($company_err) && empty($address_err) && empty($contact_number_err)&& empty($email_err)){
        
        // Prepare an insert statement
        $sql = "CALL add_client(?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssi", $param_client_id, $param_name, $param_company, $param_address, $param_contact_number, $param_email, $param_status);
            
            // Set parameters
            $param_client_id = $client_id;
            $param_name = $name;
            $param_company = $company;
            $param_address = $address;
            $param_contact_number = $contact_number;
            $param_email = $email;
            $param_status = $status;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to accounts page
                header("location: client-list.php");
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
        <a href="student-list.php">Students</a>
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
            <h2>Client Information</h2>
            <div class="form-group">
                    <label>Client ID</label>
                    <input type="text" name="client_id" class="form-control <?php echo (!empty($client_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $client_id; ?>">
                    <span class="invalid-feedback"><?php echo $client_id_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <span class="invalid-feedback"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" name="company" class="form-control <?php echo (!empty($company_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $company; ?>">
                    <span class="invalid-feedback"><?php echo $company_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                    <span class="invalid-feedback"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="form-control <?php echo (!empty($contact_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact_number; ?>">
                    <span class="invalid-feedback"><?php echo $contact_number_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group" >
                    <select name= "status" style="width: 442px; height: 42px; margin-top: 15px">
                    <option value="0" <?php if ($status == 0); ?>>Inactive</option>
                    <option value="1" <?php if ($status == 1); ?>>Active</option>
                </select>
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