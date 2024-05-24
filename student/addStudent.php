<?php
include ("../connection.php");
error_reporting(0);

if (isset($_POST['register'])) {
    // Retrieve form data
    $stdId = $_POST['stdId'];
    $stdname = $_POST['stdname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Handling image uploads
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $newFilename = $stdId . '.' . $extension;
    $folder = "images/" . $newFilename;
    move_uploaded_file($tempname, $folder);

    // Server-side validation
    $errors = array();

    if (
        empty($stdname) || empty($stdId) || empty($email) || empty($password) ||
        empty($gender) || empty($phone) || empty($address)
    ) {
        $errors[] = "All form fields must be filled!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (strlen($phone) != 10) {
        $errors[] = "Phone number must be 10 digits";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $stdname)) {
        $errors[] = "Only letters and white space allowed in student name";
    }

    if (!in_array($gender, array('male', 'female', 'other'))) {
        $errors[] = "Invalid gender selection";
    }

    if (!preg_match("/^[0-9]*$/", $phone)) {
        $errors[] = "Only numbers allowed in phone number";
    }

    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $address)) {
        $errors[] = "Only letters, numbers and white space allowed in address";
    }

    if (!isset($_POST['terms'])) {
        $errors[] = "Please agree to terms and conditions";
    }

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        $query = "INSERT INTO tbl_student (stdId, stdname, gender, email, password, phone, address, std_image)
                  VALUES ('$stdId', '$stdname', '$gender', '$email', '$password', '$phone', '$address', '$folder')";
        $data = mysqli_query($conn, $query);

        if ($data) {
            echo "<script>alert('Student information successfully inserted into the database');</script>";
        } else {
            echo "<script>alert('Failed to insert student information into the database');</script>";
        }
    } else {
        // Display errors if there are any
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Global Styling */
        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            /* Light gray background */
        }

        /* Header Styling */
        header {
            background-color: #0072ff;
            /* Dark blue */
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 24px;
            /* Larger text for better visibility */
        }

        /* Navigation Styling */
        .nav {
            padding: 10px 20px;
            background: #333;
        }

        .nav a {
            display: flex;
            margin-left: 30px;
            color: white;
            text-decoration: none;
        }

        .nav a i {
            margin-right: 5px;
            margin-top: 5px;
            font-size: 15px;
        }

        .nav a:hover {
            text-decoration: underline;
            /* Underline on hover */
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            padding: 10px;
            background: none;
            /* No background */
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        /* Main container */
        .main {
            display: flex;
            flex-direction: row;
            /* Side-by-side elements */

        }


        .main .container {
            height: 30%;
            width: 50%
        }


        /* Main content container */
        .container {
            align-items: center;
            justify-content: center;
            max-width: 960px;
            margin: 40px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Form Styling */
        .form {
            margin-bottom: 20px;
        }

        .input_field {
            margin-bottom: 15px;
            /* Space between input fields */
        }

        .input_field label {
            font-weight: bold;
            /* Bold labels */
        }

        .input {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            /* Padding for input fields */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
        }

        .textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 80px;
            /* Default height for text area */
        }

        .custom_select select {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .terms p {
            /* position: absolute; */
            bottom: -35px;
            margin-left: 20px;
            margin-bottom: 30px;



            /* Center checkbox and text */
        }

        /* Button Styling */
        .input_field .btn {
            width: 100%;
            background: #0072ff;
            /* Blue background */
            color: white;
            padding: 10px 20px;
            /* Padding */
            border: none;
            /* No border */
            border-radius: 5px;
            text-transform: uppercase;
        }

        .input_field .btn:hover {
            background: #005bb5;
            /* Darker blue on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main {
                flex-direction: column;
                /* Stacks vertically */
            }

            .dashboard {
                width: 100%;
                /* Full width */
            }

            .container {
                width: 100%;
                /* Full width */
            }

            .textarea {
                height: 60px;
                /* Reduced height */
            }
        }
    </style>
</head>

<body>

    <header>
        <h3>Add Students</h3>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Subjects</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Subjects</a></li>
                <li class="breadcrub-item"><a href="../adminSection/adminLogin.php"><i
                            class="bi bi-box-arrow-right"></i> Logout</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <div class="input_field">
                        <label>Upload Image</label>
                        <input type="file" name="uploadfile" style="width:100%;">
                    </div>

                    <div class="input_field">
                        <label>Student Name</label>
                        <input type="text" class="input" name="stdname">
                    </div>

                    <div class="input_field">
                        <label>Student Id</label>
                        <input type="text" class="input" name="stdId">
                    </div>

                    <div class="input_field">
                        <label>Email</label>
                        <input type="text" class="input" name="email">
                    </div>

                    <div class="input_field">
                        <label>Password</label>
                        <input type="password" class="input" name="password">
                    </div>



                    <div class="input_field">
                        <label>Gender</label>
                        <div class="custom_select">
                            <select name="gender">
                                <option value="Not Selected">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="input_field">
                        <label>Phone</label>
                        <input type="text" class="input" name="phone">
                    </div>

                    <div class="input_field">
                        <label>Address</label>
                        <textarea class="textarea" name="address"></textarea>
                    </div>

                    <div class="input_field terms">
                        <input type="checkbox" name="terms"> <label class="check">Agree to terms and conditions

                        </label>
                    </div>

                    <div class="input_field">
                        <input type="submit" value="Register" class="btn" name="register" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>