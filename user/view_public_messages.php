<?php
session_start();

include('config.php');

// Fetch public messages from the PublicMessage table
$sql = "SELECT * FROM PublicMessage";
$result = $conn->query($sql);
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

    <div class="container mt-4">
        <h1 class="mb-4">Public Messages</h1>

        <div class="row">
            <?php
            // Display public messages records
            if ($result->num_rows > 0) {
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Message ID: {$row['MessageID']}</h5>
                                    <h6 class='card-subtitle mb-2 text-muted'>Institute ID: {$row['InstituteID']}</h6>
                                    <h6 class='card-subtitle mb-2 text-muted'>Title: {$row['Title']}</h6>
                                    <p class='card-text'>{$row['Message']}</p>
                                    <p class='card-text'><strong>Date Posted:</strong> {$row['DatePosted']}</p>
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
                echo "<p class='alert alert-info'>No public messages found.</p>";
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

