<?php
include ("../connection.php");
$courseId = $_GET['courseId'];
$query = "DELETE from tbl_course where courseId = '$courseId'";
$data = mysqli_query($conn, $query);

if ($data) {
    header("Location:http://localhost/student_project/course/manageCourse.php");
    exit();
} else {
    echo "<script>alert('Delete unsucessful');</scipt>";
}
?>