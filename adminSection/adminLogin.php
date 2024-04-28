<?php
session_start();

if(isset($_SESSION['$username']))
{
    header("loacation:dashboard.php");
}

include("../connection.php");


if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];



    $query = "SELECT * FROM tbl_admin WHERE username='$username' && password = '$password'";

    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);

    if ($total > 0) {

        //<!-- <meta http-equiv="refresh" content = "20; url="http://localhost/crud/display.php" /> -->
        $_SESSION['username'] = $username;

        header("Location:dashboard.php");
        exit();



    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="adminLogin.css">
</head>

<body>
    <div class="container">
        <label for="Login page">Admin Login Section</label>
        <hr>
        <br><br>
        <div class="form">
            <form action="#" method="POST">
                <label for="username">username</label>
                <input type="text" name="username" />
                <br><br>
                <label for="password">password</label>
                <input type="password" name="password">
                <br>
                

                <input type="submit" value="login" class="button" name="login" />
              

            </form>
        </div>

    </div>
</body>

</html>