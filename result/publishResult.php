<?php
require_once('../connection.php'); // Database connection

$stdId = isset($_GET['stdId']) ? trim($_GET['stdId']) : '';
$className = isset($_GET['className']) ? trim($_GET['className']) : '';

if (empty($stdId) || empty($className)) {
    die("Student ID and Class Name are required.");
}

// Fetch student details
$query_student = "SELECT stdname, stdId, img_path 
                  FROM tbl_student 
                  WHERE stdId = ?";
$stmt = mysqli_prepare($conn, $query_student);

if ($stmt === false) {
    die("Error preparing SQL statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $stdId);
mysqli_stmt_execute($stmt);
$result_student = mysqli_stmt_get_result($stmt);

$student = mysqli_fetch_assoc($result_student);

if (!$student) {
    die("No student found with the provided ID.");
}

$stdname = htmlspecialchars($student['stdname']);
$img_path = htmlspecialchars($student['img_path']); // Student image path

// Fetch results for the student and class
$query_result = "SELECT * FROM tbl_results 
                 WHERE studentId = ? AND className = ?";

$stmt = mysqli_prepare($conn, $query_result);

if ($stmt === false) {
    die("Error preparing SQL statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ss", $stdId, $className);
mysqli_stmt_execute($stmt);
$result_marks = mysqli_stmt_get_result($stmt);

$total_marks = 0;
$total_possible_marks = 0;
$subject_count = mysqli_num_rows($result_marks);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <style>
        /* CSS for responsive design */
        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #007bff;
            color: white;
            border-radius: 10px;
        }

        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .table th,
            .table td {
                padding: 8px;
            }

            img {
                width: 75px;
                height: 75px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <h2>JALJALA MULTIPLE CAMPUS</h2>
        <h4>KALPANA ROAD, MAKAWANPUR</h4>
    </header>

    <div class="container">
        <h3>Mark Sheet</h3>
        <p>Marks obtained by: <img src="<?php echo $img_path; ?>" alt="Student Image"> <?php echo $stdname; ?></p>
        <p>Student ID: <?php echo $stdId; ?> | Class: <?php echo $className; ?></p>

        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Theory Marks</th>
                    <th>Practical Marks</th>
                    <th>Total Marks</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($mark = mysqli_fetch_assoc($result_marks)) {
                    $theory_marks = (float)$mark['theoryMarks'];
                    $practical_marks = (float)$mark['practicalMarks'];
                    $total = $theory_marks + $practical_marks;
                    $remarks = ($total >= 35) ? 'Pass' : 'Fail';

                    $total_marks += $total;
                    $total_possible_marks += 100; // Each subject has a max of 100

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($mark['subjectCode']) . "</td>";
                    echo "<td>" . htmlspecialchars($mark['subjectName']) . "</td>";
                    echo "<td>$theory_marks</td>";
                    echo "<td>$practical_marks</td>";
                    echo "<td>$total</td>";
                    echo "<td>$remarks</td>";
                    echo "</tr>";
                }

                $percentage = ($total_marks / $total_possible_marks) * 100;
                ?>

                <tr>
                    <td colspan="7">
                        <strong>Total Marks:</strong> <?php echo $total_marks; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <strong>Percentage:</strong> <?php echo number_format($percentage, 2); ?>%
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <strong>Remarks:</strong> <?php echo ($percentage >= 25) ? 'Pass' : 'Fail'; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
