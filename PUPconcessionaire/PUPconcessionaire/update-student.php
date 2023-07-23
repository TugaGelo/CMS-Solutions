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
$stud_id = $fullname = $address = $year = $section = $age = "";
$stud_id_err = $fullname_err =  $address_err = $year_err = $section_err = $age_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["stud_id"]) && !empty($_POST["stud_id"])){
    
    $stud_id = $_POST["stud_id"];
    
    $input_name = trim($_POST["fullname"]);
    if(empty($input_name)){
        $fullname_err = "Please enter students's name.";     
    } else{
        $fullname = $input_name;
    }
    
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter students's age.";     
    } else{
        $age = $input_age;
    }

    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter students's year.";     
    } else{
        $year = $input_year;
    }

    $input_section = trim($_POST["section"]);
    if(empty($input_section)){
        $section_err = "Please enter students's section.";     
    } else{
        $section = $input_section;
    }

    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter client's address.";     
    } else{
        $address = $input_address;
    }

     
    // Check input errors before inserting in database
    if(empty($fullname_err) && empty($age_err) && empty($year_err) && empty($section_err) && empty($address_err)){

        $sql = "UPDATE student SET fullname=?, age=?, year=?, section=?, address=? WHERE stud_id=?";
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssis", $param_fullname, $param_age, $param_year, $param_section, $param_address, $param_stud_id);
            
            // Set parameters
            $param_stud_id = $stud_id;
            $param_fullname = $fullname;
            $param_age = $age;
            $param_year= $year;
            $param_section = $section;
            $param_address = $address;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: student-list.php");
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
        $stud_id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM student WHERE stud_id = ?";
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_stud_id);
            
            // Set parameters
            $param_stud_id = $stud_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $stud_id = $row["stud_id"];
                    $fullname = $row["fullname"];
                    $age= $row["age"];
                    $year = $row["year"];                   
                    $section = $row["section"];
                    $address = $row["address"];
                    
                    
 
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
        <a href="client-list.php">Clients</a>
        <a href="student-list.php" class="active">Students</a>
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
                    <h2>Student Information</h2>    
                    <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullname; ?>">
                            <span class="invalid-feedback"><?php echo $fullname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Year</label>
                            <input name="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>"><?php echo $year; ?></input>
                            <span class="invalid-feedback"><?php echo $year_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Section</label>
                            <input type="text" name="section" class="form-control <?php echo (!empty($section_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $section; ?>">
                            <span class="invalid-feedback"><?php echo $section_err;?></span>
                        </div>
                       <div class="form-group">
                            <label>Address</label>
                            <input name="text" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></input>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        
                        <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                        <input type="hidden" name="client_id" value="<?php echo $stud_id; ?>"/>
                        <button class='save'class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">
                        <input type="submit"value="Submit">
                        </button>
                        <button>
                        <a class='cancel' href="student-list.php" class="btn btn-secondary ml-2">Cancel</a>
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