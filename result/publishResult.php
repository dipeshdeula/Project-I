<?php
require ("../connection.php");

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
// $std_image = '';

// Check if the student ID is provided in the URL
if (isset($_GET['stdId'])) {
    $stdId = $_GET['stdId'];

    // Fetch student details
    $query_student = "SELECT * FROM tbl_student WHERE stdId = '$stdId'";
    $result_student = mysqli_query($conn, $query_student);
    if ($result_student && mysqli_num_rows($result_student) > 0) {
        $row_student = mysqli_fetch_assoc($result_student);
        // $std_image = $row_student['std_image'];
       

        // Fetch course and semester details
        $query_course = "SELECT tbl_course.courseName, tbl_course_subject.semester 
                         FROM tbl_course 
                         INNER JOIN tbl_course_subject ON tbl_course.courseId = tbl_course_subject.courseId 
                         INNER JOIN tbl_result ON tbl_course_subject.subCode = tbl_result.subCode 
                         WHERE tbl_result.stdId = '$stdId' LIMIT 1";
        $result_course = mysqli_query($conn, $query_course);
        if ($result_course && mysqli_num_rows($result_course) > 0) {
            $row_course = mysqli_fetch_assoc($result_course);
            $courseName = $row_course['courseName'];
            $semester = $row_course['semester'];
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Student Result</title>
    <style>
    body {
        font-family: Poppins;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 960px;
        margin: 20px auto;
        padding: 20px;
        background: #fff; /* Blue background */
        color: #000; /* White font color */
        border-radius: 10px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: center; /* Center align header */
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
    }

    .header h4 {
        margin-top: 5px;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .main {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between; /* Align items evenly */
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
        font-family: Poppins;
        font-size: 19px;
        font-weight: bold;
    }

    .std_details input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
    }

    .table {
        display: flex;
        flex-direction: column;
        align-items: left;
        margin-top: 40px;
        margin-left: 25px;
    }

    .calculated_result {
        flex: 1;
        margin-top: 20px;
        padding: 20px;
    }

    
    .calculated_result {
        width: 70%;
       
    }

    .table th,
    .table td,
    .calculated_result input[type="text"] {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
        font-size: 16px;
        font-weight: bold;
    }

    .table th {
        background-color: #000;
        color: #fff;
    }

    .calculated_result input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right:25 px;
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
    <!-- <h1>Publish Student Result</h1> -->
    <div class="container">
        <div class="header">
            <h1>HETAUDA SCHOOL OF MANAGEMENT AND SOCIAL SCIENCES</h1>
            <h4>HETAUDA-4, MAKWANPUR</h4>
        </div>
        <hr>

        <div class="main">
            <div class="std_details">
                <label for="stdId">Student ID</label>
                <input type="text" name="stdId" id="stdId" value="<?php echo htmlspecialchars($stdId); ?>" re>

                <label for="stdName">Student Name</label>
                <input type="text" name="stdName" id="stdName"
                    value="<?php echo htmlspecialchars($row_student['stdname'] ?? ''); ?>" readonly>

                <!-- Populate image by fetching from database -->
                
                <label for="courseName">Course</label>
                <input type="text" name="courseName" id="courseName"
                    value="<?php echo htmlspecialchars($courseName); ?>" readonly>

                <label for="semester">Semester</label>
                <input type="text" name="semester" id="semester" value="<?php echo htmlspecialchars($semester); ?>" readonly>

                <!-- <label for="examId">Exam ID</label> -->
                <input type="hidden" name="examId" id="examId" value="<?php echo htmlspecialchars($examId); ?>" readonly>

                <label for="examName">Exam Type</label>
                <input type="text" name="examName" id="examName" value="<?php echo htmlspecialchars($examName); ?>" readonly>
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
                            <?php foreach ($result_subjects as $subject): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($subject['subCode']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['subName']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['theoryMarks']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['practicalMarks']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No results found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="calculated_result">
          
            <input type="hidden" name="totalTheoryMarks" id="totalTheoryMarks"
                value="<?php echo htmlspecialchars($totalTheoryMarks); ?>" readonly>

         
            <input type="hidden" name="totalPracticalMarks" id="totalPracticalMarks"
                value="<?php echo htmlspecialchars($totalPracticalMarks);  ?>" readonly>

            <label for="totalMarks">Total Marks</label>
            <input type="text" name="totalMarks" id="totalMarks" value="<?php echo htmlspecialchars($totalMarks); ?>" readonly>

            <label for="percentage">Percentage</label>
            <input type="text" name="percentage" id="percentage"
                value="<?php echo htmlspecialchars(number_format($percentage, 2)); ?>">

            <label for="remarks">Remarks</label>
            <input type="text" name="remarks" id="remarks" value="<?php echo htmlspecialchars($remarks); ?>" readonly>
        </div>
    </div>
</body>

</html>
