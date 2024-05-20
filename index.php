<?php

include ("connection.php");

if (isset($_POST['login'])) {
    $stdId = $_POST['stdId'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Corrected the SQL query syntax
    $query = "SELECT * FROM tbl_student WHERE stdId = '$stdId' AND email = '$email' AND password = '$password'";
    $data = mysqli_query($conn, $query);

    if (mysqli_num_rows($data) == 1) {
        header("Location: result/publishResult.php?stdId=$stdId");
    } else {
        echo "Invalid login credentials";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            margin: 0;
            padding: 0;
            height: 100vh;


        }


        header {
            font-size: 28px;
            font-weight: bold;
            width: 100%;
            padding: 30px;
            background-color: #0072ff;
            color: #fff;
            text-align: center;

        }

        header p{
            font-size: 15px;
        }


        /* Container for the login form */
        .container {
            margin-top: 80px;
            margin-left: 40%;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            width: 90%;
            box-sizing: border-box;

        }

        /* Label styling */
        .container label {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: inline-block;
        }

        /* Form styling */
        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: ce;
        }

        /* Input fields styling */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Button styling */
        .button {
            width: 100%;
            background: #0072ff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button:hover {
            background: #005bb5;
        }

        .button:active {
            transform: scale(0.95);
        }

        /* Media queries for responsiveness */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            .container label {
                font-size: 16px;
            }

            input[type="text"],
            input[type="password"] {
                font-size: 14px;
                padding: 8px;
            }

            .button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>


    <header>Student Result Management System
        <p>  <marquee behavior="alternate" direction="slide">View Student Result Via Valid Login</marquee></p>
      
    </header>

    <div class="container">
        <label for="login-page">Student Login Section</label>
        <hr>
        <br><br>
        <div class="form">
            <form action="#" method="POST">
                <label for="stdId">Student ID</label>
                <input type="text" name="stdId" required />
                <label for="email">Email</label>
                <input type="text" name="email" required />
                <br><br>
                <label for="password">Password</label>
                <input type="password" name="password" required />
                <br>
                <input type="submit" value="Login" class="button" name="login" />
            </form>
        </div>
    </div>

</body>

</html>