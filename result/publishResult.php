<?php
include('../conection.php');

//select the student data like stdId,stdname from tbl_student
$query_std = "SELECT stdId,stdName FROM tbl_student";
$result_std = mysqli_query($con, $query_std);

//select the exam data like examId,examName from tbl_exam
$query_exam = "SELECT examId,examName FROM tbl_exam";
$result_exam = mysqli_query($con, $query_exam);

//select the subject data like subId,subName from tbl_subject
$query_sub = "SELECT subId,subName FROM tbl_subject";
$result_sub = mysqli_query($con, $query_sub);

//select the course data like courseId,courseName from tbl_course
$query_course = "SELECT courseId,courseName FROM tbl_course";
$result_course = mysqli_query($con, $query_course);

//select the course subject data like courseSubId,courseId,subId from tbl_coursesubject
$query_courseSub = "SELECT courseSubId,courseId,subId FROM tbl_coursesubject";
$result_courseSub = mysqli_query($con, $query_courseSub);

//select the result data like stdId,examId,subCode,theoryMarks,practicalmarks from tbl_result
$query_result = "SELECT * FROM tbl_result";
$result_result = mysqli_query($con, $query_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>publish result</title>
</head>
<body>
    <header>
      Publish Result
    </header>

    <form action="#" method="POST">
        <label for="stdId">Student ID:</label>
        <select name="stdId" id="stdId">
            <option value="">Select Student</option>
            <?php
            while ($row_std = mysqli_fetch_array($result_std)) {
                echo "<option value='" . $row_std['stdId'] . "'>" . $row_std['stdName'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="examId">Exam Name:</label>
        <select name="examId" id="examId">
            <option value="">Select Exam</option>
            <?php
            while ($row_exam = mysqli_fetch_array($result_exam)) {
                echo "<option value='" . $row_exam['examId'] . "'>" . $row_exam['examName'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="subId">Subject Name:</label>
        <select name="subId" id="subId">
            <option value="">Select Subject</option>
            <?php
            while ($row_sub = mysqli_fetch_array($result_sub)) {
                echo "<option value='" . $row_sub['subId'] . "'>" . $row_sub['subName'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="courseId">Course Name:</label>
        <select name="courseId" id="courseId">
            <option value="">Select Course</option>
            <?php
            while ($row_course = mysqli_fetch_array($result_course)) {
                echo "<option value='" . $row_course['courseId'] . "'>" . $row_course['courseName'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="courseSubId">Course Subject:</label>
        <select name="courseSubId" id="courseSubId">
            <option value="">Select Course Subject</option>
            <?php
            while ($row_courseSub = mysqli_fetch_array($result_courseSub)) {
                echo "<option value='" . $row_courseSub['courseSubId'] . "'>" . $row_courseSub['courseId'] . " - " . $row_courseSub['subId'] . "</option>";
            }
            ?>
        </
    </form>
    
</body>
</html>