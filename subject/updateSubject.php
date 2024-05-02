<?php
require_once("../connection.php");

$subCode = isset($_GET['id']) ? $_GET['id'] : null;

if ($subCode) {
    $query = "SELECT * FROM tbl_subjects WHERE subCode = '$subCode'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data) > 0) {
        $result = mysqli_fetch_assoc($data);
        $subName = $result['subName'];
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
    
    $query = "UPDATE tbl_subjects SET subCode = '$newSubCode', subName = '$subName' WHERE subCode = '$subCode'";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5fNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Your CSS styles here */

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
    <h3>Update Subject</h3>
</header>

<div class="container">
    <form action="updateSubject.php?id=<?php echo htmlspecialchars($subCode); ?>" method="POST">
        <div class="mb-3">
            <label for="subName">Subject Name</label>
            <input type="text" name="subName" class="form-control" value="<?php echo htmlspecialchars($subName); ?>">
        </div>
        <div class="mb-3">
            <label for="subCode">Subject Code</label>
            <input type="text" name="subCode" class="form-control" value="<?php echo htmlspecialchars($subCode); ?>">
        </div>
        <input type="submit" value="Update" class="btn btn-primary">
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
