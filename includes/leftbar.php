<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Management System | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Global styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        /* Dashboard layout with Flexbox */
        .dashboard {
            display: flex;
            /* Flex layout for columns */
            flex-direction: row;
            /* Horizontal layout */
            justify-content: space-between;
        }

        .sidebar {
            width: 100%;
            /* Fixed width for sidebar */
            background: #0072ff;
            /* Dark blue background */
            color: white;
            /* White text */
            padding: 20px;
            /* Padding around sidebar */
            height: 100vh;
            /* Full height */
            overflow-y: auto;
            /* Scrollable if content overflows */
        }

        .sidebar ul {
            list-style-type: none;
            /* No bullet points */
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
            /* Space between items */
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            /* Flex for icon alignment */
            align-items: center;
            /* Center icon and text */
            transition: all 0.3s ease;
            padding: 10px;
            /* Padding for links */
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #005bb5;
            /* Change background on hover */
        }

        .sidebar i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        .child-nav {
            display: none;
            /* Initially hidden */
            font-size: 16px;
            /* Smaller font for child items */
            padding-left: 20px;
            /* Indentation for child items */
        }

        .has-children.open .child-nav {
            display: block;
            /* Show child items when parent is open */
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
                border-bottom: 1px solid #ccc;
                /* Border between sidebar and content */
            }

            .sidebar a {
                border: 1px solid #fff;
                padding: 10px;
                border-radius: 5px;
                margin: 5px 2px;
                width: 100%;
                /* Full width for smaller screens */
            }

            .child-nav {
                padding-left: 10px;
                /* Reduce padding for smaller screens */
            }
        }
    </style>
</head>

<body>
    <!-- Dashboard with two columns -->
    <div class="dashboard">
        <div class="sidebar"> <!-- Sidebar for navigation -->
            <h4 class="fa fa-bars">&nbsp;&nbsp;&nbsp;Dashboard</h4>
            <hr>
            <ul>
                <!-- Dashboard navigation with collapsible items -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-book'></i><span>Student Course</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/course/createCourse.php"><i class="fa fa-bars"></i>
                                Create Course</a></li>
                        <li><a href="http://localhost/student_project/course/manageCourse.php"><i
                                    class="fa fa-server"></i> Manage Course</a></li>
                    </ul>
                </li>

                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-journal-text'></i><span>Subjects</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/subject/createSubject.php"><i
                                    class="fa fa-bars"></i> Create Subject</a></li>
                        <li><a href="http://localhost/student_project/subject/manageSubject.php"><i
                                    class="fa fa-server"></i> Manage Subjects</a></li>
                    </ul>
                </li>

                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-book'></i><span>Course Subject</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/courseSubject/createCourseSub.php"><i class="fa fa-bars"></i>
                                Create Course Subject</a></li>
                        <li><a href="http://localhost/student_project/courseSubject/manageCourseSub.php"><i
                                    class="fa fa-server"></i> Manage Course Subject</a></li>
                    </ul>
                </li>

                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-person'></i><span>Students</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/student/addStudent.php"><i class="fa fa-bars"></i>
                                Add Student</a></li>
                        <li><a href="http://localhost/student_project/student/manageStudent.php"><i
                                    class="fa fa-server"></i> Manage Students</a></li>
                    </ul>
                </li>

                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-person'></i><span>Exam</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/exam/createExam.php"><i class="fa fa-bars"></i>
                                create Exam</a></li>
                        <li><a href="http://localhost/student_project/exam/manageExam.php"><i
                                    class="fa fa-server"></i> Manage exam</a></li>
                    </ul>
                </li>

                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-bar-chart'></i><span>Results</span></a>
                    <ul class="child-nav">
                        <li><a href="http://localhost/student_project/result/addResult.php"><i class="fa fa-bars"></i>
                                Add Result</a></li>
                        <li><a href="http://localhost/student_project/result/manageResult.php"><i class="fa fa-server"></i>
                                Manage Result</a></li>
                    </ul>
                </li>

                <li>
                    <a href="http://localhost/student_project/adminSection/adminChangePass.php"><i class="fa fa-key"></i> Admin
                        Change
                        Password</a>
                </li>
            </ul>
        </div>

        <!-- Content area can be added here -->
    </div>

    <script>
        function toggleChildNav(parent) {
            parent.classList.toggle("open"); /* Toggle child-nav display */
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>