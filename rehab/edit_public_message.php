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

// Fetch public message details based on message_id from the URL parameter
if (isset($_GET['message_id'])) {
    $messageIDToEdit = $_GET['message_id'];
    $editSql = "SELECT * FROM PublicMessage WHERE MessageID = '$messageIDToEdit' AND InstituteID = '$userID'";
    $result = $conn->query($editSql);

    if ($result->num_rows == 1) {
        $message = $result->fetch_assoc();
        $title = $message['Title'];
        $messageText = $message['Message'];
    } else {
        // Handle error if public message not found
        header("Location: view_public_messages.php");
        exit();
    }
} else {
    // Redirect to view public messages if message_id is not provided
    header("Location: view_public_messages.php");
    exit();
}

// Handle public message update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedTitle = $_POST['title'];
    $updatedMessageText = $_POST['message'];

    // Update public message details in the PublicMessage table
    $updateSql = "UPDATE PublicMessage
                  SET Title = '$updatedTitle',
                      Message = '$updatedMessageText'
                  WHERE MessageID = '$messageIDToEdit' AND InstituteID = '$userID'";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: view_public_messages.php");
        exit();
    } else {
        $updateError = "Error updating public message: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Public Message</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>Edit Public Message</h2>

        <?php
        // Display public message details in the form for editing
        echo "<form action='edit_public_message.php?message_id={$messageIDToEdit}' method='post'>
                <div class='form-group'>
                    <label for='title'>Title:</label>
                    <input type='text' class='form-control' id='title' name='title' value='$title' required>
                </div>

                <div class='form-group'>
                    <label for='message'>Message:</label>
                    <textarea class='form-control' id='message' name='message' rows='4' required>$messageText</textarea>
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
