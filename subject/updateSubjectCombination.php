<?php
require_once("../connection.php"); // Include your database connection script

// Get the subCode from the URL
$subCode = isset($_GET['subCode']) ? trim($_GET['subCode']) : '';

// Check if the subCode is provided
if (empty($subCode)) {
    die("Error: No subject code provided.");
}

// Fetch the subject data using subCode
$query = "SELECT subCode, subName FROM tbl_subjects WHERE subCode = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $subCode);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$subject = mysqli_fetch_assoc($result);

// If the subCode does not exist in tbl_subjects, return an error
if (!$subject) {
    die("Error: No subject found for the provided subCode.");
}

// Fetch the current subject combination using the subName
$query_combination = "SELECT className, subName FROM tbl_sub_combination WHERE subName = ?";
$stmt = mysqli_prepare($conn, $query_combination);
mysqli_stmt_bind_param($stmt, "s", $subject['subName']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$existing_combination = mysqli_fetch_assoc($result);

// If no combination is found, return an error
if (!$existing_combination) {
    die("Error: No subject combination found for the provided subCode.");
}

// Fetch all available classes and subjects
$classes_query = "SELECT className FROM tbl_classes";
$classes = mysqli_query($conn, $classes_query);

$subjects_query = "SELECT subName FROM tbl_subjects";
$subjects = mysqli_query($conn, $subjects_query);

// Handle form submission to update the subject combination
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Update'])) {
    $new_className = trim($_POST['classname']);
    $new_subName = trim($_POST['subject']);

    // Update the subject combination in tbl_sub_combination
    $query_update = "UPDATE tbl_sub_combination SET className = ?, subName = ? WHERE subName = ?";
    $stmt = mysqli_prepare($conn, $query_update);
    mysqli_stmt_bind_param($stmt, "sss", $new_className, $new_subName, $existing_combination['subName']);

    if (mysqli_stmt_execute($stmt)) {
       // echo "<script>alert('Subject combination updated successfully!'); window.location = 'manageSubjectCombination.php';</script>";
       header("Location: manageSubjectCombination.php");
    } else {
        echo "<script>alert('Error updating subject combination: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Subject Combination</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS and other head elements -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Basic styling for the form and layout */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }
        
        header {
            background-color: #0072ff;
            color: white;
            padding: 20px;
            text-align: center;
        }

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
        .nav a i{
            margin-right: 5px;
            margin-top: 5px;
            font-size: 15px;
        }

        .breadcrumb {
            margin-right: 0px;
            padding: 10px;
            margin-bottom: 20px;
            background: none;
        }
        .main{
            display: flex;
            flex-direction: row;
        }

        .main .container{
           
            padding: 20px;
            height: 70%;
            width:50%;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .custom_select {
            margin-bottom: 20px;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
       .container .updatebtn {
           
            background-color: #0072ff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            border: none;
            text-align: center;
        }
        .updatebtn:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>
    <header>
        <h3>Update Subject Combination</h3>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Subjects</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Subjects</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include("../includes/leftbar.php"); ?>
        </div>

        <div class="container">
        <form method="POST" action="">
            <!-- Class Selection -->
            <div class="custom_select">
                <label>Select Class</label>
                <select name="classname" required>
                    <option value="">Select Class</option>
                    <?php while ($class = mysqli_fetch_assoc($classes)): ?>
                        <option value="<?php echo htmlspecialchars($class['className']); ?>" 
                            <?php echo $existing_combination['className'] === $class['className'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($class['className']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Subject Selection -->
            <div class="custom_select">
                <label>Select Subject</label>
                <select name="subject" required>
                    <option value="">Select Subject</option>
                    <?php
                    mysqli_data_seek($subjects, 0); // Reset pointer
                    while ($subject = mysqli_fetch_assoc($subjects)): 
                    ?>
                        <option value="<?php echo htmlspecialchars($subject['subName']); ?>" 
                            <?php echo $existing_combination['subName'] === $subject['subName'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($subject['subName']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Submit Button -->
            
            <input type="submit" value="Update Subject Combination" class="updatebtn" name="Update" />

         
            
        </form>
    </div>

    </div>

   
    <!-- Include Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
