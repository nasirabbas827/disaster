<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Information System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .jumbotron {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./img/Img.jpg') center/cover;
            color: #fff;
            padding: 100px 0;
            text-align: center;
            height: 550px;
        }

        .jumbotron h1 {
            font-size: 3em;
            font-weight: bolder;
        }

        .jumbotron p {
            font-size: 1.5em;
            margin-bottom: 30px;
        }

        .jumbotron .btn {
            font-size: 1.2em;
            padding: 15px 30px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <?php include('navbar.php'); ?>

    <!-- Jumbotron Section -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Welcome to Disaster Information System</h1>
            <p class="lead">Empowering communities through timely information and resources.</p>
            <a href="#" class="btn btn-primary btn-lg">Learn More</a>
        </div>
    </div>
    <?php include('config.php'); ?>

<!-- Disaster Information Section -->
<div class="container mt-4">
    <h2>Latest Disaster Information</h2>
    <div class="row">
        <?php
        // Fetch and display Disaster Information dynamically
        $sqlDisaster = "SELECT * FROM disasterinformation ORDER BY DateOccurred DESC LIMIT 3";
        $resultDisaster = $conn->query($sqlDisaster);

        if ($resultDisaster->num_rows > 0) {
            while ($disaster = $resultDisaster->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$disaster['DisasterType']}</h5>
                                <p class='card-text'>{$disaster['Description']}</p>
                                <p class='card-text'><strong>Date Occurred:</strong> {$disaster['DateOccurred']}</p>
                                <p class='card-text'><strong>Location:</strong> {$disaster['Location']}</p>
                            </div>
                        </div>
                    </div>";
            }
        } else {
            echo "<p>No disaster information found.</p>";
        }
        ?>
    </div>
</div>

<!-- Public Messages Section -->
<div class="container mt-4">
    <h2>Public Messages</h2>
    <div class="row">
        <?php
        // Fetch and display Public Messages dynamically
        $sqlPublicMessages = "SELECT * FROM publicmessage ORDER BY DatePosted DESC LIMIT 3";
        $resultPublicMessages = $conn->query($sqlPublicMessages);

        if ($resultPublicMessages->num_rows > 0) {
            while ($message = $resultPublicMessages->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$message['Title']}</h5>
                                <p class='card-text'>{$message['Message']}</p>
                                <p class='card-text'><strong>Date Posted:</strong> {$message['DatePosted']}</p>
                            </div>
                        </div>
                    </div>";
            }
        } else {
            echo "<p>No public messages found.</p>";
        }
        ?>
    </div>
</div>

<?php include('config.php'); ?>
<!-- Contact Us Section -->
<div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Contact Us</h2>
                <p>If you have any questions or concerns, feel free to contact us.</p>
                <p>Email: info@disasterinfo.com</p>
                <p>Phone: +1 (123) 456-7890</p>
            </div>
            <div class="col-md-6">
                <!-- Contact Us Form (Add your form handling logic here) -->
                <form action="contact_us.php" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

<!-- Footer -->
<footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>Contact Us</h4>
                    <p>Email: info@example.com</p>
                    <p>Phone: +123 456 7890</p>
                </div>
                <div class="col-md-6">
                    <h4>Follow Us</h4>
                    <!-- Add your social media icons or links here -->
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS and Popper.js (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>