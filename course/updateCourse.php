<?php
include('../connection.php');

// Retrieve 'courseId' from the query string
$courseId = isset($_GET['courseId']) ? $_GET['courseId'] : null;


// Check if the class name and section were provided
if ($courseId) {
    // Fetch data from the database for the provided courseId
    $query = "SELECT * FROM tbl_course WHERE courseId = '$courseId'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data) > 0) {
        $result = mysqli_fetch_assoc($data);
    } else {
        echo "Error fetching data: " . mysqli_error($conn);
        return;
    }
} else {
    echo "No course Id provided.";
    return;
}

if (isset($_POST['update'])) {
    $newCourseId = $_POST['courseId'];
    $newCourseName = $_POST['courseName'];
    $newShortName = $_POST['shortName'];

    // Construct the SQL query to update the record
    $updateQuery = "UPDATE tbl_course SET 
        courseID = '$newCourseId', 
        courseName = '$newCourseName' ,
        shortName = '$newShortName'
        WHERE courseId = '$courseId'";
       
    // Execute the query and check for success
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: manageCourse.php");
      //  echo "<script>alert('Data updated successfully');</script>";
        // Optionally, redirect or perform other actions upon successful update
    } else {
        echo "<script>alert('Failed to update data');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing head content -->
    <title>Update Student Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional head content -->
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
            /* Padding for navigation */
            background: #333;
            /* Dark gray background */
        }

        .nav a {
            margin-left: 23px;
            display: inline-flex;
            list-style: none;
            color: white;
            /* White text */
            text-decoration: none;
            /* No underline */
            transition: all 0.3s ease;
            /* Smooth transitions */
            margin: 2px;
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

        /* Container Layout */
        .container {
            max-width: 600px;
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
            text-align: center;
            /* Center align text */

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
        <h3>Update Student Course</h3>
    </header>

    <div class="nav">
        <!-- Navigation and breadcrumb -->
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Classes</a></li>
                <li class="breadcrumb-item"><a href="#">Update Class</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h4>Update Student Course</h4>
        <hr>
        <form action="#" method="POST">
            <label for="courseId">Course Id</label>
            <input type="text" name="courseId" value="<?php echo htmlspecialchars($result['courseId']) ?>">

            <label for="courseName">Course Name</label>
            <input type="text" name="courseName" value="<?php echo htmlspecialchars($result['courseName']); ?>" />

            <label for="shortName">Short Name</label>
            <input type="text" name="shortName" value="<?php echo htmlspecialchars($result['shortName']); ?>" />
            <p>Examples: BCA , BIM , BBS , etc.</p>
            

            <input type="submit" name="update" value="Update" />
        </form>
    </div>
    
</body>
</html>
