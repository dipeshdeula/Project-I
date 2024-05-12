<?php
require_once('../connection.php'); // Include your database connection file

// Function to display results
function displayResult() {
    global $conn;

    // Select necessary fields from tables to display
    $select_query = "SELECT tbl_result.*, tbl_student.stdName, tbl_student.stdId, tbl_classes.className 
                     FROM tbl_result 
                     INNER JOIN tbl_student ON tbl_result.stdId = tbl_student.stdId 
                     INNER JOIN tbl_classes ON tbl_result.className = tbl_classes.className";
    $result = mysqli_query($conn, $select_query);
    if (!$result) {
        die("Error fetching results: " . mysqli_error($conn));
    }

    // Display results in a tabular format
    echo "<table border='1'>
            <tr>
                <th>Student Name</th>
                <th>Student ID</th>
                <th>Class Name</th>
                <th>Theory Marks</th>
                <th>Practical Marks</th>
                <th>Total Marks</th>
                <th>Percentage</th>
                <th>Remarks</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['studentName'] . "</td>";
        echo "<td>" . $row['studentId'] . "</td>";
        echo "<td>" . $row['className'] . "</td>";
        echo "<td>" . $row['theoryMarks'] . "</td>";
        echo "<td>" . $row['practicalMarks'] . "</td>";
        echo "<td>" . $row['totalMarks'] . "</td>";
        echo "<td>" . $row['percentage'] . "</td>";
        echo "<td>" . $row['remarks'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Call the function to display results
displayResult();
?>
