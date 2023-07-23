  <?php 

  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: concessionaire.php");
    exit;
  }
  $username = $_SESSION["username"];
  require_once "config.php";

  if(isset($_FILES['files'])){
      $folder = "upload/";
    
      $names = $_FILES['files']['name'];
      $tmp_names = $_FILES['files']['tmp_name'];
    
      $upload_data = array_combine($tmp_names, $names);
    
      foreach ($upload_data as $temp_folder => $file) {
        move_uploaded_file($temp_folder, $folder.$file);
      }
      // $client_id = $_POST['client_id'];
      $sql = mysqli_query($con, "SELECT * FROM `client_requirements` WHERE client_id='$username'");
          
      if($sql)
      {
          echo "<script>alert('Submitted successfully!');</script>";
          echo "<script>document.location = 'create-clientreqs.php';</script>";
      }

      else
      {
          echo "<script>alert('Something went wrong!');</script>";
      }
  }

  ?>

  <!doctype html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Client Requirements</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="styles.css">
      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
    <div class="topnav" id="myTopnav">
          <label class="logo-container">
              <img src="img/logo.png" alt="logo" class="logo">
            <span class="logo-text">PUPconcessionaire</span>
          </label> 
          <a href="user-dashboard.php" >Home</a>
          <a href="clientprofile.php">Profile</a>
          <a href="read-assignedspace-client.php">My Space</a>
          <a href="read-clientreqs-client.php"class="active">Requirement</a>
          <a href="bills-client.php">Bills</a> 
          <a href="client-change-password.php">Change Password</a>
          <a href="logout.php">LogOut</a>
          <a class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
          </a>
      </div>

      <div class="container">
          <div class="text-center mb-4">
              <h3>Client Requirements</h3>
              <p class="text-muted">Complete form below to update Requirements</p>
          </div>
      </div>

          <div class="container d-flex justify-content-center">
              <form action="" method="post" enctype="multipart/form-data">
                  <h1> Select the 6 files you want to upload </h1>
                  <h2> for the admin to process </h2>
                  
                  <div class="row mb-3"> 
                      <input type="file" name="files[]" multiple> <button type="submit" name="upload">Upload files</button>
                      
                  </div>

                  <div >
                      <a href="clientreqs-index.php" class="btn btn-danger">View Records</a>
                  </div>
              </form>
          </div>
      </div>

      <!-- Bootstrap -->   
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
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