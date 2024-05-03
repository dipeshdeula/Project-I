<?php
require_once ("../connection.php");

$stdId = isset($_GET['id']) ? $_GET['id'] : null;

if ($stdId) {
    $query = "SELECT * FROM tbl_student WHERE stdId = '$stdId'";
    $data = mysqli_query($conn, $query);

    if ($data && mysqli_num_rows($data) > 0) {
        $student = mysqli_fetch_assoc($data);
    } else {
        header("Location: manageStudent.php?error=Student not found");
        exit();
    }
} else {
    header("Location: manageStudent.php?error=No student ID provided");
    exit();
}

// Fetch class names to populate the dropdown
$class_query = "SELECT className FROM tbl_classes";
$class_data = mysqli_query($conn, $class_query);
$classes = [];
while ($row = mysqli_fetch_assoc($class_data)) {
    $classes[] = $row['className'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stdname = $_POST['stdname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $classname = $_POST['classname'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Default image path
    $image_path = $student['std_image']; // Keep existing image by default

    // Check if a new image was uploaded
    if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['student_image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_type = $file['type'];

        // Allow only certain file types (e.g., JPG, PNG)
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($file_type, $allowed_types)) {
            // Set a secure destination path (make sure the directory is writable)
            $upload_dir = '../uploads/students/'; // Update this path according to your structure
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
            }

            // Move the uploaded file to the destination directory
            $destination = $upload_dir . $file_name;
            move_uploaded_file($file_tmp, $destination);

            // Update the image path
            $image_path = $destination;
        } else {
            echo "<script>alert('Invalid file type. Only JPG and PNG are allowed.');</script>";
        }
    }

    // Update query to include the image path
    $query = "UPDATE tbl_student 
              SET stdname = '$stdname', 
                  email = '$email', 
                  password = '$password', 
                  classname = '$classname', 
                  gender = '$gender', 
                  phone = '$phone', 
                  address = '$address', 
                  std_image = '$image_path' 
              WHERE stdId = '$stdId'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Student updated successfully.'); window.location='manageStudent.php';</script>";
    } else {
        echo "<script>alert('Error updating student: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
            padding: 10px;
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

        /* Container Layout */
        .container {
            max-width: 1200px;
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
        }

        /* Form Styling */
        .form {
            margin-bottom: 20px;
            /* Space below form */
        }

        .form .form-group{
            margin-bottom: 20px;
        }

        .input_field {
            margin-bottom: 15px;

            /* Space between input fields */
        }

        .input_field label {
            font-weight: bold;
            /* Bold labels for emphasis */
            padding: 10px;
            background-color: yellow;
        }

        .input {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            /* Padding for input fields */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            box-sizing: border-box;
            /* Include padding in width */
        }

        .textarea {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            /* Padding for text area */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            box-sizing: border-box;
            /* Include padding in width */
            height: 80px;
            /* Default height for text area */
            resize: none;
        }

        .custom_select select {
            width: 100%;
            /* Full width */
            padding: 8px 12px;
            /* Padding for select fields */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            box-sizing: border-box;
            /* Include padding in width */
        }

        .terms p {

            display: flex;
            /* Use flexbox for alignment */
            align-items: center;
            /* Center checkbox and text */
            margin: 0px 12px;
        }

        .checkmark {
            width: 20px;
            /* Checkbox size */
            height: 20px;
            border: 2px solid #0072ff;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
        }

        .checkmark input {
            opacity: 0;
            /* Hide default checkbox */
        }

        .checkmark:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 10px;
            height: 10px;
            background: #0072ff;
            /* Background color for checked */
            display: none;
            /* Initially hidden */
        }

        .check input:checked+.checkmark:after {
            display: block;
            /* Show when checked */
        }

        .btn {
            margin-top: 5px;
            background: #0072ff;
            /* Blue background */
            color: white;
            /* White text color */
            padding: 10px 20px;
            /* Padding for button */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            text-transform: uppercase;
            /* Capitalize text */
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
        }

        .btn:hover {
            background: #005bb5;
            /* Darker blue on hover */
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

            .input_field {
                margin-bottom: 10px;
                /* Reduce space for smaller screens */
            }

            .input {
                padding: 6px 10px;
                /* Adjust padding for smaller screens */
            }

            .textarea {
                height: 60px;
                width: auto;
                resize: none;
                /* Reduce height for smaller screens */
            }
        }
    </style>
</head>

<body>
    <header>
        <h3>Update Student</h3>
    </header>
    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-Users"></i> Students</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Update Students</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Student Image</label>
                    <input type="file" name="student_image" class="form-control">
                </div>

                <div class="form-group">
                    <label>Student Name</label>
                    <input type="text" name="stdname" value="<?php echo htmlspecialchars($student['stdname']); ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" value="<?php echo htmlspecialchars($student['password']); ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Class Name</label>
                    <select name="classname" class="form-control">
                        <option value="Not Selected">Select</option>
                        <?php
                        foreach ($classes as $className) {
                            $selected = ($student['classname'] === $className) ? 'selected' : '';
                            echo "<option value=\"$className\" $selected>$className</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male" <?php echo ($student['gender'] === 'Male') ? 'selected' : ''; ?>>Male
                        </option>
                        <option value="Female" <?php echo ($student['gender'] === 'Female') ? 'selected' : ''; ?>>Female
                        </option>
                        <option value="Other" <?php echo ($student['gender'] === 'Other') ? 'selected' : ''; ?>>Other
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address"
                        class="form-control"><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>