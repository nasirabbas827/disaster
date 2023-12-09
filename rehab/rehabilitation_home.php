<?php
session_start();

include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['UserID']) || $_SESSION['UserType'] !== 'Rehabilitation Institutes') {
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

// Query to fetch total counts
$sqlDisasterCount = "SELECT COUNT(*) as totalDisasters FROM disasterinformation";
$resultDisasterCount = $conn->query($sqlDisasterCount);
$totalDisasters = $resultDisasterCount->fetch_assoc()['totalDisasters'];

$sqlReliefCount = "SELECT COUNT(*) as totalReliefs FROM reliefinformation";
$resultReliefCount = $conn->query($sqlReliefCount);
$totalReliefs = $resultReliefCount->fetch_assoc()['totalReliefs'];

$sqlMessageCount = "SELECT COUNT(*) as totalMessages FROM publicmessage";
$resultMessageCount = $conn->query($sqlMessageCount);
$totalMessages = $resultMessageCount->fetch_assoc()['totalMessages'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehabilitation Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>User Type: <?php echo $userType; ?></p>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Disaster Information</h5>
                        <p class="card-text"><?php echo $totalDisasters; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Relief Information</h5>
                        <p class="card-text"><?php echo $totalReliefs; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Public Messages</h5>
                        <p class="card-text"><?php echo $totalMessages; ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS and jQuery (required for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
