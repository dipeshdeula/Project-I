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
        /* Global styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; /* Light gray background */
        }

        /* Navbar styling */
        .navbar {
            background: #0072ff; /* Dark blue background */
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between; /* Align items at ends */
            align-items: center; /* Center vertically */
        }

        .navbar h2 {
            margin: 0; /* No margin */
        }

        /* Dashboard layout with two columns */
        .dashboard {
            display: flex; /* Flex layout for the columns */
            flex-direction: row; /* Horizontal direction */
        }

        .sidebar {
            width: 25%; /* Sidebar takes 25% of the width */
            background: #0072ff; /* Dark blue background */
            color: white; /* White text color */
            padding: 20px; /* Padding around sidebar */
            height: 100vh; /* Full height */
            overflow: auto; /* Scrollable if content overflows */
        }

        .content {
            flex: 1; /* Content area takes remaining space */
            padding: 20px; /* Padding around content */
            background: white; /* White background */
            border-left: 1px solid #ccc; /* Separator between columns */
            width:100%;
            height:auto;
           
        }

        /* Sidebar list styling */
        .sidebar ul {
            list-style-type: none; /* No bullet points */
            padding: 0; /* No padding */
            margin: 0; /* No margin */
        }

        .sidebar li {
            margin-bottom: 10px; /* Space between items */
        }

        .sidebar a {
            color: white; /* White text color */
            text-decoration: none; /* No underline */
            display: flex; /* Flex for icon alignment */
            align-items: center; /* Center icon and text */
            transition: all 0.3s ease; /* Smooth transition */
        }

        .sidebar a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .sidebar a i {
            margin-right: 10px; /* Space between icon and text */
        }

        /* Collapse/Expand child items in the sidebar */
        .sidebar .child-nav {
            display: none; /* Initially hidden */
            margin-left: 20px; /* Indentation for child items */
        }

        .sidebar .has-children.open .child-nav {
            display: block; /* Show when parent is open */
        }

        .content h2 {
            font-size: 24px; /* Larger font for headings */
            margin-top: 0; /* No top margin */
        }

        .content p {
            font-size: 16px; /* Standard font size for text */
            color: #333; /* Dark text color */
        }

        /* Responsive design with media queries */
        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column; /* Stack sidebar and content vertically */
            }

            .sidebar {
                width: 100%; /* Full width on smaller screens */
                border-right: none; /* No right border */
                border-bottom: 1px solid #ccc; /* Border between sidebar and content */
            }

            .content {
                border-left: none; /* No left border */
                border-top: 1px solid #ccc; /* Border between content and sidebar */
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

    <!-- Dashboard with two columns -->
    <div class="dashboard"> <!-- Two-column layout -->
        <div class="sidebar"> <!-- Sidebar for navigation -->
            <ul>
                <!-- for classes CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-book'></i><span>Student Classes</span></a>
                    <ul class="child-nav">
                        <li><a href="#" onclick="loadContent('http://localhost/student_project/class/createClass.php')"><i class="fa fa-bars"></i> Create Class</a></li>
                        <li><a href="#" onclick="loadContent('http://localhost/student_project/class/manageClass.php')"><i class="fa fa-server"></i> Manage Classes</a></li>
                    </ul>
                </li>

                <!-- for subjects CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-journal-text'></i><span>Subjects</span></a>
                    <ul class="child-nav">
                        <li><a href="#" onclick="loadContent('subject/createSubject.php')"><i class="fa fa-bars"></i> Create Subject</a></li>
                        <li><a href="#" onclick="loadContent('subject/manageSubject.php')"><i class="fa fa-server"></i> Manage Subject</a></li>
                        <li><a href="#" onclick="loadContent('subject/addSubjectCombination.php')"><i class="fa fa-newspaper-o"></i> Add Subject Combination</a></li>
                        <li><a href="#" onclick="loadContent('subject/manageSubjectCombination.php')"><i class="fa fa-newspaper-o"></i> Manage Subject Combination</a></li>
                    </ul>
                </li>

                <!-- for student CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-person'></i><span>Students</span></a>
                    <ul class="child-nav">
                        <li><a href="#" onclick="loadContent('http://localhost/student_project/student/manageStudent.php')"><i class="fa fa-bars"></i> Add Student</a></li>
                        <li><a href="#" onclick="loadContent('student/manageStudent.php')"><i class="fa fa-server"></i> Manage Students</a></li>
                    </ul>
                </li>

                <!-- for results CRUD -->
                <li class="has-children" onclick="toggleChildNav(this)">
                    <a href="#"><i class='bi bi-bar-chart'></i><span>Results</span></a>
                    <ul class="child-nav">
                        <li><a href="#" onclick="loadContent('result/addResult.php')"><i class="fa fa-bars"></i> Add Result</a></li>
                        <li><a href="#" onclick="loadContent('result/manageResult.php')"><i class="fa fa-server"></i> Manage Result</a></li>
                    </ul>
                </li>

                <!-- Admin change password -->
                <li><a href="#" onclick="loadContent('admin/changePassword.php')"><i class="fa fa-key"></i> Admin Change Password</a></li>
            </ul>
        </div>

        <!-- Content area -->
        <div class="content" id="content-area"> <!-- Content area for displaying details -->
            <h2>Welcome to the Dashboard</h2>
            <p>Select an item from the sidebar to see detailed information.</p>
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
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
