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
$inventory_id = $client_id = $name = $price = $quantity = $img = "";
$inventory_id_err = $client_id_err = $name_err = $price_err =  $quantity_err = $img_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["inventory_id"]) && !empty($_POST["inventory_id"])){
    
    $inventory_id = $_POST["inventory_id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter item's name.";     
    } else{
        $name = $input_name;
    }

    // validate company
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter item's price.";     
    } else{
        $price = $input_price;
    }

    // Validate address
    $input_quantity = trim($_POST["quantity"]);
    if(empty($input_quantity)){
        $quantity_err = "Please enter item's quantity.";     
    } else{
        $quantity = $input_quantity;
    }

    // Validate contact number
    $input_img = trim($_POST["img"]);
    if(empty($input_img)){
        $img_err = "Please upload an image for the menu.";     
    } else{
        $img = $input_img;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($price_err) && empty($quantity_err) && empty($img_err)){

        $sql = "UPDATE inventory SET name=?, price=?, quantity=?, img=? WHERE inventory_id=?";
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("siisis", $param_name, $param_price, $param_quantity, $param_img,  $param_inventory_id, $param_client_id);
            
            // Set parameters
            $param_inventory_id = $inventory_id;
            $param_client_id = $client_id;
            $param_name = $name;
            $param_price = $price;
            $param_quantity = $quantity;
            $param_img = $img;
            
           

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: menu.php");
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
        $inventory_id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM inventory WHERE inventory_id = ?";
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_inventory_id);
            
            // Set parameters
            $param_inventory_id = $inventory_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $inventory_id = $row["inventory_id"];
                    $client_id = $row["client_id"];
                    $name = $row["name"];
                    $price = $row["price"];
                    $quantity = $row["quantity"];
                    $img = $row["img"];
                    
 
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
    <title>Update Menu</title>
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
                    <form class='form' action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <h2>Student Information</h2>    
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <textarea name="text" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"><?php echo $quantity; ?></textarea>
                            <span class="invalid-feedback"><?php echo $quantity_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="img" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $img; ?>">
                            <span class="invalid-feedback"><?php echo $img_err; ?></span>
                        </div>
                        
                        <div class='form_buttons' class="text-center text-lg-start mt-4 pt-2">
                        <input type="hidden" name="inventory_id" value="<?php echo $inventory_id; ?>"/>
                        <button class='save'class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">
                        <input type="submit"value="Submit">
                        </button>
                        <button>
                        <a class='cancel' href="menu.php" class="btn btn-secondary ml-2">Cancel</a>
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