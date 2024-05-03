<?php
include ("../connection.php");
error_reporting(0);

if (isset($_POST['register'])) {
    // Handling image uploads
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "images/" . $filename;
    move_uploaded_file($tempname, $folder);

    // Retrieve form data
    $stdname = $_POST['stdname'];
    $stdId = $_POST['stdId'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $classname = $_POST['className'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Server-side validation
    if (
        empty($stdname) || empty($stdId) || empty($email) || empty($password) ||
        $classname == 'Not Selected' || empty($gender) || empty($phone) || empty($address)
    ) {
        echo "<script>alert('All form fields must be filled!');</script>";
    } else {
        // Insert student data into the database
        $query = "INSERT INTO tbl_student (std_image, stdname, stdId, email, password, classname, gender, phone, address) 
                  VALUES ('$folder', '$stdname', '$stdId', '$email', '$password', '$classname', '$gender', '$phone', '$address')";
        $data = mysqli_query($conn, $query);

        if ($data) {
            echo "<script>alert('Student information successfully inserted into the database');</script>";
        } else {
            echo "<script>alert('Failed to insert student information into the database');</script>";
        }
    }
}

// Fetch class names from tbl_classes to populate the dropdown
$query = "SELECT className FROM tbl_classes";
$data = mysqli_query($conn, $query);
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

        /* Button Styling */
        .input_field   .btn {
            width:100%;
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

        .input_field  .btn:hover {
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
                        <label for="className">Class Name</label>
                        <div class="custom_select">
                            <select name="className" id="className">
                                <option value="Not Selected">Select</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($data)) {
                                    echo "<option value=\"{$row['className']}\">{$row['className']}</option>";
                                }
                                ?>
                            </select>
                        </div>
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
                        <label class="check">
                            <input type="checkbox">
                            <p>Agree to terms and conditions</p>
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