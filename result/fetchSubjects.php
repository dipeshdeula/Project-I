<?php
require_once('../connection.php'); // Database connection

$className = isset($_GET['className']) ? trim($_GET['className']) : '';

if (empty($className)) {
    echo "Error: Class name is required.";
    exit;
}

// Fetch subjects for the selected class
$query_subjects = "SELECT tbl_subjects.subCode, tbl_subjects.subName 
                   FROM tbl_sub_combination 
                   INNER JOIN tbl_subjects 
                   ON tbl_sub_combination.subName = tbl_subjects.subName 
                   WHERE tbl_sub_combination.className = ?";
$stmt = mysqli_prepare($conn, $query_subjects);

if ($stmt === false) {
    echo "Error preparing SQL statement: " . mysqli_error($conn); // Handle SQL error
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $className);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$html = '<table class="table" id="subjectTable">';
$html .= '<thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Theory Marks</th>
                <th>Practical Marks</th>
            </tr>
         </thead>';
$html .= '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $subCode = htmlspecialchars($row['subCode']);
    $subName = htmlspecialchars($row['subName']);
    
    $html .= "<tr>";
    $html .= "<td>$subCode</td>"; // Subject Code
    $html .= "<td>$subName</td>"; // Subject Name
    $html .= "<td><input type='number' class='theoryMarks' name='theoryMarks[]' min='0' max='100' placeholder='Theory Marks'></td>"; // Theory marks input
    $html .= "<td><input type='number' class='practicalMarks' name='practicalMarks[]' min='0' max='25' placeholder='Practical Marks'></td>"; // Practical marks input
    $html .= "</tr>";
}

$html .= "</tbody>";
$html .= '</table>';

echo $html;
