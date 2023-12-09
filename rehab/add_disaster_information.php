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

// Handle disaster information addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disasterType = $_POST['disaster_type'];
    $description = $_POST['description'];
    $dateOccurred = $_POST['date_occurred'];
    $location = $_POST['location'];

    // Validate and sanitize inputs (add more validation as needed)
    $disasterType = htmlspecialchars($disasterType);
    $description = htmlspecialchars($description);
    $dateOccurred = htmlspecialchars($dateOccurred);
    $location = htmlspecialchars($location);

    // Insert new disaster information into the DisasterInformation table
    $insertSql = "INSERT INTO DisasterInformation (DisasterType, Description, DateOccurred, Location)
                  VALUES ('$disasterType', '$description', '$dateOccurred', '$location')";

    if ($conn->query($insertSql) === TRUE) {
        $addDisasterSuccess = "Disaster information added successfully!";
    } else {
        $addDisasterError = "Error adding disaster information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Disaster Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">


        <h2>Add Disaster Information</h2>

        <?php
        // Display add disaster success message
        if (isset($addDisasterSuccess)) {
            echo "<p style='color: green;'>{$addDisasterSuccess}</p>";
        }

        // Display add disaster error message
        if (isset($addDisasterError)) {
            echo "<p style='color: red;'>{$addDisasterError}</p>";
        }
        ?>

        <!-- Disaster information addition form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="disaster_type">Disaster Type:</label>
                <input type="text" class="form-control" id="disaster_type" name="disaster_type" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="date_occurred">Date Occurred:</label>
                <input type="date" class="form-control" id="date_occurred" name="date_occurred" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Disaster Information</button>
            <a href="view_disaster_information.php" class="btn btn-secondary">View Disaster Information</a>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

