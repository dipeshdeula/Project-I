<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            /* Padding around navigation */
            background: #333;
            /* Dark gray background */
            overflow: hidden;
        }

        .nav a {
            margin-left: 25px;
            color: white;
            /* White text color */
            text-decoration: none;
            /* No underline */
            transition: all 0.3s ease;
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
        /* Container layout*/
        .container{
            display: block;
            flex-direction: row;
            padding: 20px;
            margin: 20px ;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            padding: 20px;
            margin: 20px;
        }

        .table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .table th,
        .table td {
            
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
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

        <h3>Manage Classes</h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Class</a></li>
                <li class="breadcrumb-item"><a href="#">Manage Classes</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php
            include ('../includes/leftbar.php');
            ?>

            <div class="container">
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

                <div class="table-container">
                    <?php
                    include ("../connection.php");

                    $query = "SELECT * FROM tbl_classes";
                    $data = mysqli_query($conn, $query);
                    $total = mysqli_num_rows($data);

                    if ($total > 0) {
                        ?>
                       <center> <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Class Name</th>
                                <th>Section</th>
                                <th>Operation</th>
                            </tr>
                            <?php
                            while ($result = mysqli_fetch_array($data)) {
                                echo "<tr>
                      <td>{$result['id']}</td>
                      <td>{$result['className']}</td>
                      <td>{$result['classSection']}</td>
                      <td>
                          <a class='update' href='http://localhost/student_project/class/updateClass.php?id={$result['id']}'>Update</a>
                          <a class='delete' href='http://localhost/student_project/class/deleteClass.php?id={$result['id']}' onclick='return checkdelete();'>Delete</a>
                      </td>
                      </tr>";
                            }
                            ?>
                        </table></center>
                        <?php
                    } else {
                        echo "No records found.";
                    }
                    ?>
                </div>
                    
                </form>
               
            </div>
        </div>



        <script>
            function checkdelete() {
                return confirm('Are you sure you want to delete this record?');
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
</body>
</html>