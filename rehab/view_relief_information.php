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

// Fetch relief information added by the currently logged-in user
$sqlRelief = "SELECT ReliefID, Title, Description, DateGranted, Amount, Status FROM ReliefInformation WHERE RehabInstituteID = '$userID'";
$resultRelief = $conn->query($sqlRelief);

// Handle relief information deletion
if (isset($_GET['delete_relief'])) {
    $reliefIDToDelete = $_GET['delete_relief'];
    
    // Perform relief information deletion
    $deleteSql = "DELETE FROM ReliefInformation WHERE ReliefID = '$reliefIDToDelete' AND RehabInstituteID = '$userID'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: view_relief_information.php");
        exit();
    } else {
        $deleteError = "Error deleting relief information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Relief Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>Relief Information</h2>

        <?php
        // Display relief information records
        if ($resultRelief->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Relief ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date Granted</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $resultRelief->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['ReliefID']}</td>
                        <td>{$row['Title']}</td>
                        <td>{$row['Description']}</td>
                        <td>{$row['DateGranted']}</td>
                        <td>{$row['Amount']}</td>
                        <td>{$row['Status']}</td>
                        <td>
                            <a href='edit_relief_information.php?relief_id={$row['ReliefID']}' class='btn btn-warning'>Edit</a>
                            <a href='view_relief_information.php?delete_relief={$row['ReliefID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this relief information?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No relief information found.</p>";
        }

        // Display delete error if any
        if (isset($deleteError)) {
            echo "<p style='color: red;'>{$deleteError}</p>";
        }
        ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
