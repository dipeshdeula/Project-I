<?php
require('../connection.php');

// Fetch all classes with sections
$query = "SELECT DISTINCT className, classSection FROM tbl_classes";
$classes_result = mysqli_query($conn, $query);

if (!$classes_result) {
    die("Error fetching classes: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <script>
    function fetchSections(className) {
        if (className === '') {
            document.getElementById('classSection').innerHTML = ''; // Clear if no class selected
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `fetchClassSections.php?className=${className}`, true); // AJAX request to fetch class sections
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('classSection').innerHTML = xhr.responseText; // Populate class section
            }
        };
        xhr.send(); // Send the request
    }

    function fetchStudents() {
        const className = document.getElementById('className').value;
        const classSection = document.getElementById('classSection').value;

        if (className === '' || classSection === '') {
            document.getElementById('studentNameDropdown').innerHTML = ''; // Clear if no class or section selected
            document.getElementById('studentIdDropdown').innerHTML = ''; // Clear student ID
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `fetchStudents.php?className=${className}&classSection=${classSection}`, true); // AJAX request
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText); // Parse JSON response
                document.getElementById('studentNameDropdown').innerHTML = response.names; // Update student name select
                document.getElementById('studentIdDropdown').innerHTML = response.ids; // Update student ID select
            }
        };
        xhr.send(); // Send the request
    }
    </script>
</head>
<body>
    <header>
        <h3>Add Student Result</h3>
    </header>

    <div class="container">
        <form method="POST" action="addResult.php"> <!-- Correct form setup -->
            <div class="form-group">
                <label for="className">Select Class</label>
                <select name="className" id="className" onchange="fetchSections(this.value);"> <!-- Trigger fetchSections -->
                    <option value="">Select Class</option> <!-- Default option -->
                    <?php
                    while ($class = mysqli_fetch_assoc($classes_result)) {
                        $className = htmlspecialchars($class['className']);
                        echo "<option value=\"$className\">$className</option>"; // Display class names
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="classSection">Select Class Section</label>
                <select name="classSection" id="classSection" onchange="fetchStudents();"> <!-- Trigger fetchStudents -->
                    <!-- This will be populated by AJAX -->
                </select>
            </div>

            <div class="form-group" id="studentNameDropdown"> <!-- Placeholder for student name -->
                <!-- This will be populated by AJAX -->
            </div>

            <div class="form-group" id="studentIdDropdown"> <!-- Placeholder for student ID -->
                <!-- This will be populated by AJAX -->
            </div>

            <input type="submit" value="Add Student Result" name="AddResult" /> <!-- Submit button -->
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
</body>
</html>
