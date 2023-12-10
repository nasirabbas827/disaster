<?php
session_start();
include('config.php');

// Check if the admin is logged in
if (!isset($_SESSION['AdminID'])) {
    header("Location: admin_login.php");
    exit();
}

$adminID = $_SESSION['AdminID'];
$adminUsername = $_SESSION['AdminUsername'];

// Query to get total counts
$sqlTotalGeneralUsers = "SELECT COUNT(*) AS total FROM user WHERE UserType = 'General User'";
$resultTotalGeneralUsers = $conn->query($sqlTotalGeneralUsers);
$rowTotalGeneralUsers = $resultTotalGeneralUsers->fetch_assoc();
$totalGeneralUsers = $rowTotalGeneralUsers['total'];

$sqlTotalRehabInstitutes = "SELECT COUNT(*) AS total FROM user WHERE UserType = 'Rehabilitation Institutes'";
$resultTotalRehabInstitutes = $conn->query($sqlTotalRehabInstitutes);
$rowTotalRehabInstitutes = $resultTotalRehabInstitutes->fetch_assoc();
$totalRehabInstitutes = $rowTotalRehabInstitutes['total'];

$sqlTotalDisasterInfo = "SELECT COUNT(*) AS total FROM disasterinformation";
$resultTotalDisasterInfo = $conn->query($sqlTotalDisasterInfo);
$rowTotalDisasterInfo = $resultTotalDisasterInfo->fetch_assoc();
$totalDisasterInfo = $rowTotalDisasterInfo['total'];

$sqlTotalReliefInfo = "SELECT COUNT(*) AS total FROM reliefinformation";
$resultTotalReliefInfo = $conn->query($sqlTotalReliefInfo);
$rowTotalReliefInfo = $resultTotalReliefInfo->fetch_assoc();
$totalReliefInfo = $rowTotalReliefInfo['total'];

// Query to get counts of pending users
$sqlPendingUsers = "SELECT COUNT(*) AS total FROM user WHERE  Status = 'Pending'";
$resultPendingUsers = $conn->query($sqlPendingUsers);
$rowPendingUsers = $resultPendingUsers->fetch_assoc();
$totalPendingUsers = $rowPendingUsers['total'];

// Query to get counts of pending relief information
$sqlPendingReliefInfo = "SELECT COUNT(*) AS total FROM reliefinformation WHERE Status = 'Pending'";
$resultPendingReliefInfo = $conn->query($sqlPendingReliefInfo);
$rowPendingReliefInfo = $resultPendingReliefInfo->fetch_assoc();
$totalPendingReliefInfo = $rowPendingReliefInfo['total'];

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">
        <h1>Welcome, <?php echo $adminUsername; ?>!</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total General Users</h5>
                        <p class="card-text"><?php echo $totalGeneralUsers; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Rehab Institutes</h5>
                        <p class="card-text"><?php echo $totalRehabInstitutes; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Disaster Information</h5>
                        <p class="card-text"><?php echo $totalDisasterInfo; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Relief Information</h5>
                        <p class="card-text"><?php echo $totalReliefInfo; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Pending Users</h5>
                        <p class="card-text"><?php echo $totalPendingUsers; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Pending Relief Information</h5>
                        <p class="card-text"><?php echo $totalPendingReliefInfo; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
