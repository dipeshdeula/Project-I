<?php
require("../connection.php");

// Retrieve examId URL parameters
$examId = isset($_GET['examId']) ? $_GET['examId'] : null;


if ($examId) {
    // Construct the SQL query to delete the record
    $deleteQuery = "DELETE FROM tbl_exam WHERE examId = '$examId'";

    // Execute the query and check for success
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: manageExam.php");
        // Optionally, redirect or perform other actions upon successful deletion
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No exam Id  provided.";
}
?>
