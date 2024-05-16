<?php
require("../connection.php");

// Collect data from POST request
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['stdId']) && !empty($data['examId']) && !empty($data['subCode'])) {
    // Sanitize input data
    $stdId = mysqli_real_escape_string($conn, $data['stdId']);
    $examId = mysqli_real_escape_string($conn, $data['examId']);
    $subCode = mysqli_real_escape_string($conn, $data['subCode']);

    // Check for duplicate record in tbl_result
    $query_check_duplicate = "SELECT * FROM tbl_result WHERE stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
    $result_check_duplicate = mysqli_query($conn, $query_check_duplicate);

    if ($result_check_duplicate && mysqli_num_rows($result_check_duplicate) > 0) {
        // Duplicate record found
        echo json_encode(array("duplicate" => true));
    } else {
        // No duplicate record found
        echo json_encode(array("duplicate" => false));
    }
} else {
    // Invalid or missing data
    echo json_encode(array("error" => "Invalid or missing data"));
}

// Close database connection
mysqli_close($conn);
?>
