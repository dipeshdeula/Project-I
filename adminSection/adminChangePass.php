<?php
session_start();

// Redirect if user is already logged in
if(isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

include("../connection.php");

if (isset($_POST['changePassword'])) {
    // Retrieve form data
    $username = $_SESSION['username']; // Use the username from session
    $currentPass = $_POST['currentPass'];
    $newpassword = $_POST['newpassword'];
    $confirmNewpassword = $_POST['ConNewpassword'];

    // Validate if new passwords match
    if ($newpassword != $confirmNewpassword) {
        echo "<script>alert('New passwords do not match');</script>";
        exit();
    }

    // Query to check if current password matches
    $query = "SELECT * FROM tbl_admin WHERE username='$username' AND password = '$currentPass'";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);

    if ($total > 0) {
        // Update password if current password matches
        $updateQuery = "UPDATE tbl_admin SET password = '$newpassword' WHERE username='$username'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Password changed successfully');</script>";
        } else {
            echo "<script>alert('Failed to change password');</script>";
        }
    } else {
        echo "<script>alert('Invalid current password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Change Password</title>
    <link rel="stylesheet" href="adminLogin.css">
</head>

<body>
    <div class="container">
        <label for="Login page">Admin Change Password</label>
        <hr>
        <br><br>
        <div class="form">
            <form action="adminChangePass.php" method="POST"> <!-- Corrected form action -->
                <label for="password">Current Password</label>
                <input type="password" name="currentPass" required /> <!-- Added required attribute for form validation -->
                <br><br>
                <label for="password">New Password</label>
                <input type="password" name="newpassword" required /> <!-- Added required attribute for form validation -->
                <br>
                <label for="password">Confirm New Password</label>
                <input type="password" name="ConNewpassword" required /> <!-- Added required attribute for form validation -->
                <br>
                <input type="submit" value="Change Password" class="button" name="changePassword" /> <!-- Changed button name -->
            </form>
        </div>
    </div>
</body>

</html>
