<?php
session_start();

include('config.php');

// Check if the admin is logged in
if (!isset($_SESSION['AdminID'])) {
    header("Location: ../admin_login.php");
    exit();
}

$adminID = $_SESSION['AdminID'];
$adminUsername = $_SESSION['AdminUsername'];

// Fetch user details based on user_id from the URL parameter
if (isset($_GET['user_id'])) {
    $userIDToEdit = $_GET['user_id'];
    $editSql = "SELECT * FROM User WHERE UserID = '$userIDToEdit'";
    $result = $conn->query($editSql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $username = $user['Username'];
        $email = $user['Email'];
        $contact = $user['ContactInfo'];
        $usertype = $user['UserType'];
        $address = $user['Address'];
    } else {
        // Handle error if user not found
        header("Location: manage_users.php");
        exit();
    }
} else {
    // Redirect to admin panel if user_id is not provided
    header("Location: manage_users.php");
    exit();
}

// Handle user update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedUsername = $_POST['username'];
    $updatedEmail = $_POST['email'];
    $updatedContact = $_POST['contact'];
    $updatedUsertype = $_POST['usertype'];
    $updatedAddress = $_POST['address'];

    // Update user details in the User table
    $updateSql = "UPDATE User
                  SET Username = '$updatedUsername',
                      Email = '$updatedEmail',
                      ContactInfo = '$updatedContact',
                      UserType = '$updatedUsertype',
                      Address = '$updatedAddress'
                  WHERE UserID = '$userIDToEdit'";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: manage_users.php");
        exit();
    } else {
        $updateError = "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>Edit User</h2>

        <?php
        // Display user details in the form for editing
        echo "<form action='edit_user.php?user_id={$userIDToEdit}' method='post'>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='username'>Username:</label>
                            <input type='text' class='form-control' id='username' name='username' value='$username' required>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='email'>Email:</label>
                            <input type='email' class='form-control' id='email' name='email' value='$email' required>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='contact'>Contact Info:</label>
                            <input type='text' class='form-control' id='contact' name='contact' value='$contact' required>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='usertype'>User Type:</label>
                            <select class='form-control' id='usertype' name='usertype' required>
                                <option value='Rehabilitation Institutes' " . ($usertype == 'Rehabilitation Institutes' ? 'selected' : '') . ">Rehabilitation Institutes</option>
                                <option value='General User' " . ($usertype == 'General User' ? 'selected' : '') . ">General User</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='form-group'>
                    <label for='address'>Address:</label>
                    <textarea class='form-control' id='address' name='address' rows='4' required>$address</textarea>
                </div>

                <button type='submit' class='btn btn-primary'>Update</button>
            </form>";

        // Display update error if any
        if (isset($updateError)) {
            echo "<p style='color: red;'>{$updateError}</p>";
        }
        ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
