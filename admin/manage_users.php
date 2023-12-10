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

// Fetch all users from the User table
$sql = "SELECT UserID, Username, Email, ContactInfo, UserType, Status,  Address FROM User";
$result = $conn->query($sql);

// Handle user deletion
if (isset($_GET['delete_user'])) {
    $userIDToDelete = $_GET['delete_user'];
    
    // Perform user deletion
    $deleteSql = "DELETE FROM User WHERE UserID = '$userIDToDelete'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: manage_users.php");
        exit();
    } else {
        $deleteError = "Error deleting user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-3">

        <h2>User List</h2>

        <a href="add_users.php" class="float-right m-3 btn btn-primary">Add Users</a>

        <?php
        // Display user records
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Contact Info</th>
                            <th>User Type</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['UserID']}</td>
                        <td>{$row['Username']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['ContactInfo']}</td>
                        <td>{$row['UserType']}</td>
                        <td>{$row['Address']}</td>
                        <td>{$row['Status']}</td>
                        <td>
                            <a href='edit_user.php?user_id={$row['UserID']}' class='btn btn-warning'>Edit</a>
                            <a href='manage_users.php?delete_user={$row['UserID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No users found.</p>";
        }

        // Display delete error if any
        if (isset($deleteError)) {
            echo "<p style='color: red;'>{$deleteError}</p>";
        }
        ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
