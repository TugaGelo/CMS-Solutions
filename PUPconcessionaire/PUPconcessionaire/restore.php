<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

require_once "config.php";

if(isset($_POST["id"]) && !empty($_POST["id"])) {
    $client_id = $_POST["id"];
    
    // Get the record from the archive table
    $query = "SELECT * FROM archive WHERE client_id = ?";
    if($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $client_id);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Insert the record into the client table
            $query = "INSERT INTO client (client_id, name, company, address, contact_no, email, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
            if($stmt = $con->prepare($query)) {
                $stmt->bind_param("ssssssi", $row["client_id"], $row["name"], $row["company"], $row["address"], $row["contact_no"], $row["email"], $row["status"]);
                if($stmt->execute()) {
                    // Delete the record from the archive table
                    $query = "DELETE FROM archive WHERE client_id = ?";
                    if($stmt = $con->prepare($query)) {
                        $stmt->bind_param("s", $client_id);
                        if($stmt->execute()) {
                            header("location: client-list.php");
                            exit();
                        }
                    }
                }
            }
        }
    }
    
    echo "Oops! Something went wrong. Please try again later.";
}

if(empty(trim($_GET["id"]))) {
    header("location: errorpage.php");
    exit();
}

$client_id = $_GET["id"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restore Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Restore</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to restore this client record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="archive-client.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
