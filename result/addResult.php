<?php
require ("../connection.php");

// Fetch data for stdId dropdown
$query_stdId = "SELECT stdId FROM tbl_student";
$result_stdId = mysqli_query($conn, $query_stdId);

// Fetch data for examId dropdown
$query_examId = "SELECT examId FROM tbl_exam";
$result_examId = mysqli_query($conn, $query_examId);

// Fetch data for subCode dropdown
$query_subCode = "SELECT subCode FROM tbl_course_subject";
$result_subCode = mysqli_query($conn, $query_subCode);

// Initialize variables for maxTheoryMarks and maxPracticalMarks
$maxTheoryMarks = $maxPracticalMarks = 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $stdId = mysqli_real_escape_string($conn, $_POST['stdId']);
    $examId = mysqli_real_escape_string($conn, $_POST['examId']);
    $subCode = mysqli_real_escape_string($conn, $_POST['subCode']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $theoryMarks = mysqli_real_escape_string($conn, $_POST['theoryMarks']);
    $practicalMarks = mysqli_real_escape_string($conn, $_POST['practicalMarks']);

    // Fetch max marks for theory and practical from tbl_subjects
    $query_max_marks = "SELECT thFM, prFM FROM tbl_subjects WHERE subCode = '$subCode'";
    $result_max_marks = mysqli_query($conn, $query_max_marks);
    if ($result_max_marks && mysqli_num_rows($result_max_marks) > 0) {
        $row_max_marks = mysqli_fetch_assoc($result_max_marks);
        $maxTheoryMarks = $row_max_marks['thFM'];
        $maxPracticalMarks = $row_max_marks['prFM'];
    } else {
        echo "Error fetching max marks: " . mysqli_error($conn);
        exit;
    }

    // Calculate total marks obtained
    $totalMarks = $theoryMarks + $practicalMarks;

    // Determine pass/fail status
    $status = ($theoryMarks < 25 || $practicalMarks < 12) ? 'Fail' : 'Pass';

    // Determine remarks
    $remarks = ($status == 'Fail') ? 'Fail' : 'Pass';

    // Check if an entry already exists for the given stdId, examId, and subCode combination
    $query_check_existing = "SELECT * FROM tbl_result WHERE stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
    $result_check_existing = mysqli_query($conn, $query_check_existing);

    if (mysqli_num_rows($result_check_existing) > 0) {
        // Entry already exists, so update the existing entry instead of inserting a new one
        $query_update_result = "UPDATE tbl_result SET date = '$date', theoryMarks = '$theoryMarks', practicalMarks = '$practicalMarks', remarks = '$remarks' WHERE stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
        if (mysqli_query($conn, $query_update_result)) {
            echo "Result updated successfully.";
        } else {
            echo "Error updating result: " . mysqli_error($conn);
        }
    } else {
        // Entry does not exist, so insert a new entry
        $query_insert_result = "INSERT INTO tbl_result (stdId, examId, subCode, date, theoryMarks, practicalMarks, remarks)
                            VALUES ('$stdId', '$examId', '$subCode', '$date', '$theoryMarks', '$practicalMarks', '$remarks')";
        if (mysqli_query($conn, $query_insert_result)) {
            // echo "Result added successfully.";
            header("Location: manageResult.php");
        } else {
            echo "Error adding result: " . mysqli_error($conn);
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Result</title>
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
        <h3>Add Results</h3>
    </header>

    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Results</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Results</a></li>
                <li class="breadcrub-item"><a href="../adminSection/adminLogin.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>

            </ol>
        </nav>
    </div>
    <div class="main">
        <div class="dashboard">
            <?php include ('../includes/leftbar.php'); ?>
        </div>
        <div class="container">
            <div class="form">
                <form action="#" method="POST" id="resultForm">

                    <div class="select_field">
                        <label for="stdId">Student ID</label>
                        <select name="stdId" id="stdId">
                            <?php
                            while ($row_stdId = mysqli_fetch_assoc($result_stdId)) {
                                echo "<option value='" . $row_stdId['stdId'] . "'>" . $row_stdId['stdId'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="select_field">
                        <label for="examId">Exam Id</label>
                        <select name="examId" id="examId">
                            <?php
                            while ($row_examId = mysqli_fetch_assoc($result_examId)) {
                                echo "<option value='" . $row_examId['examId'] . "'>" . $row_examId['examId'] . "</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="select_field">
                        <label for="subCode">Subject Code</label>
                        <select name="subCode" id="subCode">
                            <?php
                            while ($row_subCode = mysqli_fetch_assoc($result_subCode)) {
                                echo "<option value='" . $row_subCode['subCode'] . "'>" . $row_subCode['subCode'] . "</option>";
                            }
                            ?>
                        </select>

                    </div>

                    <div class="date_field">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date">

                    </div>

                    <div class="input_field">
                        <label for="thMarks">Theory Marks (Max: <?php echo 75 ?>)</label>
                        <input type="number" name="theoryMarks" id="thMarks" value="">
                    </div>

                    <div class="input_field">
                        <label for="prMarks">Practical Marks (Max: <?php echo 25 ?>)</label>
                        <input type="number" name="practicalMarks" id="prMarks" value="">

                    </div>
                    <div class="button_field">

                        <button type="submit">Submit</button>

                    </div>
                </form>


            </div>

        </div>
    </div>

</body>
<script>
    document.getElementById('resultForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        // Collect form data
        var formData = new FormData(this);

        // Convert formData to JSON
        var jsonData = {};
        formData.forEach(function (value, key) {
            jsonData[key] = value;
        });

        // Check if the data is duplicate via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'check_duplicate.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.duplicate) {
                        alert('Data already exists! Please enter unique data.');
                    } else {
                        // If not duplicate, submit the form
                        document.getElementById('resultForm').submit();
                    }
                } else {
                    console.error('Error checking for duplicate data');
                }
            }
        };
        xhr.send(JSON.stringify(jsonData));
    });
</script>

</html>