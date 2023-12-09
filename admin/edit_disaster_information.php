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

// Fetch disaster information details based on disaster_id from the URL parameter
if (isset($_GET['disaster_id'])) {
    $disasterIDToEdit = $_GET['disaster_id'];
    $editSql = "SELECT * FROM DisasterInformation WHERE DisasterID = '$disasterIDToEdit'";
    $result = $conn->query($editSql);

    if ($result->num_rows == 1) {
        $disaster = $result->fetch_assoc();
        $disasterType = $disaster['DisasterType'];
        $description = $disaster['Description'];
        $dateOccurred = $disaster['DateOccurred'];
        $location = $disaster['Location'];
    } else {
        // Handle error if disaster information not found
        header("Location: view_disaster_information.php");
        exit();
    }
} else {
    // Redirect to view disaster information if disaster_id is not provided
    header("Location: view_disaster_information.php");
    exit();
}

// Handle disaster information update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedDisasterType = $_POST['disaster_type'];
    $updatedDescription = $_POST['description'];
    $updatedDateOccurred = $_POST['date_occurred'];
    $updatedLocation = $_POST['location'];

    // Update disaster information details in the DisasterInformation table
    $updateSql = "UPDATE DisasterInformation
                  SET DisasterType = '$updatedDisasterType',
                      Description = '$updatedDescription',
                      DateOccurred = '$updatedDateOccurred',
                      Location = '$updatedLocation'
                  WHERE DisasterID = '$disasterIDToEdit'";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: view_disaster_information.php");
        exit();
    } else {
        $updateError = "Error updating disaster information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Disaster Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">


        <h2>Edit Disaster Information</h2>

        <?php
        // Display disaster information details in the form for editing
        echo "<form action='edit_disaster_information.php?disaster_id={$disasterIDToEdit}' method='post'>
                <div class='form-group'>
                    <label for='disaster_type'>Disaster Type:</label>
                    <input type='text' class='form-control' id='disaster_type' name='disaster_type' value='$disasterType' required>
                </div>

                <div class='form-group'>
                    <label for='description'>Description:</label>
                    <textarea class='form-control' id='description' name='description' rows='4' required>$description</textarea>
                </div>

                <div class='form-group'>
                    <label for='date_occurred'>Date Occurred:</label>
                    <input type='date' class='form-control' id='date_occurred' name='date_occurred' value='$dateOccurred' required>
                </div>

                <div class='form-group'>
                    <label for='location'>Location:</label>
                    <input type='text' class='form-control' id='location' name='location' value='$location' required>
                </div>

                <button type='submit' class='btn btn-primary'>Update</button>
            </form>";

        // Display update error if any
        if (isset($updateError)) {
            echo "<p style='color: red;'>{$updateError}</p>";
        }
        ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

