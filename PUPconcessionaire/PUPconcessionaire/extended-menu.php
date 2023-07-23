<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: concessionaire.php");
    exit;
}

// Include config file
require_once "config.php";
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $client_id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM inventory WHERE client_id ='$client_id'";
        $all_product = $con->query($sql);
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>PUP Concessionaire</title>
    <style >
        
        .space {
            background-color: whitesmoke;
            margin: 16px;
            padding: 16px;
        }
        main {
            width: 95%;
            display: flex;
            flex-wrap:wrap;
            justify-content: space-between;
            margin: auto;
        }
        
        main .card { 
            max-width: 600px;
            flex: 1 1 300px;
            text-align: center;
            max-height: 300px;
            border: 1px solid lightgray;
            margin: 20px;
        }

         main .card .image{
            height: 70%;
        }

        main .card .image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        main .card .caption{
            padding-left: 1em;
            text-align: left;
            height: 10%;
        }
        main .card .caption p{
            font-size: 20px;
        }


        main .card a{
            width: 50%;
        }

    </style>
</head>
<body>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->           
    <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="student-dashboard.php">Home</a>
        <a href="student-menu.php" class="active">Menu</a>
        <a href="student-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
        <div class = "space">
            <h2 class = "pull-left">Menu</h2>
            <a href="student-menu.php" class="btn btn-info pull-right" style="padding:10px"><i class="fa fa-plus"></i> Back</a>
            <main>
                <?php 
                    
                    while ($row = mysqli_fetch_assoc($all_product)) { 
                ?>               
                    
                        <div class="card">
                            <div class = "image">
                                <img src = "<?php echo $row["img"];?> " alt = "">
                            </div>
                            <div class = "caption">
                                <p class = "product_name"><?php echo $row["name"];?></p>
                                <p class = "price">P <?php echo $row["price"];?></p>
                            </div>
                        </div>       
                    
                <?php
                    }
                ?> 
            </main>
        </div>
        <footer style="background-color:white;overflow:hidden;">
      <p style="color:maroon;margin-left:30px;margin-top:10px;"><i class="fa fa-envelope"style="margin-left:5px;margin-right:5px;"></i>puplagoon@gmail.com</p>
      <p style="color:maroon;margin-left:30px;margin-top:10px;"><i class="fa fa-phone" style="margin-left:5px;margin-right:5px;"></i>09123456789</p>
      <p style="color:maroon;margin-left:30px;margin-top:10px;">&copy; 2023 PUP LAGOON STA. MESA</p>
    </footer>
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