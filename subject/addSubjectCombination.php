<?php
require_once ("../connection.php");

// Fetch all classes from the database
$query_classes = "SELECT * FROM tbl_classes";
$classes = mysqli_query($conn, $query_classes);

// Fetch all subjects from the database
$query_subjects = "SELECT * FROM tbl_subjects";
$subjects = mysqli_query($conn, $query_subjects);

// Handle form submission to add subject combinations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Add'])) {
    $classname = $_POST['classname'];
    // Collect all subjects selected, ensuring non-empty
    $subjects_selected = array_filter([
        $_POST['subject1'],
        $_POST['subject2'],
        $_POST['subject3'],
        $_POST['subject4'],
        $_POST['subject5']
    ]);

    // Insert each subject combination into the database
    foreach ($subjects_selected as $subName) {
        $query_insert = "INSERT INTO tbl_sub_combination (classname, subName) 
                         VALUES ('$classname', '$subName')";
        $data = mysqli_query($conn, $query_insert);

        if (!$data) {
            echo "<script>alert('Error adding subject combination: " . mysqli_error($conn) . "');</script>";
            break; // Exit on error
        }
    }

    if ($data) {
        echo "<script>alert('Subject combination added successfully!'); window.location = 'addSubjectCombination.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject Combination</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
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
            /* White text */
            padding: 10px;
            /* Adequate padding */
            text-align: center;
            /* Center align text */
            font-size: 24px;
            /* Larger font */
            /* Space below header */
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
            margin-bottom: 20px;
            /* Space below breadcrumb */
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between items */
        }
        .main{
            display: flex;
            flex:row
            alignt-items: center;
            justify-content: center;
        }

        .main .container{
            width:35%;
        }
      

        /* Container Layout */
        .container {
          
            /* Moderate width */
            margin:50px 40px ;
            /* Center the container */
            padding: 20px;
            /* Padding around the container */
            background: white;
            /* White background */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
            display: flex;
            /* Use flexbox */
            /*decrease width of container; */
           flex-direction: column;
           

        }

        .title {
            font-size: 24px;
        }

        /* Form Styling */
        .form {
           
            display: flex;
            /* Use flexbox */
            flex-direction: column;
            /* Vertical alignment */
           
            /* Align to container width */
        }

        /* Custom Select Field Styling */
        .custom_select {
            margin-bottom: 15px;
            /* Space between elements */
        }

        .custom_select label {
            font-weight: bold;
            /* Bold labels */
            color: #555;
            /* Dark gray color */
        }

        select {
            width: 100%;
            /* Full width */
            padding: 10px;
            /* Padding for select fields */
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 16px;
            /* Adequate font size */
            transition: all 0.3s ease;
            /* Smooth transitions */
        }

        select:focus {
            border-color: #0072ff;
            /* Blue border on focus */
            outline: none;
            /* No default outline */
        }

        /* Submit Button Styling */
        input[type="submit"] {
            background: #0072ff;
            /* Blue background */
            color: white;
            /* White text */
            padding: 10px 20px;
            /* Padding for the button */
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
            background: #005bb5;
            /* Darker blue on hover */
        }

        input[type="submit"]:active {
            transform: scale(0.95);
            /* Slight shrink on click (active state) */
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

            .custom_select {
                margin-bottom: 10px;
                /* Adjust spacing for smaller screens */
            }

            select {
                padding: 8px 12px;
                /* Adjusted padding for smaller screens */
                font-size: 14px;
                /* Smaller font size */
            }

            input[type="submit"] {
                padding: 8px 16px;
                /* Adjusted padding */
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
                /* Smaller font size */
            }
        }
    </style>
</head>

<body>
    <header>
        <h3>Add Subject Combination</h3>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Subjects</a></li>
                <li class="breadcrumb-item"><a href="#">Add Subject Combination</a></li>
                <li class="breadcrumb-item active">Add Subject Combination</li>
            </ol>
        </nav>
    </div>
    <div class="main">
        <div class="dashboard">
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <form action="addSubjectCombination.php" method="POST">
                <div class="form">
                    <!-- Class Selection -->
                    <div class="custom_select">
                        <label>Select Class</label>
                        <select name="classname" required>
                            <option value="">Select Class</option>
                            <?php while ($class = mysqli_fetch_assoc($classes)): ?>
                                <option value="<?php echo htmlspecialchars($class['className']); ?>">
                                    <?php echo htmlspecialchars($class['className']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Unique Subject Selection Fields -->
                    <?php
                    // For each subject select, reset the pointer to avoid repetition
                    mysqli_data_seek($subjects, 0); // Reset pointer
                    ?>

                    <div class="custom_select">
                        <label>Subject 1</label>
                        <select name="subject1" required>
                            <option value="">Select Subject</option>
                            <?php while ($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?php echo htmlspecialchars($subject['subName']); ?>">
                                    <?php echo htmlspecialchars($subject['subName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <?php
                    // Reset the pointer for the next subject
                    mysqli_data_seek($subjects, 0);
                    ?>

                    <div class="custom_select">
                        <label>Subject 2</label>
                        <select name="subject2">
                            <option value="">Select Subject</option>
                            <?php while ($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?php echo htmlspecialchars($subject['subName']); ?>">
                                    <?php echo htmlspecialchars($subject['subName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <?php
                    // Reset pointer for subsequent subjects
                    mysqli_data_seek($subjects, 0);
                    ?>

                    <div class="custom_select">
                        <label>Subject 3</label>
                        <select name="subject3">
                            <option value="">Select Subject</option>
                            <?php while ($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?php echo htmlspecialchars($subject['subName']); ?>">
                                    <?php echo htmlspecialchars($subject['subName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <?php
                    mysqli_data_seek($subjects, 0); // Reset pointer
                    ?>

                    <div class="custom_select">
                        <label>Subject 4</label>
                        <select name="subject4">
                            <option value="">Select Subject</option>
                            <?php while ($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?php echo htmlspecialchars($subject['subName']); ?>">
                                    <?php echo htmlspecialchars($subject['subName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <?php
                    mysqli_data_seek($subjects, 0); // Reset pointer for Subject 5
                    ?>

                    <div class="custom_select">
                        <label>Subject 5</label>
                        <select name="subject5">
                            <option value="">Select Subject</option>
                            <?php while ($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?php echo htmlspecialchars($subject['subName']); ?>">
                                    <?php echo htmlspecialchars($subject['subName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="input_field">
                        <input type="submit" value="Add Subject Combination" class="btn" name="Add" />
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>