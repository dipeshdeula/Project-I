<?php
require ("../connection.php");

if (isset($_GET['stdId']) && isset($_GET['examId']) && isset($_GET['subCode'])) {
    // Retrieve stdId, examId, and subCode from the URL
    $stdId = $_GET['stdId'];
    $examId = $_GET['examId'];
    $subCode = $_GET['subCode'];

    // Fetch existing result data
    $query_result = "SELECT * FROM tbl_result WHERE stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
    $result_result = mysqli_query($conn, $query_result);

    if (mysqli_num_rows($result_result) == 1) {
        $row = mysqli_fetch_assoc($result_result);

        // Fetch data for stdId dropdown
        $query_stdId = "SELECT stdId FROM tbl_student";
        $result_stdId = mysqli_query($conn, $query_stdId);

        // Fetch data for examId dropdown
        $query_examId = "SELECT examId FROM tbl_exam";
        $result_examId = mysqli_query($conn, $query_examId);

        // Fetch data for subCode dropdown
        $query_subCode = "SELECT subCode FROM tbl_course_subject";
        $result_subCode = mysqli_query($conn, $query_subCode);
    } else {
        echo "Result not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $date = $_POST['date'];
    $theoryMarks = $_POST['theoryMarks'];
    $practicalMarks = $_POST['practicalMarks'];

    // Fetch max marks for theory and practical from tbl_subjects
    $query_max_marks = "SELECT thFM, prFM FROM tbl_subjects WHERE subCode = '{$row['subCode']}'";
    $result_max_marks = mysqli_query($conn, $query_max_marks);
    $row_max_marks = mysqli_fetch_assoc($result_max_marks);
    $maxTheoryMarks = $row_max_marks['thFM'];
    $maxPracticalMarks = $row_max_marks['prFM'];

    // Calculate total marks obtained
    $totalMarks = $theoryMarks + $practicalMarks;

    // Determine pass/fail status
    $status = ($theoryMarks < 25 || $practicalMarks < 12) ? 'Fail' : 'Pass';

    // Determine remarks
    $remarks = ($status == 'Fail') ? 'Fail' : 'Pass';

    // Update data in tbl_result
    $query_update_result = "UPDATE tbl_result SET date = '$date', theoryMarks = '$theoryMarks', practicalMarks = '$practicalMarks', remarks = '$remarks' WHERE stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
    if (mysqli_query($conn, $query_update_result)) {
        // echo "Result updated successfully.";
        header("Location: manageResult.php");
    } else {
        echo "Error updating result: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Result</title>
    <style>
        /* Global Styling */
        body {
            font-family: Poppins, sans-serif;
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
            text-align: center;
            font-size: 24px;
            /* Larger text for better visibility */
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
            background: none;
            /* No background */
        }

        .breadcrumb-item {
            margin-right: 10px;
            /* Space between breadcrumb items */
        }

        /* Main container */
        .main {
            display: flex;
            flex-direction: row;
            /* Side-by-side elements */

        }


        .main .container {
            height: 30%;
            width: 30%
        }


        .container {
            display: flex;
            flex-direction: column;
            align-items: left;
            justify-content: center;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        .select_field,
        .input_field,
        .date_field {
            width: 100%;
            margin-bottom: 20px;
        }


        .select_field label,
        .input_field label,
        .date_field label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .select_field select,
        .input_field input[type="number"],
        .input_field input[type="date"] {
            width: calc(100% - 10px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #date {
            width: calc(100% - 10px);
            border: 1px solid #ccc;
            border-radius: 5px;

            padding: 10px;
        }

        .button_field button {
            width: 100%;
            background-color: #0072ff;
            color: #fff;
            padding: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button_field button:hover {
            background-color: #005bb5;
        }

        .readonly {
            background-color: #f2f2f2;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <header>
        <h3>Update Results</h3>
    </header>
    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Results</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Results</a></li>

            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php include('../includes/leftbar.php');?>
        </div>

            <div class="container">
                <div class="form">
                    <form action="#" method="POST" id="resultForm">
                        <div class="select_field">
                            <label for="stdId">Student ID</label>
                            <select name="stdId" id="stdId" disabled>
                                <option value="<?php echo $row['stdId']; ?>"><?php echo $row['stdId']; ?></option>
                            </select>
                        </div>

                        <div class="select_field">
                            <label for="examId">Exam Id</label>
                            <select name="examId" id="examId" disabled>
                                <option value="<?php echo $row['examId']; ?>"><?php echo $row['examId']; ?></option>
                            </select>

                        </div>

                        <div class="select_field">

                            <label for="subCode">Subject Code</label>
                            <select name="subCode" id="subCode" disabled>
                                <option value="<?php echo $row['subCode']; ?>"><?php echo $row['subCode']; ?></option>
                            </select>

                        </div>
                        <div class="date_field">

                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" value="<?php echo $row['date']; ?>">

                        </div>

                        <div class="input_field">

                            <label for="thMarks">Theory Marks (Max:
                                <?php echo isset($maxTheoryMarks) ? $maxTheoryMarks : '75'; ?>)</label>
                            <input type="number" name="theoryMarks" id="thMarks"
                                value="<?php echo isset($row['theoryMarks']) ? $row['theoryMarks'] : ''; ?>">
                       </div>
                        <div class="input_field">
                            <label for="prMarks">Practical Marks (Max:
                                <?php echo isset($maxPracticalMarks) ? $maxPracticalMarks : '25'; ?>)</label>
                            <input type="number" name="practicalMarks" id="prMarks"
                                value="<?php echo isset($row['practicalMarks']) ? $row['practicalMarks'] : ''; ?>">
                        </div>
                        <div class="button_field">
                            <button type="submit">Update</button>

                        </div>

                    </form>
                </div>

            </div>
      
    </div>

</body>

</html>