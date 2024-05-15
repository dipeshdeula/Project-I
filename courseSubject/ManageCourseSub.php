<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Course Subject</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 6px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Manage Course Subject</h1>
    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Subject Code</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require ("../connection.php");

            $query = "SELECT courseId, subCode, semester FROM tbl_course_subject";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['courseId'] . "</td>";
                    echo "<td>" . $row['subCode'] . "</td>";
                    echo "<td>" . $row['semester'] . "</td>";
                    echo "<td>";
                    echo "<a class='update' href='updateCourseSub.php?courseId={$row['courseId']}&subCode={$row['subCode']}'>Update</a>";
                    echo "<a class='delete' href='deleteCourseSub.php?courseId={$row['courseId']}&subCode={$row['subCode']}' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";

                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>