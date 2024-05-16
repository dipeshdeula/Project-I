<?php
include ("../connection.php");
$stdId = $_GET['stdId'];
$examId = $_GET['examId'];
$subCode = $_GET['subCode'];

$query = "DELETE from tbl_result where stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
$data = mysqli_query($conn, $query);

if ($data) {
    header("Location:http://localhost/student_project/result/manageResult.php");
    exit();
} else {
    echo "<script>alert('Delete unsucessful');</scipt>";
}
?>