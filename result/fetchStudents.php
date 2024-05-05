<?php
require_once("../connection.php");

$className = isset($_GET['className']) ? trim($_GET['className']) : '';

if (empty($className)) {
    echo json_encode(["error" => "Class name is required."]);
    exit;
}

// Fetch students based on the given class name
$query = "SELECT stdId, stdname 
          FROM tbl_student 
          WHERE className = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    echo json_encode(["error" => "Error preparing SQL statement: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $className); // Bind the className parameter
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Initialize the dropdown HTML for names and IDs
$html_name = '<select name="studentName" required id="studentNameDropdown">'; // Dropdown for names
$html_id = '<select name="studentId" required id="studentIdDropdown">';     // Dropdown for IDs

$html_name .= '<option value="">Select Student Name</option>'; // Default option for names
$html_id .= '<option value="">Select Student ID</option>';    // Default option for IDs

while ($student = mysqli_fetch_assoc($result)) {
    $stdId = htmlspecialchars($student['stdId']);
    $stdname = htmlspecialchars($student['stdname']);
    
    $html_name .= "<option value=\"$stdname\">$stdname</option>"; // Add names to the dropdown
    $html_id .= "<option value=\"$stdId\">$stdId</option>";       // Add IDs to the dropdown
}

$html_name .= '</select>'; // Close the select for names
$html_id .= '</select>';  // Close the select for IDs

// Return JSON with both dropdowns
echo json_encode([
    "nameDropdown" => $html_name,
    "idDropdown" => $html_id
]);
?>
