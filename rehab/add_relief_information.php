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

// Handle relief information addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reliefTitle = $_POST['title'];
    $reliefDescription = $_POST['description'];
    $reliefDateGranted = $_POST['date_granted'];
    $reliefAmount = $_POST['amount'];

    // Validate and sanitize inputs (add more validation as needed)
    $reliefTitle = htmlspecialchars($reliefTitle);
    $reliefDescription = htmlspecialchars($reliefDescription);
    $reliefDateGranted = htmlspecialchars($reliefDateGranted);
    $reliefAmount = htmlspecialchars($reliefAmount);

    // Insert new relief information into the ReliefInformation table
    $insertSql = "INSERT INTO ReliefInformation (Title, Description, DateGranted, Amount)
                  VALUES ('$reliefTitle', '$reliefDescription', '$reliefDateGranted', '$reliefAmount')";

    if ($conn->query($insertSql) === TRUE) {
        $addReliefSuccess = "Relief information added successfully!";
    } else {
        $addReliefError = "Error adding relief information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Relief Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>Add Relief Information</h2>

        <?php
        // Display add relief success message
        if (isset($addReliefSuccess)) {
            echo "<p style='color: green;'>{$addReliefSuccess}</p>";
        }

        // Display add relief error message
        if (isset($addReliefError)) {
            echo "<p style='color: red;'>{$addReliefError}</p>";
        }
        ?>

        <!-- Relief information addition form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="date_granted">Date Granted:</label>
                <input type="date" class="form-control" id="date_granted" name="date_granted" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Relief Information</button>
            <a href="view_relief_information.php" class="btn btn-secondary">View Relief Information</a>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
