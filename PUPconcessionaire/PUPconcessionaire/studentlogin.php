<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: student-dashboard.php");
    exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

if(isset($_POST['userlogin_btn'])){
// Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
         
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT stud_id, username, password FROM student_login WHERE username = ?";
            
            if($stmt = $con->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);
                
                // Set parameters
                $param_username = $username;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Store result
                    $stmt->store_result();
                    
                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1){                    
                        // Bind result variables
                        $stmt->bind_result($stud_id, $username, $password);
                        if($stmt->fetch()){
                            
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["stud_id"] = $stud_id;
                                $_SESSION["username"] = $username;                            
                                
                                // Redirect user to welcome page
                                header("location: student-dashboard.php");
                            
                                // Password is not valid, display a generic error message
                                
                           
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = "Please enter the correct credentials";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        }
    }  
    // Close connection
    $con->close();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>PUP - Concessionaire Management System (Beta)</title>
<link href="https://cdn.pup.edu.ph/img/ico/favicon.ico" rel="icon" type="image/x-icon" />
<link href="https://cdn.pup.edu.ph/frameworks/adminlte3.0.5/dist/css/adminlte.min.css" rel="stylesheet" />
<link href="https://cdn.pup.edu.ph/css/si.css" rel="stylesheet" />
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
<script src="https://kit.fontawesome.com/044ae73695.js" crossorigin="anonymous"></script>
</head>

<body class="sidebar-collapse fixed">

<div class="wrapper">
  <div class="content-wrapper">
    <div id="bgslider" class="bgslider">
      <div class="col-md-4 card frost">
        <div class="toplayer login-card-body">
          <div class="box-header with-border">
            <div class="text-center mb-2">
              <img alt="PUP" class="img-circle" src="https://cdn.pup.edu.ph/img/symbols/logo88x88.png" /></div>
            <h2 class="box-title text-center"><strong>PUP</strong> Concessionaire Management System <sup class="text-sm font-weight-lighter">&beta;eta</sup></h2>
          </div>
          <div class="box-body login-box-msg">
            <section id="introduction">
              <p>Sign in as Student</p>
            </section>
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" accept-charset="utf-8">
     <input type="hidden" name="csrf_test_name" value="7616f7e0309444e440a694efa325b291" />
              <div class="input-group mb-3">
                <?php 
                  if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                  }       
                ?>
              
              <input type="text" name="username" placeholder="Username" size="50" autocomplete="off" class="form-control" style="width:50%"  />
              
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span></div>
                </div>
              </div>

              <div class="input-group mb-3">
                <input type="password" name="password" placeholder="Password" class="form-control"  />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span></div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <a href="concessionaire.php" class="btn btn-danger btn-flat btn-block">Back</a>
                </div>
                <div class="col-6" class="form_buttons">                  
                    <button class="btn btn-primary btn-flat btn-block" class="loginbutt" type="submit" name="userlogin_btn">
                            Login
                    </button>
                </div>
              </div>
            <p>By using this service, you understood and agree to the PUP Online Services <a class="text-primary" href="https://www.pup.edu.ph/terms" target="_blank">Terms of Use</a> and <a class="text-primary" href="https://www.pup.edu.ph/privacy" target="_blank">Privacy Statement</a> </p>
          </div>
        </div>
      </div>
    </div>
    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
</html>
