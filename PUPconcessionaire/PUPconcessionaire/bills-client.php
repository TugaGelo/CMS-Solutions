<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="bills.css"> 
    <title>Bills</title>
</head>
<body>
<div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="user-dashboard.php">Home</a>
        <a href="clientprofile.php">Profile</a>
        <a href="menu.php">Menu</a>
        <a href="read-assignedspace-client.php">My Space</a>
        <a href="read-clientreqs-client.php">Requirement</a>
        <a href="bills-client.php" class="active" >Bills</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class="billcon">
    <form method="post" action="read-spacebill-client.php">
      <div>
        <button type="submit" name="spacebill_btn">Space Bills</button>
      </div>
    </form>
    <form method="post" action="read-electricbill-client.php">
    <div>
          <button type="submit" name="electricbill_btn">Electric Bills</button>
    </div>
  </form>
  <form method="post" action="read-waterbill-client.php">
    <div>
          <button type="submit" name="waterbill_btn">Water Bills</button>
    </div>
  </form>
  <form method="post" action="client-total-bills.php">
    <div>
          <button type="submit" name="totalbill_btn">Total Bills</button>
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