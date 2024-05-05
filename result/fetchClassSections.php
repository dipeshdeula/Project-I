<?php
require_once('../connection.php'); // Database connection

$className = isset($_GET['className']) ? trim($_GET['className']) : '';

if (empty($className)) {
    echo "Error: Class name is required.";
    exit;
}

$query = "SELECT DISTINCT classSection FROM tbl_classes WHERE className = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    echo "Error preparing SQL statement: " . mysqli_error($conn); // Handle SQL error
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $className);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$html = '<select name="classSection" required>';
$html .= '<option value="">Select Section</option>'; // Default option

while ($section = mysqli_fetch_assoc($result)) {
    $classSection = htmlspecialchars($section['classSection']);
    $html .= "<option value=\"$classSection\">$classSection</option>"; // Populate sections
}

$html .= '</select>';

echo $html; // Return the section dropdown
