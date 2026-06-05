<?php
session_start();

include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize user inputs (add more validation as needed)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($password);

    $hashedPassword = ($password);

    // Check user credentials and status in the database
    $sql = "SELECT UserID, UserType, Status FROM User WHERE Email = '$email' AND Password = "YOUR_OWN_API_KEY"";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User is found, check user status
        $row = $result->fetch_assoc();
        $userStatus = $row['Status'];

        if ($userStatus == 'Approved') {
            // Set session variables and redirect based on user type
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['UserType'] = $row['UserType'];

            if ($_SESSION['UserType'] == 'Rehabilitation Institutes') {
                header("Location: ./rehab/rehabilitation_home.php");
            } elseif ($_SESSION['UserType'] == 'General User') {
                header("Location: ./user/general_user_home.php");
            } else {
                echo "Invalid User";
            }
            exit();
        } else {
            $login_error = "Your account is not approved. Please contact the administrator.";
        }
    } else {
        $login_error = "Invalid email or password";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-4">

        <?php echo isset($login_error) ? "<div class='alert alert-danger'>$login_error</div>" : ""; ?>
<h1>User Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
