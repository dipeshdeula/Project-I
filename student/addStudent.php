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
            font-family: 'Arial', sans-serif;
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
            padding: 15px 20px;
            /* Increased padding for a fuller look */
            text-align: center;
            font-size: 24px;
            /* Larger text for better visibility */
            overflow: hidden;
        }

        /* Navigation Styling */
        .nav {
            padding: 10px 20px;
            /* Padding around navigation */
            background: #333;
            /* Dark gray background */
            overflow: hidden;
        }

        .nav a {
            color: white;
            /* White text color */
            text-decoration: none;
            /* No underline */
            transition: all 0.3s ease;
        }

        .nav a:hover {
            text-decoration: underline;
            /* Underline on hover */
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            padding: 10px;
            /* Padding inside breadcrumb */
            background: none;
            /* No background */
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        /* Main container for dashboard and content */
        .main {
            display: flex;
            /* Flexbox layout */
            flex-direction: row;
            /* Elements should be side-by-side */
            align-items: flex-start;
            /* Align at the top */
            justify-content: flex-start;
            /* No extra space between elements */
            padding: 20px;
            /* Ensure some padding around the layout */
        }

        /* Dashboard Sidebar */
        .dashboard {
            
            width: 20%;
            /* Sidebar occupies 20% of the total width */
            background: #f0f0f0;
            /* Light gray background */
            padding: 20px;
            /* Padding for spacing */
            box-sizing: border-box;
            /* Ensure padding is included in the width */
            background-color: yellow;
        }

        /* Main content container */
        .container {
            flex: 1;
            /* Takes the rest of the space */
            padding: 20px;
            /* Padding around the content */
            background: white;
            /* Background color */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow for depth */
            width: 10%;
        }



        /* Form Styling */
        .form {
            margin-bottom: 20px;
            /* Space below form */
        }

        .input_field {
            margin-bottom: 15px;
            /* Space between input fields */
        }

        .input_field label {
            font-weight: bold;
            /* Bold labels for emphasis */
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
            box-sizing: border-box;
            /* Include padding in width */
        }

        .textarea {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            /* Padding for text area */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            box-sizing: border-box;
            /* Include padding in width */
            height: 80px;
            /* Default height for text area */
        }

        .custom_select select {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            /* Padding for select fields */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            box-sizing: border-box;
            /* Include padding in width */
        }

        .terms p {

            display: flex;
            /* Use flexbox for alignment */
            align-items: center;
            /* Center checkbox and text */
            margin: 0px 12px;
        }

        .checkmark {
            width: 20px;
            /* Checkbox size */
            height: 20px;
            border: 2px solid #0072ff;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
        }

        .checkmark input {
            opacity: 0;
            /* Hide default checkbox */
        }

        .checkmark:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 10px;
            height: 10px;
            background: #0072ff;
            /* Background color for checked */
            display: none;
            /* Initially hidden */
        }

        .check input:checked+.checkmark:after {
            display: block;
            /* Show when checked */
        }

        .btn {
            background: #0072ff;
            /* Blue background */
            color: white;
            /* White text color */
            padding: 10px 20px;
            /* Padding for button */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            text-transform: uppercase;
            /* Capitalize text */
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #005bb5;
            /* Darker blue on hover */
        }

        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            main {
                flex-direction: column;
                /* Stacks elements vertically */
            }

            .dashboard {
                width: 100%;
                /* Sidebar takes full width on smaller screens */
            }

            .container {
                width: 100%;
                /* Container also takes full width */
            }

            .breadcrumb {
                font-size: 14px;
                /* Smaller font size */
            }

            .input_field {
                margin-bottom: 10px;
                /* Reduce space for smaller screens */
            }

            .input {
                padding: 6px 10px;
                /* Adjust padding for smaller screens */
            }

            .textarea {
                height: 60px;
                width: auto;
                resize: none;
                /* Reduce height for smaller screens */
            }
        }
    </style>
</head>

<body>

    <header>

        <h3>Add Students </h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Students</a></li>
                <li class="breadcrumb-item"><a href="#">Add Students</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="title">Insert Student Details</div>


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
                        <label>Class Name</label>
                        <input type="text" class="input" name="classname">
                    </div>
                    <!-- <div class="input_field">
                    <label for="className">Class</label>
                    <div class="custom_select">
                        <select name="className" id="className">
                            <option value="Not Selected">Select</option>
                            <option value="className">

                            </option>
                        </select>
                    </div>

                </div> -->

                    <div class="input_field">
                        <label>Gender</label>
                        <div class="custom_select">
                            <select name="gender">
                                <option value="Not Selected">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other's">Other's</option>
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
                        <!-- <button type="submit" name="register" class="btn" value="Register"> Register</button> -->

                    </div>
                </div>
            </form>
        </div>

    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

<?php

include ("../connection.php");
error_reporting(0);
if (isset($_POST['register'])) {
    //for uploading images

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "images/" . $filename;
    move_uploaded_file($tempname, $folder);

    $stdname = $_POST['stdname'];
    $stdId = $_POST['stdId'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $classname = $_POST['classname'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    //connect database




    //server side validation

    if (
        $stdname == null && $stdId == null && $email == null
        && $password == null && $classname == null && $gender == null
        && $phone == null && $address == null
    ) {

        echo "<script>alert('all form required to filled!!');</script>";
    } else {
        //data insert into the database

        $query = "INSERT INTO tbl_student (std_image,stdname,stdId,
       email,password,classname,gender, phone,address)
        VALUES 
        ('$folder', '$stdname', '$stdId', '$email', '$password','$classname' ,'$gender',
       '$phone','$address')";

        // echo $query;
        $data = mysqli_query($conn, $query);

        $result = mysqli_num_rows($data);

        if ($result > 0) {
            echo "<script>alert('Student Info inserted into the Database');</script>";
        } else {
            echo "<script>alert('failed to insert data into the Database');</script>";
        }
    }


}



?>