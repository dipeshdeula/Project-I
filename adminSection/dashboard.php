<?php
include ("../connection.php");

// Initialize the variable with a default value
$total_students = 0; // Default value in case of query failure
$total_subjects = 0;
$total_class = 0;
$total_results = 0;

// Try to fetch the total number of registered students
$query = "SELECT COUNT(*) AS total_students FROM tbl_student";
$result = mysqli_query($conn, $query);

//fetch the total number of registered subjects
$query1 = "SELECT COUNT(*) AS total_subjects FROM tbl_subjects";
$result1 = mysqli_query($conn, $query1);

//fetch the total number of registered class
$query2 = "SELECT COUNT(*) AS total_class From tbl_classes";
$result2 = mysqli_query($conn, $query2);
// Check if the query executed successfully
if ($result && $result1 && $result2) {
    // Fetch the data
    $row = mysqli_fetch_assoc($result);
    $row1 = mysqli_fetch_assoc($result1);
    $row2 = mysqli_fetch_assoc($result2);
    if ($row && $row1 && $row2) {
        // Assign the total count
        $total_students = $row['total_students'];
        $total_subjects = $row1['total_subjects'];
        $total_class = $row2['total_class'];
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
    <!-- Bootstrap CSS and other head elements -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Global styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            /* Light gray background */
        }

        /* Navbar styling */
        .navbar {
            background: #0072ff;
            /* Dark blue background */
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            /* Align items at ends */
            align-items: center;
            /* Center vertically */
        }

        .navbar h2 {
            margin: 0;
            /* No margin */
        }

        /* Dashboard layout with two columns */
        .dashboard {
            display: flex;
            /* Flex layout for the columns */
            flex-direction: row;
            /* Horizontal direction */
        }

        .sidebar {
            width: 25%;
            /* Sidebar takes 25% of the width */
            background: #0072ff;
            /* Dark blue background */
            color: white;
            /* White text color */
            padding: 20px;
            /* Padding around sidebar */
            height: 100vh;
            /* Full height */
            overflow: auto;
            /* Scrollable if content overflows */
        }

        .content {
            flex: 1;
            /* Content area takes remaining space */
            padding: 20px;
            /* Padding around content */
            background: white;
            /* White background */
            border-left: 1px solid #ccc;
            /* Separator between columns */
            width: 100%;
            height: auto;

        }

        .card-row{
            display: flex;
        
            justify-content: space-between;
        }

        .card {
            margin: 10px;
            /* Space between cards */
            flex-basis: 18rem;
            /* Ensure consistent card width */
            flex-grow: 1;
            /* Cards grow to fill space */
            background-color: #ffffff;
            /* White background for cards */
            border: none;
            /* No border */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            /* Soft shadow */
            padding:10px;

        }
        .card a{
            margin-top: 25px;
        }
        .card:hover{
            box-shadow: 0px 5px 15px #0072ff;
           
        }

        /* Sidebar list styling */
        .sidebar ul {
            list-style-type: none;
            /* No bullet points */
            padding: 0;
            /* No padding */
            margin: 0;
            /* No margin */
        }

        .sidebar li {
            margin-bottom: 10px;
            /* Space between items */
        }

        .sidebar a {
            color: white;
            /* White text color */
            text-decoration: none;
            /* No underline */
            display: flex;
            /* Flex for icon alignment */
            align-items: center;
            /* Center icon and text */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        .sidebar a:hover {
            text-decoration: underline;
            /* Underline on hover */
        }

        .sidebar a i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        /* Collapse/Expand child items in the sidebar */
        .sidebar .child-nav {
            display: none;
            /* Initially hidden */
            margin-left: 20px;
            /* Indentation for child items */
        }

        .sidebar .has-children.open .child-nav {
            display: block;
            /* Show when parent is open */
        }

        .content h2 {
            font-size: 24px;
            /* Larger font for headings */
            margin-top: 0;
            /* No top margin */
        }

        .content p {
            font-size: 16px;
            /* Standard font size for text */
            color: #333;
            /* Dark text color */
        }

        /* Alert box styling */
        .alert {
            background: #0072ff;
            /* Dark blue background */
            color: white;
            /* White text color */
            padding: 10px 20px;
            /* Padding around the alert */
            border-radius: 5px;
            /* Rounded corners */
            display: none;
            /* Initially hidden */
            position: fixed;
            /* Fix position on the screen */
            top: 20px;
            /* Position near the top */
            left: 50%;
            /* Center horizontally */
            transform: translateX(-50%);
            /* Center the alert */
            z-index: 1000;
            /* Ensure alert is on top */
            text-align: center;
            /* Center the text */
        }

        /* Animation for the alert box */
        .alert.show {
            display: block;
            /* Show the alert */
            animation: fade-in 1s;
            /* Fade-in effect */
        }

        /* Animation keyframes for fade-in effect */
        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive design with media queries */
        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
                /* Stack sidebar and content vertically */
            }

            .sidebar {
                width: 100%;
                /* Full width on smaller screens */
                border-right: none;
                /* No right border */
                border-bottom: 1px solid #ccc;
                /* Border between sidebar and content */
            }

            .content {
                border-left: none;
                /* No left border */
                border-top: 1px solid #ccc;
                /* Border between content and sidebar */
            }
        }
    </style>
</head>

<body>
    <!-- Navbar at the top with title -->
    <div class="navbar">
        <h2>Student Result Management System | Admin</h2>
        <a href="#"><i class="bi bi-box-arrow-right"></i> Logout</a> <!-- Logout link in the navbar -->
    </div>


    <!-- Alert box for welcome message -->
    <div class="alert" id="welcome-alert">
        Welcome to the Dashboard!
    </div>


    <!-- Dashboard with two columns -->
    <div class="dashboard"> <!-- Two-column layout -->
        <div class="sidebar"> <!-- Sidebar for navigation -->
            <ul>
                <!-- for classes CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-book'></i><span>Student Classes</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/class/createClass.php"><i class="fa fa-bars"></i>
                                Create Class</a></li>
                        <li><a href="http://localhost/student_project/class/manageClass.php"><i
                                    class="fa fa-server"></i> Manage Classes</a></li>
                    </ul>
                </li>

                <!-- for subjects CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-journal-text'></i><span>Subjects</span></a>
                    <ul class="child-nav">
                    <li><a href="http://localhost/student_project/subject/createSubject.php"><i
                                    class="fa fa-bars"></i> Create Subject</a></li>
                        <li><a href="http://localhost/student_project/subject/manageSubject.php"><i
                                    class="fa fa-server"></i> Manage Subject</a></li>
                        <li><a href="http://localhost/student_project/subject/addSubjectCombination.php"><i
                                    class="fa fa-newspaper-o"></i> Add Subject Combination</a></li>
                        <li><a href="http://localhost/student_project/subject/manageSubjectCombination.php"><i
                                    class="fa fa-newspaper-o"></i> Manage Subject Combination</a></li>
                        
                    </ul>
                </li>

                <!-- for student CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-person'></i><span>Students</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/student/addStudent.php"><i class="fa fa-bars"></i>
                                Add Student</a></li>
                        <li><a href="http://localhost/student_project/student/manageStudent.php"><i
                                    class="fa fa-server"></i> Manage Students</a></li>
                    </ul>
                </li>

                <!-- for results CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-bar-chart'></i><span>Results</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/result/addResult.php"><i class="fa fa-bars"></i>
                                Add Result</a></li>
                        <li><a href="http://localhost/student_project/manageStudent.php"><i class="fa fa-server"></i>
                                Manage Result</a></li>
                    </ul>
                </li>

                <!-- Admin change password -->
                <li><a href="#" onclick="loadContent('admin/changePassword.php')"><i class="fa fa-key"></i> Admin Change
                        Password</a></li>
            </ul>
        </div>

        <!-- Content area -->
        <div class="content" id="content-area"> <!-- Content area for displaying details -->
            <?php
            echo "<script>alert('Welcome to the Dashboard');</script>";
            ?>
            <p>Select an item from the sidebar to see detailed information.</p>

            <div class="card-row">
                <!-- Bootstrap card to display the total number of registered students -->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Students</h5>
                        <!-- Display the total count -->


                        <span class="bg-icon">
                            <i class="fa fa-users"></i>
                        </span> <span class="name">Regd Users: </span><?php echo $total_students; ?>
                        <a href="http://localhost/student_project/student/manageStudent.php"
                            class="btn btn-primary">Manage
                            Students</a>
                    </div>
                </div>


                <!-- Bootstrap card to display the total number of registered Subjects -->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Subjects</h5>
                        <!-- Display the total count -->


                        <span class="bg-icon">
                            <i class="fa fa-book"></i>
                        </span> <span class="name">Regd Subjects: </span><?php echo $total_subjects; ?>
                        <a href="http://localhost/student_project/subject/manageSubject.php"
                            class="btn btn-primary">Manage
                            Subjects</a>
                    </div>
                </div>


                <!-- Bootstrap card to display the total number of registered class -->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Class</h5>
                        <!-- Display the total count -->


                        <span class="bg-icon">
                            <i class="fa fa-library"></i>
                        </span> <span class="name">Regd Class: </span><?php echo $total_class; ?>
                        <a href="http://localhost/student_project/subject/manageSubject.php"
                            class="btn btn-primary">Manage
                            Class</a>
                    </div>
                </div>

                <!-- Bootstrap card to display the total number of declared result -->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Result Declared: </h5>
                        <!-- Display the total count -->


                        <span class="bg-icon">
                            <i class="fa fa-class"></i>
                        </span> <span class="name">Result Declared: </span><?php echo $total_results; ?>
                        <a href="http://localhost/student_project/subject/manageSubject.php"
                            class="btn btn-primary">Manage
                            Results</a>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <!-- Script to handle sidebar interactions -->
    <script>
        function toggleChildNav(parent) {
            parent.classList.toggle("open"); /* Toggle child-nav display */
        }

        function loadContent(page) {
            fetch(page)
                .then(response => response.text())
                .then(data => {
                    const contentArea = document.getElementById("content-area");
                    contentArea.innerHTML = data; /* Insert new content */
                })
                .catch(error => {
                    console.error("Error loading content:", error);
                    const contentArea = document.getElementById("content-area");
                    contentArea.innerHTML = "<p>Failed to load content. Please try again later.</p>";
                });
        }

        // Function to show an alert when the page loads
        window.onload = function () {
            const alertBox = document.getElementById("welcome-alert");
            if (alertBox) {
                alertBox.classList.add("show"); /* Trigger the alert box */
                setTimeout(() => {
                    alertBox.classList.remove("show"); /* Hide the alert after 5 seconds */
                }, 5000); // Duration of alert display
            }
        };
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>