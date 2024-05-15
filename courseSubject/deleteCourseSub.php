<?php
require("../connection.php");

// Retrieve courseId and subCode from URL parameters
$courseId = isset($_GET['courseId']) ? $_GET['courseId'] : null;
$subCode = isset($_GET['subCode']) ? $_GET['subCode'] : null;

if ($courseId && $subCode) {
    // Construct the SQL query to delete the record
    $deleteQuery = "DELETE FROM tbl_course_subject WHERE courseId = '$courseId' AND subCode = '$subCode'";

    // Execute the query and check for success
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: manageCourseSub.php");
        // Optionally, redirect or perform other actions upon successful deletion
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No course Id or subject Code provided.";
}
?>
