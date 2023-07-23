<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

// Include config file
require_once "config.php";

$username = $_SESSION["username"];

// Define variables and initialize with empty values
$client_id = $name = $price = $quantity= $img = $msg = "";
$client_id_err = $name_err = $price_err =  $quantity_err = $img_err = "";
 
// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter name.";}
    else{
        $name = trim($_POST["name"]);
    }

    //validate name
    if(empty(trim($_POST["price"]))){
        $price_err = "Please enter price.";}
    else{
        $price = trim($_POST["price"]);
    }

    //validate company
    if(empty(trim($_POST["quantity"]))){
        $quantity_err = "Please enter quantity.";}
    else{
        $quantity = trim($_POST["quantity"]);
    }

    //validate address
    if(empty(trim($_POST["img"]))){
        $img_err = "Please upload image file.";}
    else{
        $img = trim($_POST["img"]);
    }
    // Check input errors before inserting in database
    $upload_dir = "upload/";
    $upload_img = $upload_dir.$img;

    if(empty($client_id_err) && empty($name_err) && empty($price_err) && empty($quantity_err) && empty($img_err)){
        
        // Prepare an insert statement
        $sql = "CALL add_menu(?, ?, ?, ?, ?)";
         
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssiis", $param_client_id, $param_name, $param_price, $param_quantity, $param_img);
            
            // Set parameters
            $param_client_id = $username;
            $param_name = $name;
            $param_price = $price;
            $param_quantity = $quantity;
            $param_img = $upload_img;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to accounts page
                header("location: menu.php");
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
    <title>Menu Upload</title>
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
        <a href="user-dashboard.php">Home</a>
        <a href="clientprofile.php">Profile</a>
        <a href="menu.php" class="active">Menu</a>
        <a href="read-assignedspace-client.php">My Space</a>
        <a href="read-clientreqs-client.php" >Requirement</a>
        <a href="bills-client.php">Bills</a> 
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
        <section class="vh-100" style=" padding-top: 0px;">
            <div class='profile_form' class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

            <form class='form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Menu Upload</h2>
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <span class="invalid-feedback"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                    <span class="invalid-feedback"><?php echo $price_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
                    <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="img" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $img; ?>">
                    <span class="invalid-feedback"><?php echo $img_err; ?></span>
                </div>
                <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                <button class='save' type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Create</button>
                <button class='cancel'>
                  <a href='menu.php'>Cancel</a>
                </button>
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