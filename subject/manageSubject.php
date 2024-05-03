

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <style>
        /* Global Styling */
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
            /* Underline on hover */
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
            text-align: center;
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



        /* Responsive Design */
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
        <h3>Manage Subjects</h3>
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
            <?php require ('../includes/leftbar.php'); ?>
        </div>

        <div class="container">
            <h4>View Sujbects Details</h4>
            <!-- Table with subjects -->
            <table id="myTable">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require("../connection.php");
                    $query = "SELECT * FROM tbl_subjects";
                    $data = mysqli_query($conn, $query);
                    $total = mysqli_num_rows($data);

                    $count = 1;
                    if (mysqli_num_rows($data) > 0):
                        while ($subject = mysqli_fetch_assoc($data)):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlspecialchars($subject['subCode']); ?></td>
                                <td><?php echo htmlspecialchars($subject['subName']); ?></td>
                                <td>
                                    <a href="updateSubject.php?id=<?php echo htmlspecialchars($subject['subCode']); ?>"
                                        class="btn-update">Update</a>
                                    <a href="deleteSubject.php?id=<?php echo htmlspecialchars($subject['subCode']); ?>"
                                        class="btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No subjects found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>
</body>

</html>