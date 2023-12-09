<?php
session_start();

include('config.php');

// Check if the user is logged in as General User
if (!isset($_SESSION['UserID']) || $_SESSION['UserType'] !== 'General User') {
    header("Location: login.php");
    exit();
}

// Fetch user information based on the session
$userID = $_SESSION['UserID'];
$sql = "SELECT Username, UserType FROM User WHERE UserID = '$userID'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $username = $user['Username'];
    $userType = $user['UserType'];
} else {
    // Handle error if user not found
    $username = "Error";
    $userType = "Error";
}
 // Fetch three relief information records
$sqlRelief = "SELECT * FROM reliefinformation LIMIT 3";
$resultRelief = $conn->query($sqlRelief);

// Fetch three disaster information records
$sqlDisaster = "SELECT * FROM disasterinformation LIMIT 3";
$resultDisaster = $conn->query($sqlDisaster);

// Fetch three public messages
$sqlMessages = "SELECT * FROM publicmessage LIMIT 3";
$resultMessages = $conn->query($sqlMessages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General User Home</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>User Type: <?php echo $userType; ?></p>

        <h2>Relief Information</h2>
        <div class="row">
            <?php
            while ($rowRelief = $resultRelief->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$rowRelief['Title']}</h5>
                                <p class='card-text'>{$rowRelief['Description']}</p>
                                <p class='card-text'><strong>Date Granted:</strong> {$rowRelief['DateGranted']}</p>
                                <p class='card-text'><strong>Amount:</strong> {$rowRelief['Amount']}</p>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>
        <a href="relief_information.php" class="float-right btn btn-primary">View More</a>

        <h2 class="mt-4">Disaster Information</h2>
        <div class="row">
            <?php
            while ($rowDisaster = $resultDisaster->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$rowDisaster['DisasterType']}</h5>
                                <p class='card-text'>{$rowDisaster['Description']}</p>
                                <p class='card-text'><strong>Date Occurred:</strong> {$rowDisaster['DateOccurred']}</p>
                                <p class='card-text'><strong>Location:</strong> {$rowDisaster['Location']}</p>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>
        <a href="disaster_information.php" class="float-right btn btn-primary">View More</a>

        <h2 class="mt-4">Public Messages</h2>
        <div class="row">
            <?php
            while ($rowMessage = $resultMessages->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$rowMessage['Title']}</h5>
                                <p class='card-text'>{$rowMessage['Message']}</p>
                                <p class='card-text'><strong>Date Posted:</strong> {$rowMessage['DatePosted']}</p>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>
        <a href="view_public_messages.php" class="float-right btn btn-primary">View More</a>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>