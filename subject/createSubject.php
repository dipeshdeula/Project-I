<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>subject creation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        /* Global Styling */
        body {
            font-family: 'poppins';
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
            /* Adequate padding */
            text-align: center;
            font-size: 24px;
            /* Larger text for emphasis */

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
            /* Padding for breadcrumb */
            background: none;
            /* No background */
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between items */
        }

        .main {
            display: flex;
            flex-direction: row;


        }

        .main .container {
            height: 50%;
            width: 50%
        }

        .dashboard {
            width: auto;
            display: flex;
            flex-direction: column;
        }

        /* Container Layout */
        .container {
            flex-direction: row;
            display: flex;
            /* Use flexbox */
            flex-direction: column;
            /* Vertical alignment */
            height: 50vh;
            /* Full height */
            width: 10vh;
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
            margin-top: 40px;
            /* Space above the container */
            padding: 20px;

        }

        /* Form Styling */
        .form {
            display: flex;
            /* Use flexbox */
            flex-direction: column;
            /* Vertical alignment */
            align-items: stretch;
            /* Align items to the container's width */
        }

        /* Input Field Styling */
        .input_field {
            margin-bottom: 15px;
            /* Space between input fields */
        }

        .input_field label {
            font-weight: bold;
            /* Bold text for labels */
            color: #555;
            /* Dark gray color */
        }

        input[type="text"] {
            width: 100%;
            /* Full width */
            padding: 10px 15px;
            /* Padding for input fields */
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Adequate font size */
            transition: all 0.3s ease;
            /* Smooth transitions */
            margin-top: 10px;
        }

        input[type="text"]:focus {
            border-color: #0072ff;
            /* Blue border on focus */
            outline: none;
            /* No default outline */
        }
        .input_field_number label {
    font-weight: bold;
    /* Bold text for labels */
    color: #555;
    /* Dark gray color */
    margin-top: 10px;
}

.input_field_number input[type="number"] {
    width: 100%;
    margin-top: 10px;
    /* Full width */
    padding: 10px 15px;
    /* Padding for input fields */
    border: 1px solid #ccc;
    /* Light gray border */
    border-radius: 5px;
    /* Rounded corners */
    font-size: 16px;
    /* Adequate font size */
    transition: all 0.3s ease;
    /* Smooth transitions */
}

.input_field_number input[type="number"]:focus {
    border-color: #0072ff;
    /* Blue border on focus */
    outline: none;
    /* No default outline */
}


        /* Register Button Styling */
        input[type="submit"] {
            background: #0072ff;
            /* Blue background */
            color: white;
            /* White text */
            padding: 10px 20px;
            /* Padding around the button */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Standard font size */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: all 0.3s ease;
            /* Smooth transition on hover and active */
          
            /* Uppercase text */
            width: 100%;
            /* Full width */
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background: #005bb5;
            /* Darker blue on hover */
        }

        input[type="submit"]:active {
            transform: scale(0.95);
            /* Slightly smaller on click (active state) */
        }


        /* Responsive Design with Media Queries */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                /* Adjusted padding for smaller screens */
            }

            .form {
                align-items: stretch;
                /* Ensure items align to the container */
            }

            .input_field {
                margin-bottom: 10px;
                /* Adjust spacing for smaller screens */
            }

            input[type="text"] {
                padding: 8px 12px;
                /* Adjusted padding for smaller screens */
                font-size: 14px;
                /* Smaller font size */
            }
        }

        @media (max-width: 480px) {
            header {
                font-size: 20px;
                /* Smaller font size for smaller screens */
            }

            .container {
                padding: 10px;
                /* Reduced padding */
            }

            .breadcrumb {
                font-size: 14px;
                /* Smaller font size for breadcrumb */
            }

            .input_field {
                margin-bottom: 8px;
                /* Further reduced spacing */
            }

            input[type="text"] {
                padding: 6px 10px;
                /* Smaller padding */
            }
        }
    </style>
</head>

<body>


    <header>

        <h3>Create Subjects</h3>

    </header>
    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Subjects</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Create Subjects</a></li>

            </ol>
        </nav>
    </div>


    <div class="main">
        <div class="dashboard">
            <?php include ("../includes/leftbar.php"); ?>

        </div>
        <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data">
                <h4>Create Subjects</h4>

                <div class="form">

                    <div class="input_field">
                        <label>Subject Code</label>
                        <input type="text" name="subCode" placeholder="Subject Code" />
                    </div>

                    <div class="input_field">
                        <label>Subject Name</label>
                        <input type="text" name="subName" placeholder="Subject Name" />
                    </div>

                    <div class="input_field_number">
                        <label for="thfm">Total Theroy Marks</label>
                        <input type="number" name="thFM" max="100" placeholder="Total Theroy Marks" />
                    </div>
                    <div class="input_field_number">
                        <label for="thfm">Total Practical Marks</label>
                        <input type="number" max = "25"  name="prFM" placeholder="Total practical Marks" />
                    </div>
                </div>

                <div class="input_field">
                    <input type="submit" value="Create" class="btn" name="create" />
                </div>
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
if (isset($_POST['create'])) {
    $subCode = $_POST['subCode'];
    $subName = $_POST['subName'];
    $thFM = $_POST['thFM'];
    $prFM = $_POST['prFM'];
    


    if ($subName == null && $subCode == null && $thFM == null && $prFM == null) {
        echo "<script>alert('All field are required to filled');</script>";

    } else {
        $query = "INSERT INTO tbl_subjects (subCode,subName,thFM,prFM)
            VALUES ('$subCode','$subName','$thFM','$prFM')";

        $data = mysqli_query($conn, $query);
        if ($data) {
            echo "<script>alert('Student Subject Created');</script>";

        } else {
            echo "<script>alert('Unable to create student subject');</script>";
        }


    }


}


?>