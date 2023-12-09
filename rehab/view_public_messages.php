<?php
session_start();

include('config.php');

// Check if the user is logged in as Rehabilitation Institute
if (!isset($_SESSION['UserID']) || $_SESSION['UserType'] !== 'Rehabilitation Institutes') {
    header("Location: login.php");
    exit();
}

// Fetch user information based on the session
$userID = $_SESSION['UserID'];
$sql = "SELECT Username FROM User WHERE UserID = '$userID'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $username = $user['Username'];
} else {
    // Handle error if user not found
    $username = "Error";
}

// Fetch all public messages from the PublicMessage table for the current institute
$publicMessagesSql = "SELECT MessageID, Title, Message, DatePosted FROM PublicMessage WHERE InstituteID = '$userID'";
$publicMessagesResult = $conn->query($publicMessagesSql);

// Handle public message deletion
if (isset($_GET['delete_message'])) {
    $messageIDToDelete = $_GET['delete_message'];
    
    // Perform public message deletion
    $deleteSql = "DELETE FROM PublicMessage WHERE MessageID = '$messageIDToDelete' AND InstituteID = '$userID'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: view_public_messages.php");
        exit();
    } else {
        $deleteError = "Error deleting public message: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Public Messages</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>Public Messages</h2>

        <?php
        // Display public messages records
        if ($publicMessagesResult->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>Message ID</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Date Posted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $publicMessagesResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['MessageID']}</td>
                        <td>{$row['Title']}</td>
                        <td>{$row['Message']}</td>
                        <td>{$row['DatePosted']}</td>
                        <td>
                            <a href='edit_public_message.php?message_id={$row['MessageID']}' class='btn btn-info btn-sm'>Edit</a>
                            <a href='view_public_messages.php?delete_message={$row['MessageID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this public message?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No public messages found.</p>";
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
