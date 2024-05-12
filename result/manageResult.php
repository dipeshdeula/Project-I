<?php
require_once('../connection.php');

// Fetch all results
$query = "SELECT * FROM tbl_results";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching results: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['score']); ?></td>
                    <td>
                        <a href="editResult.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                        <a href="deleteResult.php?id=<?php echo htmlspecialchars($row['id']); ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>