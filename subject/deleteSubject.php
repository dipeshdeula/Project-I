<?php
require_once("../connection.php");

$subCode = isset($_GET['id']) ? $_GET['id'] : null;

if ($subCode) {
    $query = "DELETE FROM tbl_subjects WHERE subCode = '$subCode'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Subject deleted successfully'); window.location='manageSubject.php';</script>";
    } else {
        echo "<script>alert('Error deleting subject: " . mysqli_error($conn) . "'); window.location='manageSubject.php';</script>";
    }
} else {
    echo "<script>alert('No subject code provided'); window.location='manageSubject.php';</script>";
}
?>
