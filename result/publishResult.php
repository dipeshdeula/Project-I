<?php
require("../connection.php");



error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$stdId = '';
$row_student = [];
$result_subjects = [];
$totalTheoryMarks = 0;
$totalPracticalMarks = 0;
$totalMarks = 0;
$percentage = 0;
$remarks = '';
$courseName = '';
$semester = '';
$examId = '';
$examName = '';

// Check if the student ID is provided in the URL
if (isset($_GET['stdId'])) {
    $stdId = $_GET['stdId'];

    // Fetch student details
    $query_student = "SELECT * FROM tbl_student WHERE stdId = '$stdId'";
    $result_student = mysqli_query($conn, $query_student);
    if ($result_student && mysqli_num_rows($result_student) > 0) {
        $row_student = mysqli_fetch_assoc($result_student);
        $courseId = $row_student['courseId']; // assuming courseId is a column in tbl_student
        $semester = $row_student['semester']; // assuming semester is a column in tbl_student

        // Fetch course details
        $query_course = "SELECT courseName FROM tbl_course WHERE courseId = '$courseId'";
        $result_course = mysqli_query($conn, $query_course);
        if ($result_course && mysqli_num_rows($result_course) > 0) {
            $row_course = mysqli_fetch_assoc($result_course);
            $courseName = $row_course['courseName'];
        }

        // Fetch result details
        $query_result = "SELECT * FROM tbl_result WHERE stdId = '$stdId' AND status = 'Published'";
        $result_result = mysqli_query($conn, $query_result);

        // Fetch subject details and calculate total marks
        while ($row = mysqli_fetch_assoc($result_result)) {
            $examId = $row['examId']; // Store the examId for fetching exam details

            $query_subject = "SELECT * FROM tbl_subjects WHERE subCode = '{$row['subCode']}'";
            $result_subject = mysqli_query($conn, $query_subject);
            if ($result_subject && mysqli_num_rows($result_subject) > 0) {
                $row_subject = mysqli_fetch_assoc($result_subject);

                // Calculate total marks
                $totalTheoryMarks += $row['theoryMarks'];
                $totalPracticalMarks += $row['practicalMarks'];

                // Store subject details
                $result_subjects[] = array(
                    'subCode' => $row['subCode'],
                    'subName' => $row_subject['subName'],
                    'theoryMarks' => $row['theoryMarks'],
                    'practicalMarks' => $row['practicalMarks']
                );
            }
        }

        // Fetch exam details
        $query_exam = "SELECT examName FROM tbl_exam WHERE examId = '$examId'";
        $result_exam = mysqli_query($conn, $query_exam);
        if ($result_exam && mysqli_num_rows($result_exam) > 0) {
            $row_exam = mysqli_fetch_assoc($result_exam);
            $examName = $row_exam['examName'];
        }

        // Calculate total marks, percentage, and remarks
        if (count($result_subjects) > 0) {
            $totalMarks = $totalTheoryMarks + $totalPracticalMarks;
            $percentage = ($totalMarks / (count($result_subjects) * 100)) * 100;
            $remarks = ($percentage >= 40) ? 'Pass' : 'Fail';
        }
    } else {
        echo "No student found with ID: $stdId";
    }
} else {
    echo "No student ID provided.";
    exit; // Terminate script execution if no student ID provided
}
?>
<!DO
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Student Result</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 960px;
    margin: 20px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.header h1 {
    margin: 0;
}

.header h4 {
    margin-top: 5px;
    margin-bottom: 20px;
}

.main {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.std_details,
.table,
.calculated_result {
    flex: 1;
}

.std_details label,
.table th,
.table td,
.calculated_result label {
    font-weight: bold;
}

.std_details input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.table,
.calculated_result {
    overflow-x: auto;
}

.table table,
.calculated_result {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td,
.calculated_result input[type="text"] {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

.table th {
    background-color: #f2f2f2;
}

.calculated_result input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

@media screen and (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .main {
        flex-direction: column;
    }

    .std_details,
    .table,
    .calculated_result {
        width: 100%;
    }
}

    </style>
</head>
<body>
    <h1>Publish Student Result</h1>
    <div class="container">
        <div class="header">
            <h1>JALJALA MAKWANPUR CAMPUS</h1>
            <h4>KALPANA ROAD HETAUDA</h4>
        </div>

        <div class="main">
            <div class="std_details">
                <label for="stdId">Student ID</label>
                <input type="text" name="stdId" id="stdId" value="<?php echo htmlspecialchars($stdId); ?>" >

                <label for="stdName">Student Name</label>
                <input type="text" name="stdName" id="stdName" value="<?php echo htmlspecialchars($row_student['stdname'] ?? ''); ?>" >

                <!-- Populate image by fetching from database -->
                <label for="stdImg">Student Image</label>
                <?php if (!empty($row_student['std_image'])): ?>
                    <img src="<?php echo htmlspecialchars($row_student['std_image']); ?>" alt="Student Image">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>

                <label for="courseName">Course</label>
                <input type="text" name="courseName" id="courseName" value="<?php echo htmlspecialchars($courseName); ?>" >

                <label for="semester">Semester</label>
                <input type="text" name="semester" id="semester" value="<?php echo htmlspecialchars($semester); ?>" >

                <label for="examId">Exam ID</label>
                <input type="text" name="examId" id="examId" value="<?php echo htmlspecialchars($examId); ?>" >

                <label for="examName">Exam Name</label>
                <input type="text" name="examName" id="examName" value="<?php echo htmlspecialchars($examName); ?>" >
            </div>

            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Theory Marks</th>
                            <th>Practical Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($result_subjects) > 0): ?>
                            <?php foreach ($result_subjects as $subject) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($subject['subCode']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['subName']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['theoryMarks']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['practicalMarks']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No results found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="calculated_result">
                    <label for="totalMarks">Total Marks</label>
                    <input type="text" name="totalMarks" id="totalMarks" value="<?php echo htmlspecialchars($totalMarks); ?>" >

                    <label for="percentage">Percentage</label>
                    <input type="text" name="percentage" id="percentage" value="<?php echo htmlspecialchars($percentage); ?>" >

                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" id="remarks" value="<?php echo htmlspecialchars($remarks); ?>" >
                </div>
            </div>
        </div>
    </div>
</body>
</html>

