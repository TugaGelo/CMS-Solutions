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
if(isset($_POST["client_id"]) && !empty($_POST["client_id"])){
    
    $client_id = $_POST["client_id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter client's name.";     
    } else{
        $name = $input_name;
    }

    // validate company
    $input_company = trim($_POST["company"]);
    if(empty($input_company)){
        $company_err = "Please enter client's company.";     
    } else{
        $company = $input_company;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter client's address.";     
    } else{
        $address = $input_address;
    }

    // Validate contact number
    $input_contact_number = trim($_POST["contact_number"]);
    if(empty($input_contact_number)){
        $contact_number_err = "Please enter client's contact number.";     
    } else{
        $contact_number = $input_contact_number;
    }

    // validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter client's email.";     
    } else{
        $email = $input_email;
    }

    $input_status = $_POST["status"];
    if(empty($input_status)) {
        $status = "0";
    } else {
        $status = $input_status;
    }
    

    // Check input errors before inserting in database
    if(empty($name_err) && empty($company_err) && empty($address_err) && empty($contact_number_err) && empty($email_err) ){
        // Prepare an update statement
        // $sql = "CALL update_client(?, ?, ?, ?, ?, ?, ?)";
        $sql = "UPDATE client SET name=?, company=?, address=?, contact_no=?, email=?, status=? WHERE client_id=?";
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssis", $param_name, $param_company, $param_address, $param_contact_number, $param_email, $param_status, $param_client_id);
            
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
                // Records updated successfully. Redirect to landing page
                header("location: client-list.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $con->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $client_id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM client WHERE client_id = ?";
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_client_id);
            
            // Set parameters
            $param_client_id = $client_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $client_id = $row["client_id"];
                    $name = $row["name"];
                    $company = $row["company"];
                    $address = $row["address"];
                    $contact_number = $row["contact_no"];
                    $email = $row["email"];
                    $status = $row["status"];
 
                } 
                else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Close connection
        $con->close();
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
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
        <a href="bills.php" >Bills</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <section class="vh-100" style=" padding-top: 0px;">
    <div class='profile_form' class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form class='form' action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <h2>Client Information</h2>    
                    <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="company" class="form-control <?php echo (!empty($company_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $company; ?>">
                            <span class="invalid-feedback"><?php echo $company_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" class="form-control <?php echo (!empty($contact_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact_number; ?>">
                            <span class="invalid-feedback"><?php echo $contact_number_err;?></span>
                        </div>
                       <div class="form-group">
                            <label>Email</label>
                            <textarea name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"><?php echo $email; ?></textarea>
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <select name= "status"style="width: 442px; height: 42px; margin-top: 15px">
                            <option value="0" <?php if ($status == 0); ?>>Inactive</option>
                            <option value="1" <?php if ($status == 1); ?>>Active</option>
                        </select>
                        </div>
                        
                        <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>"/>
                        <button class='save'class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">
                        <input type="submit"value="Submit">
                        </button>
                        <button>
                        <a class='cancel' href="client-list.php" class="btn btn-secondary ml-2">Cancel</a>
                        </button>
                        </div>
                    </form>
                </div>
                </section>
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


