<?php
session_start();

include('config.php');

// Fetch relief information from the ReliefInformation table with status "Granted" and associated username
$sql = "SELECT r.*, u.Username 
        FROM ReliefInformation r
        JOIN User u ON r.RehabInstituteID = u.UserID
        WHERE r.Status = 'Granted'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relief Information</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h1 class="mb-4">Relief Information</h1>

        <div class="row">
            <?php
            // Display relief information records
            if ($result->num_rows > 0) {
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Relief ID: {$row['ReliefID']}</h5>
                                    <h6 class='card-subtitle mb-2 text-muted'>Title: {$row['Title']}</h6>
                                    <p class='card-text'>{$row['Description']}</p>
                                    <p class='card-text'><strong>Date Granted:</strong> {$row['DateGranted']}</p>
                                    <p class='card-text'><strong>Amount:</strong> {$row['Amount']}</p>
                                    <p class='card-text'><strong>Rehablitiation Institute Name::</strong> {$row['Username']}</p>
                                </div>
                            </div>
                        </div>";

                    // Check if three cards have been displayed in a row
                    $count++;
                    if ($count % 3 == 0) {
                        echo '</div><div class="row">';
                    }
                }
            } else {
                echo "<p class='alert alert-info'>No relief information found.</p>";
            }
            ?>
        </div>

    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
