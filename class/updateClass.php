<?php
// session_start();
// if(!isset($_SESSION['className']))
// {
//     header("Location:adminLogin.php");
//     exit();
// }
// ?>


<?php
include ('../connection.php');

//retrieve the 'id' parameter from teh query string

$cid = isset($_GET['id']) ? $_GET['id'] : null;

if ($cid) {
    //fetch data from the database on the provided id;

    $query = "SELECT * from tbl_classes WHERE id='$cid'";
    $data = mysqli_query($conn, $query);

    if ($data) {
        $result = mysqli_fetch_assoc($data);
    } else {
        echo "error fetching data:" . mysqli_error($conn);
        return;
    }
} else {
    echo "No Id provided";
    return;
}

if (isset($_POST['update'])) {
    $className = $_POST['className'];
    $classSection = $_POST['classSection'];

    //construct the sql query to update the record

    $query = "UPDATE tbl_classes set className='$className',
     classSection = '$classSection' WHERE id = '$cid'";

     //execute the query and check for sucess
     $data = mysqli_query($conn,$query);
     if($data)
     {
        echo "<script>alert('Data updated Successfully');</script>";
     }
     else{
        echo "<script>alert('failed to update data');</script>";
     }
}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student Class</title>
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
            background-color: #f5f5f5;
            /* Light gray background */
        }

        /* Header Styling */
        header {
            background-color: #0072ff;
            /* Dark blue */
            color: white;
            /* White text */
            padding: 10px;
            /* Adequate padding */
            text-align: center;
            /* Center align text */
            font-size: 24px;
            /* Larger font size */
            margin-bottom: 20px;
            /* Space below header */
        }

        /* Navigation Styling */
        .nav {
            padding: 10px 20px;
            /* Padding for navigation */
            background: #333;
            /* Dark gray background */
        }

        .nav a {
            display: inline-flex;
            list-style: none;
            color: white;
            /* White text */
            text-decoration: none;
            /* No underline */
            transition: all 0.3s ease;
            /* Smooth transitions */
            margin: 2px;
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
            text-decoration: none;

        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        /* Container Layout */
        .container {
            max-width: 600px;
            /* Moderate width */
            margin: 5% auto;
            /* Center the container */
            padding: 30px;
            /* Adequate padding */
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
            text-align: center;
            /* Center align text */

        }

        /* Form Styling */
        .form {
            display: flex;
            /* Use flexbox */
            flex-direction: column;
            /* Vertical alignment */
            align-items: stretch;
            /* Align to container's width */
        }

        /* Label Styling */
        label {
            font-weight: bold;
            /* Bold text for labels */
            color: #555;
            /* Dark gray color */
            margin-bottom: 10px;
            /* Space below labels */
        }

        input[type="text"] {
            width: 100%;
            /* Full width */
            padding: 12px;
            /* Adequate padding */
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Adequate font size */
            transition: all 0.3s ease;
            /* Smooth transitions */
        }

        input[type="text"]:focus {
            border-color: #0072ff;
            /* Blue border on focus */
            outline: none;
            /* No default outline */
        }

        /* Paragraph Styling */
        p {
            color: #777;
            /* Light gray text */
            font-size: 14px;
            /* Slightly smaller font size */
            text-align: start;
            /* Align left */
            margin-bottom: 15px;
            /* Space below paragraph */
        }

        /* Submit Button Styling */
        input[type="submit"] {
            background: #0072ff;
            /* dark blue background */
            color: white;
            /* White text */
            padding: 12px;
            /* Adequate padding */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Consistent font size */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: all 0.3s ease;
            /* Smooth transitions */
            width: 100%;
            /* Full width */
        }

        input[type="submit"]:hover {
            background: #388E3C;
            /* Darker green on hover */
        }

        input[type="submit"]:active {
            transform: scale(0.95);
            /* Slight shrink on click (active state) */
        }

        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                /* Reduced padding for smaller screens */
                max-width: 100%;
                /* Full width on smaller screens */
            }

            input[type="text"] {
                padding: 10px;
                /* Adjusted padding */
                font-size: 14px;
                /* Smaller font size */
            }

            input[type="submit"] {
                padding: 10px 16px;
                /* Adjusted padding */
                font-size: 14px;
                /* Smaller font size */
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
                /* Further reduced padding */
            }

            .form {
                flex-direction: column;
                /* Stack form elements */
                align-items: stretch;
                /* Align to full width */
            }

            input[type="text"] {
                padding: 8px 10px;
                /* Smaller padding */
            }
        }
    </style>
</head>

<body>
    <?php
    include ('../includes/topbar.php');
    include ('../includes/leftbar.php');
    ?>



    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">classes</a></li>
                <li class="breadcrumb-item"><a href="#">update class</a></li>

            </ul>
        </nav>
    </div>
    <div class="container">
        <h3>Update Student Class</h3>
        <hr>
        <div class="form">
            <form action="#" method="POST">
                <label for="className">Class Name</label>
                <input type="text" name="className" value="<?php echo htmlspecialchars($result['className']); ?>" />

                <p>Eg-BCAI,BIM IV, BBS III etc </p>
                <label for="classSection">Section</label>
                <input type="text" name="classSection" value="<?php
                echo htmlspecialchars($result['classSection']) ?>" />

                <p>Eg- A, B, C etc </p>
                <input type="submit" name="update" value="update" />
            </form>
        </div>
    </div>
</body>

</html>
