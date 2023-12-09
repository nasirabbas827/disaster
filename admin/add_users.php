<?php
session_start();

include('config.php');

// Check if the admin is logged in
if (!isset($_SESSION['AdminID'])) {
    header("Location: admin_login.php");
    exit();
}

$adminID = $_SESSION['AdminID'];
$adminUsername = $_SESSION['AdminUsername'];

// Handle user addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $newContact = $_POST['contact'];
    $newUsertype = $_POST['usertype'];
    $newAddress = $_POST['address'];

    // Validate and sanitize user inputs (add more validation as needed)
    $newUsername = htmlspecialchars($newUsername);
    $newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
    $newPassword = htmlspecialchars($newPassword);
    $newContact = htmlspecialchars($newContact);
    $newUsertype = htmlspecialchars($newUsertype);
    $newAddress = htmlspecialchars($newAddress);

    $hashedPassword = ($newPassword);

    // Insert new user into the User table
    $insertSql = "INSERT INTO User (Username, Email, Password, ContactInfo, UserType, Address)
                  VALUES ('$newUsername', '$newEmail', '$hashedPassword', '$newContact', '$newUsertype', '$newAddress')";

    if ($conn->query($insertSql) === TRUE) {
        $addUserSuccess = "User added successfully!";
    } else {
        $addUserError = "Error adding user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Users</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">


        <h2>Add New User</h2>

        <?php
        // Display add user success message
        if (isset($addUserSuccess)) {
            echo "<p style='color: green;'>{$addUserSuccess}</p>";
        }

        // Display add user error message
        if (isset($addUserError)) {
            echo "<p style='color: red;'>{$addUserError}</p>";
        }
        ?>

        <!-- User addition form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="contact">Contact Info:</label>
                    <input type="text" class="form-control" id="contact" name="contact" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="usertype">User Type:</label>
                    <select class="form-control" id="usertype" name="usertype" required>
                        <option value="Rehabilitation Institutes">Rehabilitation Institutes</option>
                        <option value="General User">General User</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
                </div>
            </div>

            <button type="submit" class="float-right btn btn-primary">Add User</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
