<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Bills</title>
<style>
body {
    margin: auto;
    background-image: url('img/lagoonpup.jpg');
    background-size: cover;
    align-items: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    min-height: 100vh; /* Set the minimum height to the height of the viewport */
}


button { 
 font-family: arial; 
 font-size: 18px; 
 margin-top: 15px; 
 width: 250px;
 height: 40px;
 box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
 border-style: solid; 
 background-color: maroon; 
 color: white; 
 border-width: 2px;
 border-color: white;
 border-width: 2px;
}

button:hover{
  opacity: 0.8;
  background-color: white;
  color: maroon; 
}

.billcontainer{ 
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
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
        <a href="student-list.php">Students</a>
        <a href="assignedspace-index.php">Assigned</a>
        <a href="clientreqs-index.php">Requirements</a>
        <a href="feature-index.php">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="bills.php" class="active" >Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
  <div class="billcontainer"> 
    <form method="post" action="spacebill-index.php">
      <div>
        <button class="spbutton" type="submit" name="spacebill_btn">Space Bills</button>
      </div>
    </form>
    <form method="post" action="electricbill-index.php">
    <div>
          <button class="ebillbutton" type="submit" name="electricbill_btn">Electric Bills</button>
    </div>
  </form>
  <form method="post" action="waterbill-index.php">
    <div>
          <button class="wbillbutton" type="submit" name="waterbill_btn">Water Bills</button>
    </div>
  </form>
  <form method="post" action="totalbill-index.php">
    <div>
          <button class="tbillbutton" type="submit" name="totalbill_btn">Total Bills</button>
    </div>
  </form>
</div> 
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