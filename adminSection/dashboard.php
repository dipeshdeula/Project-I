<?php
include("../connection.php");

// Initialize the variable with a default value
$total_students = 0;
$total_courses = 0;
$total_subjects = 0;
$total_results = 0;

// Try to fetch the total number of registered students
$query = "SELECT COUNT(*) AS total_students FROM tbl_student";
$result = mysqli_query($conn, $query);

// Fetch the total number of registered courses
$query1 = "SELECT COUNT(*) AS total_courses FROM tbl_course";
$result1 = mysqli_query($conn, $query1);

// Fetch the total number of registered subjects
$query2 = "SELECT COUNT(*) AS total_subjects FROM tbl_subjects";
$result2 = mysqli_query($conn, $query2);

// Fetch the total number of declared results
$query3 = "SELECT COUNT(*) AS total_results FROM tbl_result WHERE status = 'published'";
$result3 = mysqli_query($conn, $query3);

// Check if the queries executed successfully
if ($result && $result1 && $result2 && $result3) {
    $row = mysqli_fetch_assoc($result);
    $row1 = mysqli_fetch_assoc($result1);
    $row2 = mysqli_fetch_assoc($result2);
    $row3 = mysqli_fetch_assoc($result3);

    if ($row && $row1 && $row2 && $row3) {
        $total_students = $row['total_students'];
        $total_courses = $row1['total_courses'];
        $total_subjects = $row2['total_subjects'];
        $total_results = $row3['total_results'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Management System | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .navbar {
            background: #0072ff;
            color: white;
           
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 30px;
        }

        .navbar h2 {
           margin-left: 20px;
            display:flex;
            justify-content: center;
            text-align: center;
        }

        .dashboard {
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }

        .sidebar {
            width: 25%;
            background: #0072ff;
            color: white;
            padding: 20px;
            height: 100vh;
            overflow: auto;
        }

        .content {
            flex: 1;
            padding: 20px;
            background: white;
            border-left: 1px solid #ccc;
        }

        .card-row {
            display: flex;
            justify-content: space-between;
        }

        .card {
            margin: 10px;
            flex-basis: 18rem;
            flex-grow: 1;
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .card a {
            margin-top: 25px;
        }

        .card:hover {
            box-shadow: 0px 5px 15px #0072ff;
        }

       

        .content h2 {
            font-size: 24px;
            margin-top: 0;
        }

        .content p {
            font-size: 16px;
            color: #333;
        }

     

    </style>
</head>

<body>
    <div class="navbar">
        <h2>Student Result Management System | Admin</h2>
        <a href="#"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="dashboard">
        <div class="sidebar">
          
            <?php include('../includes/leftbar.php'); ?>
        </div>

        <div class="content" id="content-area">
            <?php
            echo "<script>alert('Welcome to the Dashboard');</script>";
            ?>
            <p>Select an item from the sidebar to see detailed information.</p>

            <div class="card-row">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Students</h5>
                        <span class="bg-icon">
                            <i class="fa fa-users"></i>
                        </span>
                        <span class="name">Regd Users: </span><?php echo $total_students; ?>
                        <a href="http://localhost/student_project/student/manageStudent.php" class="btn btn-primary">Manage Students</a>
                    </div>
                </div>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Courses</h5>
                        <span class="bg-icon">
                            <i class="fa fa-book"></i>
                        </span>
                        <span class="name">Regd Courses: </span><?php echo $total_courses; ?>
                        <a href="http://localhost/student_project/course/manageCourse.php" class="btn btn-primary">Manage Courses</a>
                    </div>
                </div>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Subjects</h5>
                        <span class="bg-icon">
                            <i class="fa fa-book"></i>
                        </span>
                        <span class="name">Regd Subjects: </span><?php echo $total_subjects; ?>
                        <a href="http://localhost/student_project/subject/manageSubject.php" class="btn btn-primary">Manage Subjects</a>
                    </div>
                </div>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Results Declared</h5>
                        <span class="bg-icon">
                            <i class="fa fa-check"></i>
                        </span>
                        <span class="name">Results Declared: </span><?php echo $total_results; ?>
                        <a href="http://localhost/student_project/result/manageResult.php" class="btn btn-primary">Manage Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleChildNav(parent) {
            parent.classList.toggle("open");
        }

        function loadContent(page) {
            fetch(page)
                .then(response => response.text())
                .then(data => {
                    const contentArea = document.getElementById("content-area");
                    contentArea.innerHTML = data;
                })
                .catch(error => {
                    console.error("Error loading content:", error);
                    const contentArea = document.getElementById("content-area");
                    contentArea.innerHTML = "<p>Failed to load content. Please try again later.</p>";
                });
        }

        window.onload = function() {
            const alertBox = document.getElementById("welcome-alert");
            if (alertBox) {
                alertBox.classList.add("show");
                setTimeout(() => {
                    alertBox.classList.remove("show");
                }, 5000);
            }
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

