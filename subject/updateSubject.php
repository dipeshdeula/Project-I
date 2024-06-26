<?php
require_once ("../connection.php");

$subCode = isset($_GET['id']) ? $_GET['id'] : null;

if ($subCode) {
    $query = "SELECT * FROM tbl_subjects WHERE subCode = '$subCode'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data) > 0) {
        $result = mysqli_fetch_assoc($data);
        $subName = $result['subName'];
        $thFM = $result['thFM'];
        $prFM = $result['prFM'];
    } else {
        // Redirect if the subject code doesn't exist
        header("Location: manageSubject.php?error=Subject not found");
        exit();
    }
} else {
    header("Location: manageSubject.php?error=No subject code provided");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newSubCode = htmlspecialchars($_POST['subCode']);
    $subName = htmlspecialchars($_POST['subName']);
    $thFM = htmlspecialchars($_POST['thFM']);
    $prFM = htmlspecialchars($_POST['prFM']);

    $query = "UPDATE tbl_subjects SET subCode = '$newSubCode', subName = '$subName', thFM='$thFM',prFM='$prFM' WHERE subCode = '$subCode'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Subject updated successfully'); window.location='manageSubject.php';</script>";
    } else {
        echo "<script>alert('Error updating subject: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Subject</title>
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
            width: 40%
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
        <h3>Update Subject</h3>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Subjects</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Update Subjects</a></li>
                <li class="breadcrub-item"><a href="../adminSection/adminLogin.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include('../includes/leftbar.php'); ?>
        </div>
        <div class="container">
        <form action="updateSubject.php?id=<?php echo htmlspecialchars($subCode); ?>" method="POST">
            <div class="input_field">
                <label for="subName">Subject Name</label>
                <input type="text" name="subName" class="form-control"
                    value="<?php echo htmlspecialchars($subName); ?>">
            </div>
            <div class="input_field">
                <label for="subCode">Subject Code</label>
                <input type="text" name="subCode" class="form-control"
                    value="<?php echo htmlspecialchars($subCode); ?>">
            </div>

            <div class="input_field_number">
                <label for="thfm">Total Theroy Marks</label>
                <input type="number" name="thFM" max="100" placeholder="Total Theroy Marks"
                    value="<?php echo htmlspecialchars($thFM); ?>" />
            </div>
            <div class="input_field_number">
                <label for="prfm">Total Practical Marks</label>
                <input type="number" max="25" name="prFM" placeholder="Total practical Marks"
                    value="<?php echo htmlspecialchars($prFM); ?> " />
            </div>
            <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>