<?php
require("../connection.php");

// Retrieve courseId and subCode from URL parameters
$courseId = isset($_GET['courseId']) ? $_GET['courseId'] : null;
$subCode = isset($_GET['subCode']) ? $_GET['subCode'] : null;

if ($courseId && $subCode) {
    // Fetch data from the database for the provided courseId and subCode
    $query = "SELECT * FROM tbl_course_subject WHERE courseId = '$courseId' AND subCode = '$subCode'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data) > 0) {
        $result = mysqli_fetch_assoc($data);
    } else {
        echo "Error fetching data: " . mysqli_error($conn);
        return;
    }
} else {
    echo "No course Id or subject Code provided.";
    return;
}

if (isset($_POST['update'])) {
    $newCourseId = $_POST['courseId'];
    $newSubCode = $_POST['subCode'];
    $semester = $_POST['semester'];

    // Construct the SQL query to update the record
    $updateQuery = "UPDATE tbl_course_subject SET 
    courseId = '$newCourseId',
    subCode = '$newSubCode',
    semester = '$semester'
    WHERE courseId = '$courseId' AND subCode = '$subCode'";

    // Execute the query and check for success
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: manageCourseSub.php");
        // Optionally, redirect or perform other actions upon successful update
    } else {
        echo "<script>alert('Failed to update data');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course Subject</title>
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

        /* Paragraph Styling */
        p {
            color: #777;
            /* Light gray text */
            font-size: 14px;
            /* Slightly smaller font size */
            text-align: start;
            /* Align left */
            margin-bottom: 15px;
            /* Space below paragraph */
        }

        /* Submit Button Styling */
        input[type="submit"] {

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
        }

        input[type="submit"]:hover {
            background: #388E3C;
            /* Darker green on hover */
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
        <h4>Update Course Subject</h4>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Courses</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Update Courses Subjects</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php
            include('../includes/leftbar.php');
            ?>
        </div>
        <div class="container">
            <h3>Update Courses Subjects</h3>
            <hr>
            <div class="form">
                <form action="#" method="POST">
                    <label for="courseId">Course Id</label>
                    <select name="courseId" id="courseId">
                        <?php
                        $query_course = "SELECT courseId FROM tbl_course";
                        $result_course = mysqli_query($conn, $query_course);
                        while ($row_course = mysqli_fetch_assoc($result_course)) {
                            $selected = ($row_course['courseId'] == $courseId) ? 'selected' : '';
                            echo "<option value='" . $row_course['courseId'] . "' $selected>" . $row_course['courseId'] . "</option>";
                        }
                        ?>
                    </select><br>

                    <label for="subCode">Subject Code</label>
                    <select name="subCode" id="subCode">
                        <?php
                        $query_subject = "SELECT subCode FROM tbl_subjects";
                        $result_subject = mysqli_query($conn, $query_subject);
                        while ($row_subject = mysqli_fetch_assoc($result_subject)) {
                            $selected = ($row_subject['subCode'] == $subCode) ? 'selected' : '';
                            echo "<option value='" . $row_subject['subCode'] . "' $selected>" . $row_subject['subCode'] . "</option>";
                        }
                        ?>
                    </select><br><br>

                    <label for="semester">Semester</label>
                    <select name="semester" id="semester">
                        <option value="Not Selected">Select</option>
                        <option value="1" <?php if ($result['semester'] == '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if ($result['semester'] == '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if ($result['semester'] == '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if ($result['semester'] == '4') echo 'selected'; ?>>4</option>
                        <option value="5" <?php if ($result['semester'] == '5') echo 'selected'; ?>>5</option>
                        <option value="6" <?php if ($result['semester'] == '6') echo 'selected'; ?>>6</option>
                        <option value="7" <?php if ($result['semester'] == '7') echo 'selected'; ?>>7</option>
                        <option value="8" <?php if ($result['semester'] == '8') echo 'selected'; ?>>8</option>
                    </select>
                    <input type="submit" name="update" value="Update" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>
