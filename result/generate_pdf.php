<?php
require ("../connection.php");
require_once('../tcpdf/tcpdf.php');

if (isset($_GET['stdId'])) {
    $stdId = $_GET['stdId'];

    // Fetch student details
    $query_student = "SELECT * FROM tbl_student WHERE stdId = '$stdId'";
    $result_student = mysqli_query($conn, $query_student);
    $row_student = mysqli_fetch_assoc($result_student);

    // Fetch course and semester details
    $query_course = "SELECT tbl_course.courseName, tbl_course_subject.semester 
                     FROM tbl_course 
                     INNER JOIN tbl_course_subject ON tbl_course.courseId = tbl_course_subject.courseId 
                     INNER JOIN tbl_result ON tbl_course_subject.subCode = tbl_result.subCode 
                     WHERE tbl_result.stdId = '$stdId' LIMIT 1";
    $result_course = mysqli_query($conn, $query_course);
    $row_course = mysqli_fetch_assoc($result_course);

    // Fetch result details
    $query_result = "SELECT * FROM tbl_result WHERE stdId = '$stdId' AND status = 'Published'";
    $result_result = mysqli_query($conn, $query_result);

    $result_subjects = [];
    $totalTheoryMarks = 0;
    $totalPracticalMarks = 0;
    while ($row = mysqli_fetch_assoc($result_result)) {
        $examId = $row['examId']; // Store the examId for fetching exam details

        $query_subject = "SELECT * FROM tbl_subjects WHERE subCode = '{$row['subCode']}'";
        $result_subject = mysqli_query($conn, $query_subject);
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

    // Fetch exam details
    $query_exam = "SELECT examName FROM tbl_exam WHERE examId = '$examId'";
    $result_exam = mysqli_query($conn, $query_exam);
    $row_exam = mysqli_fetch_assoc($result_exam);

    // Calculate total marks, percentage, and remarks
    $totalMarks = $totalTheoryMarks + $totalPracticalMarks;
    $percentage = ($totalMarks / (count($result_subjects) * 100)) * 100;
    $remarks = ($percentage >= 40) ? 'Pass' : 'Fail';

    // Generate PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    
    $html = '
    <h1>HETAUDA SCHOOL OF MANAGEMENT AND SOCIAL SCIENCES</h1>
    <h4>HETAUDA-4, MAKWANPUR</h4>
    <hr>
    <h3>Student Infomation</h3>
    <table border="1" cellspacing="3" cellpadding="4">
        <tr>
            <th>Student ID</th>
            <td>' . htmlspecialchars($stdId) . '</td>
        </tr>
        <tr>
            <th>Student Name</th>
            <td>' . htmlspecialchars($row_student['stdname']) . '</td>
        </tr>
        <tr>
            <th>Course</th>
            <td>' . htmlspecialchars($row_course['courseName']) . '</td>
        </tr>
        <tr>
            <th>Semester</th>
            <td>' . htmlspecialchars($row_course['semester']) . '</td>
        </tr>
        <tr>
            <th>Exam Type</th>
            <td>' . htmlspecialchars($row_exam['examName']) . '</td>
        </tr>
    </table>
    <h4>Marks Obtained</h4>
    <table border="1" cellspacing="3" cellpadding="4">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Theory Marks</th>
                <th>Practical Marks</th>
            </tr>
        </thead>
        <tbody>';
    
    foreach ($result_subjects as $subject) {
        $html .= '
        <tr>
            <td>' . htmlspecialchars($subject['subCode']) . '</td>
            <td>' . htmlspecialchars($subject['subName']) . '</td>
            <td>' . htmlspecialchars($subject['theoryMarks']) . '</td>
            <td>' . htmlspecialchars($subject['practicalMarks']) . '</td>
        </tr>';
    }

    $html .= '
        </tbody>
    </table>
    <h4>Summary</h4>
    <table border="1" cellspacing="3" cellpadding="4">
        <tr>
            <th>Total Marks</th>
            <td>' . htmlspecialchars($totalMarks) . '</td>
        </tr>
        <tr>
            <th>Percentage</th>
            <td>' . htmlspecialchars(number_format($percentage, 2)) . '</td>
        </tr>
        <tr>
            <th>Remarks</th>
            <td>' . htmlspecialchars($remarks) . '</td>
        </tr>
    </table>';

    $pdf->writeHTML($html);
    $pdf->Output('result.pdf', 'D');
} else {
    echo "No student ID provided.";
    exit; // Terminate script execution if no student ID provided
}
?>
