<?php
require ("../connection.php");

// Fetch courseId and subjectCode data from tbl_course and tbl_subjects
$query_course = "SELECT courseId FROM tbl_course";
$query_subject = "SELECT subCode FROM tbl_subjects";

$result_course = mysqli_query($conn, $query_course);
$result_subject = mysqli_query($conn, $query_subject);



if (!$result_course || !$result_subject) {
    // Redirect if there's an error in fetching data
    echo "Error fetching course or subject data";
    exit();
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    var_dump($_POST);
    $courseId = $_POST['courseId'];
    $subCode = $_POST['subCode'];
    $semester = $_POST['semester'];

    // Check if the selected courseId exists in tbl_course
    $courseIdExistsQuery = "SELECT courseId FROM tbl_course WHERE courseId = '$courseId'";
    $courseIdExistsResult = mysqli_query($conn, $courseIdExistsQuery);
    var_dump($courseIdExistsResult, mysqli_num_rows($courseIdExistsResult));


    // Check if the selected subCode exists in tbl_subjects
    $subCodeExistsQuery = "SELECT subCode FROM tbl_subjects WHERE subCode = '$subCode'";
    $subCodeExistsResult = mysqli_query($conn, $subCodeExistsQuery);
    var_dump($subCodeExistsResult, mysqli_num_rows($subCodeExistsResult));

    if (!$subCodeExistsResult || mysqli_num_rows($subCodeExistsResult) === 0) {
        // Redirect if the selected subCode doesn't exist
        echo "Erorr=Selected subject code does not exist";
        exit();
    }

    // Insert data into tbl_course_subjects
    $query_insert = "INSERT INTO tbl_course_subject(courseId, subCode, semester) 
    VALUES ('$courseId', '$subCode', '$semester')";
    if (mysqli_query($conn, $query_insert)) {
        echo "<script>alert('Course subject created successfully'); window.location='manageCourseSub.php';</script>";
    } else {
        echo "<script>alert('Error creating course subject: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course Subject</title>
    <style>
        /* Global Styling */
        body {
            font-family: 'poppins';
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
            /* White text */
            padding: 10px;
            /* Adequate padding */
            text-align: center;
            /* Center align text */
            font-size: 24px;
            /* Larger font size */

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
            /* Padding for breadcrumb */
            background: none;
            /* No background */
            margin-bottom: 15px;
            /* Space below breadcrumb */
            text-decoration: none;

        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        .main {
            display: flex;
            flex-direction: row;

        }

        .dashboard {
            width: auto;
            margin-right: 10px;
        }

        .main .container {
            width: 50%;
            height: 50%;
            align-items: center;
            justify-content: center;
        }

        /* Container Layout */
        .container {
            width: 50 max-width: 600px;
            /* Moderate width */
            margin: 5% auto;
            /* Center the container */
            padding: 30px;
            /* Adequate padding */
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */


        }

        /* Form Styling */
        .form {
            display: flex;
            /* Use flexbox */
            flex-direction: column;
            /* Vertical alignment */
            align-items: stretch;
            /* Align to container's width */
        }

        /* Label Styling */
        label {
            font-weight: bold;
            /* Bold text for labels */
            color: #555;
            /* Dark gray color */
            margin-bottom: 10px;
            /* Space below labels */
        }

        select {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        input[type="text"] {
            width: 100%;
            /* Full width */
            padding: 12px;
            /* Adequate padding */
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Adequate font size */
            transition: all 0.3s ease;
            /* Smooth transitions */
        }

        input[type="text"]:focus {
            border-color: #0072ff;
            /* Blue border on focus */
            outline: none;
            /* No default outline */
        }

    
        /* Submit Button Styling */
        input[type="submit"]  {

            background: #0072ff;
            /* dark blue background */
            color: white;
            /* White text */
            padding: 12px;
            /* Adequate padding */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Consistent font size */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: all 0.3s ease;
            /* Smooth transitions */
            width: 100%;
            /* Full width */

            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background: #005bb5;
            /* Darker blue on hover */
        }

        input[type="submit"]:active {
            transform: scale(0.95);
            /* Slight shrink on click (active state) */
        }

        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                /* Reduced padding for smaller screens */
                max-width: 100%;
                /* Full width on smaller screens */
            }

            input[type="text"] {
                padding: 10px;
                /* Adjusted padding */
                font-size: 14px;
                /* Smaller font size */
            }

            input[type="submit"] {
                padding: 10px 16px;
                /* Adjusted padding */
                font-size: 14px;
                /* Smaller font size */
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
                /* Further reduced padding */
            }

            .form {
                flex-direction: column;
                /* Stack form elements */
                align-items: stretch;
                /* Align to full width */
            }

            input[type="text"] {
                padding: 8px 10px;
                /* Smaller padding */
            }
        }
    </style>
</head>

<body>
    <header>
        <h4>Create Course Subject</h4>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Courses</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Create Courses Subjects</a></li>
                <li class="breadcrub-item"><a href="../adminSection/adminLogin.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php
            include ('../includes/leftbar.php');
            ?>
        </div>
        <div class="container">
            <h3>Create Courses Subjects</h3>
            <hr>
            <div class="form">
                <form action="#" method="POST">
                    <div class="select_field">
                        <label for="courseId">Course Id</label>
                        <select name="courseId" id="courseId">

                            <?php
                            while ($row_course = mysqli_fetch_assoc($result_course)) {
                                echo "<option value='" . $row_course['courseId'] . "'>" . $row_course['courseId'] . "</option>";
                            }
                            ?>
                        </select>

                    </div>

                    <div class="select_field">
                        <label for="subCode">Subject Code</label>
                        <select name="subCode" id="subCode">
                            <?php
                            while ($row_subject = mysqli_fetch_assoc($result_subject)) {
                                echo "<option value='" . $row_subject['subCode'] . "'>" . $row_subject['subCode'] . "</option>";
                            }
                            ?>
                        </select>

                    </div>

                    <div class="select_field">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester">
                            <option value="Not Selected">Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>

                    </div>

                   
                        <input type="submit" name="submit" />

                

                </form>
            </div>
        </div>
    </div>
</body>

</html>