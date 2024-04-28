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
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; /* Light gray background */
        }

        /* Header Styling */
        header {
            background-color: #0072ff; /* Dark blue */
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px; /* Space below header */
            overflow: hidden;
        }

        /* Navigation Styling */
        .nav {
            padding: 10px 20px; /* Padding around navigation */
            background: #333; /* Dark gray background */
            overflow: hidden;
        }

        .nav a {
            color: white; /* White text color */
            text-decoration: none; /* No underline */
            transition: all 0.3s ease;
        }

        .nav a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            padding: 10px; /* Padding inside breadcrumb */
            background: none; /* No background */
            margin-bottom: 20px; /* Space below breadcrumb */
        }

        .breadcrumb-item {
            margin-right: 10px; /* Space between breadcrumb items */
        }

        /* Container Layout */
        .container {
            max-width: 1200px; /* Maximum width */
            margin: 20px auto; /* Center container */
            padding: 20px; /* Padding around container */
            background: white; /* White background */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

        /* Form Styling */
        .form {
            margin-bottom: 20px; /* Space below form */
        }

        .form input[type="search"] {
            padding: 8px 12px; /* Padding for search input */
            border: 1px solid #ccc; /* Border color */
            border-radius: 5px; /* Rounded corners */
            width: 100%; /* Full width */
            box-sizing: border-box; /* Include padding in width */
        }

        .form select {
            padding: 8px 12px; /* Padding for select */
            border: 1px solid #ccc; /* Border color */
            border-radius: 5px; /* Rounded corners */
        }

        /* Table Design */
        table {
            width: 100%; /* Full width */
            border-collapse: collapse; /* Collapse borders */
            text-align: left; /* Align text to the left */
            background: white; /* Background for table */
        }

        table th,
        table td {
            padding: 10px; /* Padding around table cells */
            border: 1px solid #ddd; /* Border color */
        }

        table th {
            background-color: #f0f0f0; /* Light gray background for header */
        }

        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            .container {
                padding: 10px; /* Reduced padding for smaller screens */
            }

            .breadcrumb {
                font-size: 14px; /* Smaller font size */
            }

            .form input[type="search"] {
                width: 100%; /* Full width for smaller screens */
            }

            table {
                overflow-x: auto; /* Horizontal scrolling for small screens */
                display: block; /* Ensure table is block-level for scrolling */
            }

            table th,
            table td {
                padding: 8px; /* Adjusted padding for smaller screens */
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

        <h3>Manage Students </h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Students</a></li>
                <li class="breadcrumb-item"><a href="#">Manage Students</a></li>

            </ol>
        </nav>
    </div>



    <div class="container">
        <div class="form">
            <form action="#" method=="POST">
                <p>View Student Info </p>
                Show <select name="" id=""></select> entries
                <br><br>
                <input type="search" placeholder="search" name="search">



            </form>
        </div>


    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
include ("../connection.php");

//query to fetch all data from the 'tbl_student' table

$query = "SELECT * FROM tbl_Student";

//Execute the query
$data = mysqli_query($conn, $query);

// Check the number of rows returned
$total = mysqli_num_rows($data);
if ($total > 0) {
    ?>
    <table>
        <tr>
            <th>StdId</th>
            <th>Photo</th>
            <th>Student Name</th>
            <th>Roll NO.</th>
            <th>Class</th>
            <th>Email</th>
            <th>password</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
    </table>


    <?php

    while($result = mysqli_fetch_assoc($data))
    {
        echo "<tr>
        <td>" . $result['stdId'] . "</td>
        <td><img src = '" . $result['std_image'] . "' height='100px' width='100px' /></td>
        <td>" . $result['stdname'] . "</td>
        <td>" . $result['class'] . "</td>
        <td>" . $result['email'] . "</td>
        <td>" . $result['password'] . "</td>
        <td>" . $result['gender'] . "</td>
        <td>" . $result['phone'] . "</td>
        <td>" . $result['address'] . "</td>
       
        <td><a id='update' href='update.php?id=$result[stdId]'>
        <input type='submit' value='update' class='update'></a>

        <a id='update' href='delete.php?id=$result[stdId]'>
        <input type='submit' value='delete' class='delete'
         onclick = 'return checkdelete();' ></a>
      
       ";
    }
}
?>