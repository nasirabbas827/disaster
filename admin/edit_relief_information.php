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

// Fetch relief information details based on relief_id from the URL parameter
if (isset($_GET['relief_id'])) {
    $reliefIDToEdit = $_GET['relief_id'];
    $editSql = "SELECT * FROM ReliefInformation WHERE ReliefID = '$reliefIDToEdit'";
    $result = $conn->query($editSql);

    if ($result->num_rows == 1) {
        $relief = $result->fetch_assoc();
        $title = $relief['Title'];
        $description = $relief['Description'];
        $dateGranted = $relief['DateGranted'];
        $amount = $relief['Amount'];
    } else {
        // Handle error if relief information not found
        header("Location: view_relief_information.php");
        exit();
    }
} else {
    // Redirect to view relief information if relief_id is not provided
    header("Location: view_relief_information.php");
    exit();
}

// Handle relief information update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedTitle = $_POST['title'];
    $updatedDescription = $_POST['description'];
    $updatedDateGranted = $_POST['date_granted'];
    $updatedAmount = $_POST['amount'];

    // Update relief information details in the ReliefInformation table
    $updateSql = "UPDATE ReliefInformation
                  SET Title = '$updatedTitle',
                      Description = '$updatedDescription',
                      DateGranted = '$updatedDateGranted',
                      Amount = '$updatedAmount'
                  WHERE ReliefID = '$reliefIDToEdit'";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: view_relief_information.php");
        exit();
    } else {
        $updateError = "Error updating relief information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Relief Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">


        <h2>Edit Relief Information</h2>

        <?php
        // Display relief information details in the form for editing
        echo "<form action='edit_relief_information.php?relief_id={$reliefIDToEdit}' method='post'>
                <div class='form-group'>
                    <label for='title'>Title:</label>
                    <input type='text' class='form-control' id='title' name='title' value='$title' required>
                </div>

                <div class='form-group'>
                    <label for='description'>Description:</label>
                    <textarea class='form-control' id='description' name='description' rows='4' required>$description</textarea>
                </div>

                <div class='form-group'>
                    <label for='date_granted'>Date Granted:</label>
                    <input type='date' class='form-control' id='date_granted' name='date_granted' value='$dateGranted' required>
                </div>

                <div class='form-group'>
                    <label for='amount'>Amount:</label>
                    <input type='number' class='form-control' id='amount' name='amount' step='0.01' value='$amount' required>
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

