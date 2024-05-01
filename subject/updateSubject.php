<?php
include ("../connection.php");

// Get the subCode from GET request
$subCode = isset($_GET['id']) ? $_GET['id'] : null;

// Check if the subCode is valid
if ($subCode) {
    // Fetch existing data based on subCode
    $query = "SELECT * FROM tbl_subjects WHERE subCode = '$subCode'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data)>0) { //Ensure data is retrieved
        $result = mysqli_fetch_assoc($data); // Fetch a single record
    } else {
        // Display an error if the initial data fetch fails
        echo "<script>alert('Error fetching data: " . mysqli_error($conn) . "');</script>";
        $result = null; // Explicitly set $result to null
    }
}
else {
    echo "<script>alert('No valid subCode provided');</script>";
    $result = null; // Explicitly set $result to null
}
if ($result) {
    $subName = isset($result['subName']) ? htmlspecialchars($result['subName']) : ''; // Ensure default values
    $subCode = isset($result['subCode']) ? htmlspecialchars($result['subCode']) : '';
} else {
    $subName = ''; // Default to empty string
    $subCode = ''; // Default to empty string
}


        // If the POST request is made to update the subject
        if (isset($_POST['update'])) {
            $subName = $_POST['subName']; // Ensure the correct variable name
            $updatedSubCode = $_POST['subCode']; // Use a new variable for the updated code

            // Construct the SQL query to update the record
            $query = "UPDATE tbl_subjects SET subName = '$subName', subCode = '$updatedSubCode' WHERE subCode = '$subCode'";

            $data = mysqli_query($conn, $query); // Execute the query

            // Check if the query execution was successful
            if ($data) {
                echo "<script>alert('Subjects Data Updated Successfully');</script>";
            } else {
                // Display an error message if the update fails
                echo "<script>alert('Failed to update data: " . mysqli_error($conn) . "');</script>";
            }
        }
    
?>


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
            padding: 15px 20px;
            /* Adequate padding */
            text-align: center;
            font-size: 24px;
            /* Larger text for emphasis */

        }

        /* Navigation Styling */
        .nav {
            padding: 10px 20px;
            /* Padding for navigation */
            background: #333;
            /* Dark gray background */
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
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between items */
        }

        /* Container Layout */
        .container {
            max-width: 600px;
            /* Moderate width */
            margin: 40px auto;
            /* Center the container */
            padding: 20px;
            /* Padding around the container */
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
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
        }

        input[type="text"]:focus {
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
            text-transform: uppercase;
            /* Uppercase text */
            width: 100%;
            /* Full width */
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

        <h3>Update Subjects</h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Subject</a></li>
                <li class="breadcrumb-item"><a href="#">Update Subject</a></li>

            </ol>
        </nav>
    </div>

    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="title">Update Subject's</div>


            <div class="form">

                <div class="input_field">
                    <label>Subject Name</label>
                    <input type="text" name="subName" placeholder="Subject Name" 
                    value="
                    <?php echo $subName;
                    ?>
                    "
                    />
                </div>

                <div class="input_field">
                    <label>Subject Code</label>
                    <input type="text" name="subCode" placeholder="Subject Code" 
                    value = "
                    <?php
                    echo $subCode;
                    ?>
                    "
                    />
                </div>
            </div>

            <div class="input_field">
                <input type="submit" value="update" class="btn" name="updateSubject" />


            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>
 