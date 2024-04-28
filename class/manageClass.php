<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-container {
            padding: 20px;
            margin: 20px;
        }

        .table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .update, .delete {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete {
            background-color: #dc3545;
        }

        .update:hover, .delete:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="table-container">
        <?php
        include("../connection.php");

        $query = "SELECT * FROM tbl_classes";
        $data = mysqli_query($conn, $query);
        $total = mysqli_num_rows($data);

        if ($total > 0) {
        ?>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Class Name</th>
                <th>Section</th>
                <th>Operation</th>
            </tr>
            <?php
            while ($result = mysqli_fetch_array($data)) {
                echo "<tr>
                      <td>{$result['id']}</td>
                      <td>{$result['className']}</td>
                      <td>{$result['classSection']}</td>
                      <td>
                          <a class='update' href='http://localhost/student_project/class/updateClass.php?id={$result['id']}'>Update</a>
                          <a class='delete' href='http://localhost/student_project/class/deleteClass.php?id={$result['id']}' onclick='return checkdelete();'>Delete</a>
                      </td>
                      </tr>";
            }
            ?>
        </table>
        <?php
        } else {
            echo "No records found.";
        }
        ?>
    </div>
</div>

<script>
    function checkdelete() {
        return confirm('Are you sure you want to delete this record?');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
</body>
</html>
