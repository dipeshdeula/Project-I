<?php
require_once("../connection.php");

// Fetch the subCode from the query string
$subCode = isset($_GET['subCode']) ? trim($_GET['subCode']) : '';

// Delete the subject combination
$query = "DELETE FROM tbl_subjects WHERE subCode = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $subCode);
$result = mysqli_stmt_execute($stmt);
if ($result) {
    echo "<script>alert('Subject combination deleted successfully!'); window.location = 'manageSubjectCombination.php';</script>";
} else {
    echo "<script>alert('Error deleting subject combination: " . mysqli_error($conn) . "');</script>";
}
?>