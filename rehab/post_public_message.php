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
$sql = "SELECT Username, UserType FROM User WHERE UserID = '$userID'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $username = $user['Username'];
} else {
    // Handle error if user not found
    $username = "Error";
}

// Handle public message posting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $messageText = $_POST['message'];

    // Validate and sanitize inputs (add more validation as needed)
    $title = htmlspecialchars($title);
    $messageText = htmlspecialchars($messageText);

    // Insert new public message into the PublicMessage table
    $insertSql = "INSERT INTO PublicMessage (InstituteID, Title, Message, DatePosted)
                  VALUES ('$userID', '$title', '$messageText', NOW())";

    if ($conn->query($insertSql) === TRUE) {
        $postMessageSuccess = "Public message posted successfully!";
    } else {
        $postMessageError = "Error posting public message: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Public Message</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>Post Public Message</h2>

        <?php
        // Display post message success message
        if (isset($postMessageSuccess)) {
            echo "<p class='text-success'>{$postMessageSuccess}</p>";
        }

        // Display post message error message
        if (isset($postMessageError)) {
            echo "<p class='text-danger'>{$postMessageError}</p>";
        }
        ?>

        <!-- Public message posting form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Post Public Message</button>
        <a href="view_public_messages.php" class="btn btn-secondary">View Messages</a>

        </form>

        <br>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

