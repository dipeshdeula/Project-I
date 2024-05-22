<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <style>
        /* Global Styling */
        body {
            font-family: poppins, sans-serif;
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
            background: none;
            /* No background */
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        .main {
            display: flex;
            flex-direction: row;

        }

        .main .container {
            height: 50%;
            width: 50%
        }

        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            margin-right: 20px;
        }

        table th {
            background-color: #0072ff;
            color: white;
        }

        .update,
        .delete {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete {
            background-color: #dc3545;
        }

        .update:hover,
        .delete:hover {
            opacity: 0.8;
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

            table {
                overflow-x: auto;
                /* Horizontal scrolling for small screens */
            }

            table th,
            table td {
                padding: 8px;
                /* Adjusted padding for smaller screens */
            }
        }
    </style>
</head>

<body>
    <header>
        <h3>Manage Courses</h3>
    </header>


    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Courses</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Courses</a></li>
                <li class="breadcrub-item"><a href="../adminSection/adminLogin.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include ('../includes/leftbar.php'); ?>
        </div>
        <div class="container">
            <h4>View Course Details</h4>
            <div class="table-container">
                <?php
                include ("../connection.php");

                $query = "SELECT * FROM tbl_course";
                $data = mysqli_query($conn, $query);

                if ($data && mysqli_num_rows($data) > 0):
                    $serial = 1; // Initialize the serial number
                    ?>
                    <center>
                        <table class="table-responsive" id="myTable">
                            <thead>
                                <tr>
                                    <th>S.N</th> <!-- Serial number -->
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Short Name</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($result = mysqli_fetch_array($data)):
                                    echo "<tr>
                                    <td>{$serial}</td> <!-- Serial number -->
                                    <td>{$result['courseId']}</td>
                                    <td>{$result['courseName']}</td>
                                    <td>{$result['shortName']}</td>
                                    <td>
                                        <!-- Using className and classSection to identify records for update/delete -->
                                        <a class='update' href='updateCourse.php?courseId={$result['courseId']}'>Update</a>
                                        <a class='delete' href='deleteCourse.php?courseId={$result['courseId']}' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                                    </td>
                                </tr>";
                                    $serial++; // Increment serial number
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    </center>
                <?php else: ?>
                    <p>No records found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable(); // Initialize DataTables
        });
    </script>
</body>

</html>