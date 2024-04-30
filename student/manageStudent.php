<?php
include("../connection.php");

// Initialize the variable with a default value
$total_students = 0; // Default value in case of query failure

// Try to fetch the total number of registered students
$query = "SELECT COUNT(*) AS total_students FROM tbl_student";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Fetch the data
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        // Assign the total count
        $total_students = $row['total_students'];
    }
}
?>
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
            /* Padding around navigation */
            background: #0072ff;
            /* Dark gray background */
            overflow: hidden;
            font-size: 26px;
        }

        .nav a {
            color: white;
            /* White text color */
            text-decoration: none;
            /* No underline */
            transition: all 0.3s ease;
        }

        .nav a:hover {
            text-decoration: none;
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
    display: flex; /* Flex layout to position sidebar and content */
    align-items: flex-start; /* Align content at the top */
    justify-content: flex-start; /* Ensure sidebar and content are side-by-side */
}

/* Sidebar (dashboard) */
.dashboard {
    
    width: 70%; /* Sidebar width */
   
}

/* Main content container */
.container {
    margin:40px auto;
    flex: 0 1 auto; /* Allow the main content to expand */
    padding: 12px; /* Padding around content */
    background: white; /* White background */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */


    transform: translate(-10%, 2%);


}

/* Responsive Design with Media Queries */
@media (max-width: 768px) {
    .main {
        flex-direction: column; /* Vertical layout for smaller screens */
    }

    .container {
        padding: 10px; /* Reduced padding for smaller screens */
    }

    .dashboard {
        width: 100%; /* Full width for sidebar in smaller screens */
    }
}


        /* Form Styling */
        .form {
            margin-bottom: 20px;
            /* Space below form */
        }

        .form input[type="search"] {
            padding: 8px 12px;
            /* Padding for search input */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            width: 75%;
            /* Full width */
            box-sizing: border-box;
            /* Include padding in width */
        }

        .form select {
            padding: 8px 12px;
            /* Padding for select */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
        }

        /* Table Design */
        table {
            align-items: center;
            justify-content: center;
            width: 70%;
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
        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">&nbsp;&nbsp;&nbsp;<i class="fa fa-home"></i>&nbsp;&nbsp;Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Students</a></li>
                <li class="breadcrumb-item"><a href="#">Manage Students</a></li>
            </ol>
        </nav>
    </div>

    <!-- Here we add the main container to hold the sidebar and the main content -->
    <div class="main">
        <!-- Sidebar for Dashboard -->
        <div class="dashboard">
            <!-- Include leftbar or other sidebar content -->
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <!-- Main content container -->
        <div class="container">
            <div class="form">
                <form action="#" method="POST">
                    <p>View Student Info </p>
                    Show
                    <select name="" id="">
                       <option value="
                       <?php echo $total_students; ?>"></option> 
                    </select>
                    entries
                    <br><br>
                    <input type="search" placeholder="search" name="search">

                    <table>
                        <tr>
                            <th>StdId</th>
                            <th>Photo</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Operations</th>
                        </tr>

                        <!-- Existing PHP code to fetch and display data from the database -->
                        <?php
                        include ("../connection.php");
                        $query = "SELECT * FROM tbl_student";
                        $data = mysqli_query($conn, $query);
                        $total = mysqli_num_rows($data);
                        if ($total > 0) {
                            while ($result = mysqli_fetch_assoc($data)) {
                                echo "<tr>
                                    <td>{$result['stdId']}</td>
                                    <td><img src=\"{$result['std_image']}\" height='100px' width='100px' /></td>
                                    <td>{$result['stdname']}</td>
                                    <td>{$result['email']}</td>
                                    <td>{$result['password']}</td>
                                    <td>{$result['classname']}</td>
                                    <td>{$result['gender']}</td>
                                    <td>{$result['phone']}</td>
                                    <td>{$result['address']}</td>
                                    <td>
                                        <a id='update' href='update.php?id={$result['stdId']}'>
                                            <input type='submit' value='update' class='update'>
                                        </a>
                                        <a id='delete' href='http://localhost/student_project/student/deleteStudent.php?id={$result['stdId']}'>
                                            <input type='submit' value='delete' class='delete' onclick='return checkdelete();'>
                                        </a>
                                    </td>
                                </tr>";
                            }
                        }
                        ?>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>