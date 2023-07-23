<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

require_once "config.php";

if(isset($_POST["id"]) && !empty($_POST["id"])) {
    $space_id = $_POST["id"];
    
    // Get the record from the archive table
    $query = "SELECT * FROM archive_space WHERE space_id = ?";
    if($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $space_id);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Insert the record into the client table
            $query = "INSERT INTO space_features (space_id, dimension_length, dimension_width, dimension_height,
            capacity, lights, sinks, windows, sockets) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if($stmt = $con->prepare($query)) {
                $stmt->bind_param("sdddiiiii", $row["space_id"], $row["dimension_length"], $row["dimension_width"], $row["dimension_height"],
                $row["capacity"], $row["lights"], $row["sinks"], $row["windows"], $row["sockets"]);
                if($stmt->execute()) {
                    // Delete the record from the archive table
                    $query = "DELETE FROM archive_space WHERE space_id = ?";
                    if($stmt = $con->prepare($query)) {
                        $stmt->bind_param("s", $space_id);
                        if($stmt->execute()) {
                            header("location: feature-index.php");
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

$space_id = $_GET["id"];
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
                                <a href="archive-space.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
