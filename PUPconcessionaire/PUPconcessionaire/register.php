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
$fullname = $username = $email = $password = $confirm_password = $role = "";
$fullname_err = $username_err = $email_err = $password_err = $confirm_password_err = $role_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //validate email
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your full name.";}
    else{
        $fullname = trim($_POST["fullname"]);
    }

    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";}
    else{
        $email = trim($_POST["email"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM client_login WHERE username = ?
        UNION SELECT username FROM admin_login WHERE username = ?";
        
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    if(empty(trim($_POST["role"]))){
        $role_err = "Please enter your role.";}
    else{
        $role = trim($_POST["role"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($fullname_err) &&  empty($email_err)&& empty($username_err)  && empty($password_err) && empty($confirm_password_err) && empty($role_err)){
        
        // Prepare an insert statement
        $sql = "CALL add_user(?, ?, ?, ?, ?)";

        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_fullname, $param_username,$param_email, $param_password, $param_role);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_role = $role;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to accounts page
                header("location: client-accounts.php");
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
        <a href="client-accounts.php" class="active">Accounts</a>
        <a href="client-list.php">Clients</a>
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
            <div class='profile_form' class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

            <form class='form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Account Information</h2>
            <div class='form_group' class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullname; ?>">
                    <span class="invalid-feedback"><?php echo $fullname_err; ?></span>
                </div>
                <div class='form_group' class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class='form_group' class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class='form_group' class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class='form_group' class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class='form_group' class="form-group">
                    <label>Role (Client / Admin)</label>
                    <input type="text" name="role" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $role; ?>">
                    <span class="invalid-feedback"><?php echo $role_err; ?></span>
                </div>
                <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                <button class='save' type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Create</button>
                <button class='cancel'>
                  <a href='client-accounts.php'>Cancel</a>
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