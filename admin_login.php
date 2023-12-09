<?php
session_start();

include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Validate and sanitize admin inputs (add more validation as needed)
    $admin_username = htmlspecialchars($admin_username);
    $admin_password = htmlspecialchars($admin_password);

    $hashedPassword = ($admin_password);

    // Check admin credentials in the database
    $sql = "SELECT AdminID, AdminUsername FROM admin WHERE AdminUsername = '$admin_username' AND AdminPassword = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Admin is found, set session variables and redirect to the admin dashboard
        $row = $result->fetch_assoc();
        $_SESSION['AdminID'] = $row['AdminID'];
        $_SESSION['AdminUsername'] = $row['AdminUsername'];

        header("Location: ./admin/admin_dashboard.php");
        exit();
    } else {
        $login_error = "Invalid admin username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-4">

<h1>Admin Login</h1>
<?php echo isset($login_error) ? "<div class='alert alert-danger'>$login_error</div>" : ""; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="admin_username">Admin Username:</label>
                <input type="text" class="form-control" id="admin_username" name="admin_username" required>
            </div>

            <div class="form-group">
                <label for="admin_password">Admin Password:</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
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
