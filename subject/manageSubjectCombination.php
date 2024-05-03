<?php
require_once ("../connection.php");

// Fetch all classes from the database
$query_classes = "SELECT DISTINCT classname FROM tbl_sub_combination";
$classes = mysqli_query($conn, $query_classes);

// Handle class selection
$selected_class = isset($_POST['classname']) ? trim($_POST['classname']) : '';

// Fetch subject combinations for the selected class
$subject_combinations = [];
if ($selected_class) {
    $query_subjects = "SELECT tbl_subjects.subCode, tbl_sub_combination.subName 
                       FROM tbl_sub_combination 
                       INNER JOIN tbl_subjects 
                       ON tbl_sub_combination.subName = tbl_subjects.subName 
                       WHERE tbl_sub_combination.classname = ?";
    $stmt = mysqli_prepare($conn, $query_subjects);
    mysqli_stmt_bind_param($stmt, "s", $selected_class);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $subject_combinations[] = $row;
    }
    $count = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subject Combination</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <style>
        body {
            font-family: 'Poppins';
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #0072ff;
            color: white;
            text-align: center;
            padding: 10px;
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
            /* Underline on hover */
        }

        .breadcrumb {
            margin-right: 0px;
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
            width: 50%
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
            text-align: left;
            margin-right: 20px;
        }

        table th {
            background-color: #0072ff;
            color: white;
        }



        /* Update and delete button styling */
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

        .table-responsive {
            overflow-x: auto;
        }

        .form {
            margin-bottom: 20px;
        }

        .custom_select {
            margin-bottom: 20px;
        }

        .custom_select label {
            font-weight: bold;
            color: #555;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        select:focus {
            border-color: #0072ff;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .form {
                flex-direction: column;
            }

            .custom_select {
                margin-bottom: 10px;
            }

            select {
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            header {
                font-size: 18px;
            }

            .container {
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <header>
        <h3>Manage Subject Combination</h3>
    </header>
    <div class="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../adminSection/dashboard.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Subjects</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-wrench"></i>Manage Subjects</a></li>

            </ol>
        </nav>
    </div>
    <div class="main">
        <div class="dashboard">
            <!-- Dashboard Sidebar -->
            <?php include ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <h4>Manage Subject Combination</h3>

            <form action="#" method="POST">
                <div class="form">
                    <!-- Class Selection -->
                    <div class="custom_select">
                        <label>Select Class</label>
                        <select name="classname" onchange="this.form.submit()">
                            <option value="">Select Class</option>
                            <?php while ($class = mysqli_fetch_assoc($classes)): ?>
                                <option value="<?php echo htmlspecialchars($class['classname']); ?>" <?php echo $selected_class === $class['classname'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($class['classname']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Subject Combinations -->
            <?php if ($selected_class): ?>
                <h5>Subject Combinations for <span> <?php echo htmlspecialchars($selected_class); ?>:</span></h4>
                <table class="table-responsive" id="myTable">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subject_combinations as $subject): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlspecialchars($subject['subCode']); ?></td>
                                <td><?php echo htmlspecialchars($subject['subName']); ?></td>
                                <td>
                                    <a href="updateSubjectCombination.php?subCode=<?php echo htmlspecialchars($subject['subCode']); ?>"
                                        class="btn-update">Update</a>
                                    <a href="deleteSubjectCombination.php?subCode=<?php echo htmlspecialchars($subject['subCode']); ?>"
                                        class="btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this combination?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
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