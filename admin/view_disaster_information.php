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

// Fetch all disaster information from the DisasterInformation table
$sql = "SELECT DisasterID, DisasterType, Description, DateOccurred, Location FROM DisasterInformation";
$result = $conn->query($sql);

// Handle disaster information deletion
if (isset($_GET['delete_disaster'])) {
    $disasterIDToDelete = $_GET['delete_disaster'];
    
    // Perform disaster information deletion
    $deleteSql = "DELETE FROM DisasterInformation WHERE DisasterID = '$disasterIDToDelete'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: view_disaster_information.php");
        exit();
    } else {
        $deleteError = "Error deleting disaster information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Disaster Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h1>Welcome, Admin <?php echo $adminUsername; ?>!</h1>

        <h2>Disaster Information</h2>

        <?php
        // Display disaster information records
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Disaster ID</th>
                            <th>Disaster Type</th>
                            <th>Description</th>
                            <th>Date Occurred</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['DisasterID']}</td>
                        <td>{$row['DisasterType']}</td>
                        <td>{$row['Description']}</td>
                        <td>{$row['DateOccurred']}</td>
                        <td>{$row['Location']}</td>
                        <td>
                            <a href='edit_disaster_information.php?disaster_id={$row['DisasterID']}' class='btn btn-warning'>Edit</a>
                            <a href='view_disaster_information.php?delete_disaster={$row['DisasterID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this disaster information?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No disaster information found.</p>";
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
