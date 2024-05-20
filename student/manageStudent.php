<?php
require_once ("../connection.php");

// Fetch the total number of registered students
$query = "SELECT COUNT(*) AS total_students FROM tbl_student";
$result = mysqli_query($conn, $query);

// Get the total number of students
$total_students = $result ? mysqli_fetch_assoc($result)['total_students'] : 0;

// Fetch all students from the database
$query = "SELECT * FROM tbl_student";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <style>
        /* Global Styling */
        body {
            font-family: poppins;
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
            padding: 10px 20px;
            text-align: center;
            font-size: 28px;

            /* Space below header */
            overflow: hidden;
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
            /* Padding inside breadcrumb */

            /* No background */
            margin-bottom: 20px;
            /* Space below breadcrumb */

        }

        .breadcrumb-item {
            margin-right: 20px;


            /* Space between breadcrumb items */
        }

        /* Main container class for dashboard and content */
        .main {
            display: flex;
            /* Flex layout to position sidebar and content */
            align-items: flex-start;
            /* Align content at the top */
            justify-content: flex-start;
            /* Ensure sidebar and content are side-by-side */
        }

        .main .container{
            align-items: center;
            justify-content: center;
            height: 80%;
            width: 100%;
        }

       

        /* Main content container */
        .container {
            margin: 40px;
            flex: 0 1 auto;
            /* Allow the main content to expand */
            padding: 12px;
            /* Padding around content */
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */


        }
       



        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            .main {
                flex-direction: column;
                /* Vertical layout for smaller screens */
            }

            .container {
                padding: 10px;
                /* Reduced padding for smaller screens */
            }

            .dashboard {
                width: 100%;
                /* Full width for sidebar in smaller screens */
            }
        }


      
        /* Table Design */
       .container table {
            align-items: center;
            justify-content: center;
            width: 90%;
            /* Full width */
            border-collapse: collapse;
            /* Collapse borders */
            text-align: center;
            /* Align text to the left */
            background: white;
            /* Background for table */
            border: 2px solid blue;
            margin: 20px 40px;




        }

        .table-responsive {
            overflow-x: auto;
        }



        table th,
        table td {
            padding: 7px;
            /* Padding around table cells */
            border: 1px solid #ddd;
            /* Border color */
        }

        table th {
            background-color: #0072ff;
            color: white;
            /* Light gray background for header */
        }

        /* button css */

        a .update,
        .delete {
            width: 90%;
            background: #0072ff;
            color: white;
            padding: 10px 20px;
            margin: 4px 2px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 5px;

        }

        .update:hover {
            background: #005bb5;
        }

        .update:active {
            transform: scale(0.95);
        }



        a .delete {
            background-color: red;


        }

        .delete:hover {
            background: tomato;
        }


        .delete:active {
            transform: scale(0.95);
        }

        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
                /* Reduced padding for smaller screens */
            }

            .breadcrumb {
                font-size: 14px;
                /* Smaller font size */
            }

            .form input[type="search"] {
                width: 100%;
                /* Full width for smaller screens */
            }

            table {
                overflow-x: auto;
                /* Horizontal scrolling for small screens */
                display: block;
                /* Ensure table is block-level for scrolling */
            }

            table th,
            table td {
                padding: 8px;
                /* Adjusted padding for smaller screens */
            }

            /* Align actions vertically for smaller screens */
            .actions {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <h3>Manage Students</h3>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-users"></i> Students</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Students</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <!-- Include leftbar or other dashboard content -->
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <h4>Registered Students</h4>
            <?php if ($data && mysqli_num_rows($data) > 0): ?>
                <table class="table-responsive" id="myTable">
                    <thead>
                        <tr>
                            <th>StdId</th>
                            <th>Photo</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($student = mysqli_fetch_assoc($data)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['stdId']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($student['std_image']); ?>" height='100px'
                                        width='100px' /></td>
                                <td><?php echo htmlspecialchars($student['stdname']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['password']); ?></td>
                                <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                <td><?php echo htmlspecialchars($student['address']); ?></td>
                                <td>
                                    <a href="updateStudent.php?id=<?php echo htmlspecialchars($student['stdId']); ?>"
                                        class="btn btn-primary">Update</a>
                                    <a href="deleteStudent.php?id=<?php echo htmlspecialchars($student['stdId']); ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>