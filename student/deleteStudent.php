<?php
require_once("../connection.php");

$stdId = isset($_GET['id']) ? $_GET['id'] : null;

if ($stdId) {
    $query = "DELETE FROM tbl_student WHERE stdId = '$stdId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Student deleted successfully.'); window.location='manageStudent.php';</script>";
    } else {
        echo "<script>alert('Error deleting student: " . mysqli_error($conn) . "'); window.location='manageStudent.php';</script>";
    }
} else {
    echo "<script>alert('No student ID provided'); window.location='manageStudent.php';</script>";
}
