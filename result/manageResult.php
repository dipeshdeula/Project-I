<?php
require("../connection.php");
error_reporting(0);

// Fetch result data
$query_results = "SELECT * FROM tbl_result";
$result_results = mysqli_query($conn, $query_results);

// Handle form submission to update result status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['status'])) {
        foreach ($_POST['status'] as $stdId => $examData) {
            foreach ($examData as $examId => $subCodes) {
                foreach ($subCodes as $subCode => $value) {
                    $update_query = "UPDATE tbl_result SET status = 'Published' WHERE stdId = '$stdId' AND examId = '$examId' AND subCode = '$subCode'";
                    mysqli_query($conn, $update_query);
                }
            }
        }
        
        // After updating, redirect to publishResult.php with the stdId
        // Assuming you want to redirect to publishResult.php for a single student
        $firstStudentId = array_key_first($_POST['status']);
        header("Location: publishResult.php?stdId=$firstStudentId");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #0072ff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .nav {
            padding: 10px 20px;
            background: #333;
        }

        .nav a {
            display: flex;
            margin-left: 30px;
            color: white;
            text-decoration: none;
        }

        .nav a i {
            margin-right: 5px;
            margin-top: 5px;
            font-size: 15px;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .breadcrumb {
            padding: 10px;
            margin-bottom: 20px;
            background: none;
        }

        .main {
            display: flex;
            flex-direction: row;
        }

        .main .container {
            height: 50%;
            width: 60%
        }

        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #0072ff;
            color: white;
        }

        .btn-update {
            padding: 10px;
            background: #0072ff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            background: #005bb5;
        }

        .btn-delete {
            padding: 10px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            table th,
            table td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h3>Manage Results</h3>
    </header>
    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Results</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i> Manage Results</a></li>
                <li class="breadcrub-item"><a href="../adminSection/adminLogin.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ol>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard">
            <?php require('../includes/leftbar.php'); ?>
        </div>
        <div class="container">
            <h4>View Result Details</h4>
            <form method="POST" action="manageResult.php">
                <table id="myTable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Exam ID</th>
                            <th>Subject Code</th>
                            <th>Date</th>
                            <th>Theory Marks</th>
                            <th>Practical Marks</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_results)) {
                            $remarks = ($row['theoryMarks'] < 25 || $row['practicalMarks'] < 12) ? 'Fail' : 'Pass';
                            $statusChecked = ($row['status'] === 'Published') ? 'checked' : '';
                            echo "<tr>";
                            echo "<td>{$row['stdId']}</td>";
                            echo "<td>{$row['examId']}</td>";
                            echo "<td>{$row['subCode']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['theoryMarks']}</td>";
                            echo "<td>{$row['practicalMarks']}</td>";
                            echo "<td><input type='checkbox' name='status[{$row['stdId']}][{$row['examId']}][{$row['subCode']}]' value='Published' $statusChecked></td>";
                            echo "<td>{$remarks}</td>";
                            echo "<td>
                                    <a href='updateResult.php?stdId={$row['stdId']}&examId={$row['examId']}&subCode={$row['subCode']}' class='btn-update'>Update</a> 
                                    <a href='deleteResult.php?stdId={$row['stdId']}&examId={$row['examId']}&subCode={$row['subCode']}' class='btn-delete'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" class="btn-update">Publish Selected Results</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>
