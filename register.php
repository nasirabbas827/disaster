<?php

include('config.php');

// Initialize variables to store user input
$username = $email = $password = $contact = $usertype = $address = "";
$registration_result = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $usertype = $_POST['usertype'];
    $address = $_POST['address'];

    // Validate and sanitize user inputs (add more validation as needed)
    $username = htmlspecialchars($username);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($password);
    $contact = htmlspecialchars($contact);
    $usertype = htmlspecialchars($usertype);
    $address = htmlspecialchars($address);



    // Insert data into the User table
    $sql = "INSERT INTO User (Username, Email, Password, ContactInfo, UserType, Address)
            VALUES ('$username', '$email', '$password', '$contact', '$usertype', '$address')";

    if ($conn->query($sql) === TRUE) {
        $registration_result = "Registration successful!";
    } else {
        $registration_result = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <?php echo $registration_result; ?>

    <div class="container mt-4">
        <h1>Register Now</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required value="<?php echo $username; ?>">
                </div>
                <div class="col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required value="<?php echo $password; ?>">
                </div>
                <div class="col-md-6">
                    <label for="contact">Contact Info:</label>
                    <input type="text" class="form-control" id="contact" name="contact" required value="<?php echo $contact; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="usertype">User Type:</label>
                    <select class="form-control" id="usertype" name="usertype" required>
                        <option value="Rehabilitation Institutes" <?php echo ($usertype == "Rehabilitation Institutes") ? "selected" : ""; ?>>Rehabilitation Institutes</option>
                        <option value="General User" <?php echo ($usertype == "General User") ? "selected" : ""; ?>>General User</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="4" required><?php echo $address; ?></textarea>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <input type="submit" class="float-right btn btn-primary" value="Register">
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
