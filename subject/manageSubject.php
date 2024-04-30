<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
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
            /* Padding for navigation */
            background: #333;
            /* Dark gray background */
            overflow: hidden;
            font-size: 24px;
        }

        .nav a {
            color: white;
            /* White text */
            text-decoration: none;
            /* No underline */
            transition: all 0.3s ease;
            /* Smooth transitions */
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
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        .main{
            display:flex;
            flex-direction: row;

        }
        .dashboard{
         width:auto;
         
            
          
        }
        /* Container Layout */
        .container {
           flex :1;

            width: 1000px;
            /* Maximum width */
            margin: 20px auto;
            /* Center container */
            padding: 20px;
            /* Padding around container */
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
            font-size: 22px;
        }

        /* Table Design */
        table {
            margin-top: 20px;
            display: block;
            flex: 1;
            align-items: center;
            justify-content: center;
            width: 80%;
            /* Full width */
            border-collapse: collapse;
            /* Collapse borders */
            text-align: left;
            /* Align text to the left */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Add shadow */
        }

        table th,
        table td {
            padding: 10px;
            /* Padding around table cells */
            border: 1px solid #ddd;
            /* Border color */
        }

        table th {
            background-color: #0072ff;
            /* Dark blue for header */
            color: white;
            /* White text for header */
        }

        table td {
            text-align: center;
            /* Center-align data in table */
        }

        .actions {
            display: inline-block;
            /* Actions should be inline */
        }

        /* Submit Button Styling */
        .update,
        .delete {
            background: #0072ff;
            /* Dark blue background */
            color: white;
            /* White text */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            padding: 10px 20px;
            /* Adequate padding */
            text-transform: uppercase;
            /* Capitalize text */
            transition: all 0.3s ease;
            /* Smooth transitions */

        }

        .update:hover {
            background: #005bb5;
            /* Darker blue on hover */
        }

        .delete {
            background: #e74c3c;
            /* Red background for delete */
        }

        .delete:hover {
            background: #c0392b;
            /* Darker red on hover */
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

        <h3>Manage Subjects</h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Subject Name</a></li>
                <li class="breadcrumb-item"><a href="#">Subject Code</a></li>

            </ol>
        </nav>
    </div>
    <!-- 
    adding dashboard here -->

    <div class="main">
        <div class="dashboard">
            <?php include('../includes/leftbar.php') ?>

        </div>
        <div class="container">
            <div class="form">
                <form action="#">
                    <p>View Subject Info </p>
                    Show
                    <select name="" id="">
                        <option value="
                       <?php echo $total_students; ?>"></option>
                    </select>
                    entries
                    <br><br>
                    <input type="search" placeholder="search" name="search">
                    <center>

                        <table>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th>Operations</th>
                            </tr>

                            <?php

                            include ("../connection.php");
                            $query = "SELECT * FROM tbl_subjects";
                            $data = mysqli_query($conn, $query);
                            $total = mysqli_num_rows($data);


                            while ($result = mysqli_fetch_assoc($data)) {
                                echo "<tr>
                   <td>" . $result['subCode'] . "</td>
                   <td>" . $result['subName'] . "</td>
                   <td>
                   <a  href='http://localhost/student_project/subject/upateSubject.php?id=$result[subCode]'>
                    <input type='submit' value='update' class='update' name='updateSubject'>
                   </a>
                   <a  href='http://localhost/student_project/subject/deleteSubject.php?id=$result[subCode]'>
                     <input type='submit' value='delete' class='delete' name='deleteSubject' onclick='return checkdelete();'>

                                        
                                        </a
                                        </td>
                   

                    </tr>";
                            }
                            ?>
                        </table>
                    </center>
                </form>
            </div>
        </div>

    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        function checkdelete() {
            return confirm("Are you sure want to delete?");
        }
    </script>

</body>

</html>