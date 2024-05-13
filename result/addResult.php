<?php
require_once ('../connection.php'); // Database connection

// Fetch all unique classes
$query = "SELECT DISTINCT className FROM tbl_classes";
$classes_result = mysqli_query($conn, $query);

// Check for errors in fetching classes
if (!$classes_result) {
    die("Error fetching classes: " . mysqli_error($conn));
}



// Function to display results
// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stdId = isset($_POST['stdId']) ? $_POST['stdId'] : '';
    $stdname = isset($_POST['stdname']) ? $_POST['stdname'] : '';
    $className = isset($_POST['className']) ? $_POST['className'] : '';
    $subCode = isset($_POST['subCode']) ? $_POST['subCode'] : '';
    $subName = isset($_POST['subName']) ? $_POST['subName'] : '';
    $theoryMarks = isset($_POST['theoryMarks']) ? $_POST['theoryMarks'] : '';
    $practicalMarks = isset($_POST['practicalMarks']) ? $_POST['practicalMarks'] : '';
    $totalMarks = isset($_POST['totalMarks']) ? $_POST['totalMarks'] : '';
    $percentage = isset($_POST['percentage']) ? $_POST['percentage'] : '';
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
    $pstdId = isset($_POST['pstdId']) ? $_POST['pstdId'] : ''; // Previous student ID


    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    switch ($operation) {
        case 'Add':
            //query to insert data into the table
            $query = "INSERT INTO tbl_result (stdId, stdname, className, subCode, subName, theoryMarks, practicalMarks, totalMarks, percentage, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssssssss", $stdId, $stdname, $className, $subCode, $subName, $theoryMarks, $practicalMarks, $totalMarks, $percentage, $remarks);
            mysqli_stmt_execute($stmt);
            echo "<script>alert('Data inserted successfully!')</script>";

            break;
        case 'Edit':
            //query to update data in the table
            $query = "UPDATE tbl_result SET stdId = ?, stdname = ?, className = ?, subCode = ?, subName = ?, theoryMarks = ?, practicalMarks = ?, totalMarks = ?, percentage = ?, remarks = ? WHERE stdId = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssssssssss", $stdId, $stdname, $className, $subCode, $subName, $theoryMarks, $practicalMarks, $totalMarks, $percentage, $remarks, $pstdId);
            mysqli_stmt_execute($stmt);
            echo "<script>alert('Data updated successfully!')</script>";
            break;
        case 'Find':
            //query to find data in the table
            $query = "SELECT * FROM tbl_result WHERE stdId = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $pstdId); // Bind parameter to the statement
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if ($row != null) {
                $pstdId = $stdId = $row['stdId'];
                $stdname = $row['stdname'];
                $className = $row['className'];
                $subCode = $row['subCode'];
                $subName = $row['subName'];
                $theoryMarks = $row['theoryMarks'];
                $practicalMarks = $row['practicalMarks'];
                $totalMarks = $row['totalMarks'];
                $percentage = $row['percentage'];
                $remarks = $row['remarks'];
            }
            echo "<script>alert('Data found successfully!')</script>";
            break;

        case 'Delete':
            //query to delete data from the table
            $query = "DELETE FROM tbl_result WHERE stdId = $stdId";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            break;
        case 'Display':
            //query to display data from the table
            $query = "SELECT * FROM tbl_result";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Student ID</th>";
            echo "<th>Student Name</th>";
            echo "<th>Class Name</th>";
            echo "<th>Subject Code</th>";
            echo "<th>Subject Name</th>";
            echo "<th>Theory Marks</th>";
            echo "<th>Practical Marks</th>";
            echo "<th>Total Marks</th>";
            echo "<th>Percentage</th>";
            echo "<th>Remarks</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['stdId'] . "</td>";
                echo "<td>" . $row['stdname'] . "</td>";
                echo "<td>" . $row['className'] . "</td>";
                echo "<td>" . $row['subCode'] . "</td>";
                echo "<td>" . $row['subName'] . "</td>";
                echo "<td>" . $row['theoryMarks'] . "</td>";
                echo "<td>" . $row['practicalMarks'] . "</td>";
                echo "<td>" . $row['totalMarks'] . "</td>";
                echo "<td>" . $row['percentage'] . "</td>";
                echo "<td>" . $row['remarks'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            break;
        default:
            // Handle invalid operation
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Student Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Consistent font across the app */
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            /* Light gray background for a clean look */
        }

        header {
            background-color: #007bff;
            /* Bootstrap's primary blue */
            color: white;
            padding: 15px;
            /* Adequate padding for a clean header */
            text-align: center;
            /* Centered text for the header */
        }

        .container {
            max-width: 960px;
            /* Constrain maximum width to a reasonable size */
            margin: 20px auto;
            /* Center the container and add spacing */
            padding: 20px;
            /* Adequate internal padding */
            background: white;
            /* White background for content */
            border-radius: 10px;
            /* Smooth, rounded corners */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            /* Light shadow for depth */
        }

        .form-group {
            margin-bottom: 20px;
            /* Space between form elements */
        }

        select,
        input[type="text"],
        input[type="number"] {
            width: 100%;
            /* Full width for responsive design */
            padding: 10px;
            /* Adequate padding for form elements */
            border: 1px solid #ced4da;
            /* Border styling */
            border-radius: 5px;
            /* Rounded corners for a clean look */
            transition: all 0.3s;
            /* Smooth transition for hover effects */
        }

        select:focus,
        input:focus {
            border-color: #007bff;
            /* Change border color on focus */
        }

        .btn-primary {
            background-color: #007bff;
            /* Primary blue */
            color: white;
            /* White text on buttons */
            border: none;
            padding: 10px 20px;
            /* Adequate padding for buttons */
            border-radius: 5px;
            /* Rounded corners for buttons */
            transition: background-color 0.3s;
            /* Smooth hover effect */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        .table {
            width: 100%;
            /* Full-width table */
            border-collapse: collapse;
            /* Collapse table borders */
        }

        .table th,
        .table td {
            padding: 10px;
            /* Padding for table cells */
            text-align: left;
            /* Align text to the left */
            border: 1px solid #ced4da;
            /* Border for table cells */
        }

        .table th {
            background-color: #007bff;
            /* Blue background for table headers */
            color: white;
            /* White text for table headers */
        }

        .table-responsive {
            overflow-x: auto;
            /* Horizontal scroll for small screens */
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                /* Reduce padding for smaller screens */
            }

            select,
            input {
                padding: 8px;
                /* Smaller padding for smaller screens */
            }

            header {
                font-size: 18px;
                /* Smaller font for header on small screens */
            }

            .btn-primary {
                padding: 8px 15px;
                /* Smaller padding for buttons on small screens */
            }
        }
    </style>


    <script>
        // Fetch students based on class name
        function fetchStudents() {
            const className = document.getElementById("className").value;

            if (className === '') {
                document.getElementById("studentNameDropdown").innerHTML = ''; // Clear if no class selected
                document.getElementById("studentIdDropdown").innerHTML = ''; // Clear if no class selected
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open("GET", `fetchStudents.php?className=${className}`, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        console.error(response.error);
                    } else {
                        document.getElementById("studentNameDropdown").innerHTML = response.nameDropdown;
                        document.getElementById("studentIdDropdown").innerHTML = response.idDropdown;
                    }
                }
            };
            xhr.send(); // Send the request
        }


        // Fetch subjects based on class name
        function fetchSubjects() {
            const className = document.getElementById("className").value;

            if (className === '') {
                document.getElementById("subjectTable").innerHTML = ''; // Clear if no class is selected
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `fetchSubjects.php?className=${className}`, true); // AJAX request to fetch subjects
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('subjectTable').innerHTML = xhr.responseText; // Populate subject table
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
        <form method="POST" id="resultForm" action="#"> <!-- Correct form setup -->
            <div class="form-group">
                <label for="className">Select Class</label>
                <select name="className" id="className" onchange="fetchStudents(); fetchSubjects();">
                    <!-- Trigger fetching of students and subjects -->
                    <option value="">Select Class</option> <!-- Default option -->
                    <?php
                    while ($class = mysqli_fetch_assoc($classes_result)) {
                        $className = htmlspecialchars($class['className']);
                        echo "<option value=\"$className\">$className</option>"; // Display class names
                    }
                    ?>
                </select>
            </div>

            <div class="form-group" id="studentNameDropdown"> <!-- Placeholder for student names -->
                <!-- This will be populated by AJAX based on the selected class -->
            </div>

            <div class="form-group" id="studentIdDropdown"> <!-- Placeholder for student names -->
                <!-- This will be populated by AJAX based on the selected class -->
            </div>

            <div class="form-group" id="subjectTable"> <!-- Placeholder for subjects table -->
                <!-- This will be populated by AJAX -->
            </div>
            <!-- Other form elements -->

            <div class="form-group">
                <label for="totalMarks">Total Marks:</label>
                <input type="text" name="totalMarks" id="totalRow" readonly>
            </div>

            <div class="form-group">
                <label for="percentage">Percentage:</label>
                <input type="text" name="percentage" id="percentageRow" readonly>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <input type="text" name="remarks" id="remarksRow" readonly>
            </div>
            <table>
                <tr>
                <td colspan="4">
                    <input type="submit" name="operation" onclick="performOperation('Add')" value="Add" id="addBtn" class="btn btn-primary">
                    <input type="submit" name="operation" onclick="performOperation('Find')" value="Find" id="findBtn" class="btn btn-primary">
                    <input type="submit" name="operation" onclick="performOperation('Edit')" value="Edit" id="editBtn" class="btn btn-primary">
                    <input type="submit" name="operation" onclick="performOperation('Delete')" value="Delete" id="deleteBtn" class="btn btn-primary">
                    <input type="submit" name="operation" onclick="performOperation('Display')" value="Display" id="displayBtn" class="btn btn-primary">
                    <input type="submit" name="operation" onclick="calculateResult()" value="Calculate"
                        class="btn btn-primary">
                </td>

            </tr>

            </table>

            
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Add event listener for form submission
            document.getElementById('resultForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent default form submission
                calculateResult(); // Calculate result

                // AJAX code to submit form data without refreshing the page
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle success response
                        console.log(xhr.responseText);
                    } else {
                        // Handle error response
                        console.error('Error:', xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    // Handle network errors
                    console.error('Network Error');
                };
                xhr.send(formData); // Send form data
            });
        });
        // Function to perform operation based on button clicked
        function performOperation($operation) {
            // AJAX code to perform operation without refreshing the page
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Handle success response
                    console.log(xhr.responseText);
                } else {
                    // Handle error response
                    console.error('Error:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                // Handle network errors
                console.error('Network Error');
            };
            xhr.send('operation=' + operation); // Send operation to the server
        }

        function calculateResult() {
            console.log("Calculate button clicked"); // Debugging statement

            const theoryMarks = document.querySelectorAll('.theoryMarks');
            const practicalMarks = document.querySelectorAll('.practicalMarks');

            if (theoryMarks.length === 0) {
                console.error("No theory marks found");
                return;
            }

            let totalMarks = 0;
            const maxTheoryMarks = 75;
            const maxPracticalMarks = 25;
            let hasFailed = false; // Flag to check if any subject failed

            // Calculate total marks with safeguard
            theoryMarks.forEach((input, index) => {
                const theory = parseFloat(input.value) || 0;
                const practical = parseFloat(practicalMarks[index]?.value || 0); // Default to 0 if no practical

                if (theory < 25 || (practical > 0 && practical < 12)) { // Check if the subject fails
                    hasFailed = true;
                }

                const combined = theory + practical;

                if (combined > 100) { // Safeguard against total marks exceeding 100
                    console.error(`Marks for subject ${index + 1} exceed 100. Theory: ${theory}, Practical: ${practical}`);
                    return; // Avoid processing if it exceeds 100
                }

                totalMarks += combined;
            });

            // Calculate percentage
            const subjectCount = theoryMarks.length;
            const totalPossibleMarks = subjectCount * 100; // Since each subject should be a max of 100
            const percentage = (totalMarks / totalPossibleMarks) * 100;

            const remarks = hasFailed || percentage < 25 ? 'Fail' : 'Pass';

            // Update the calculated fields
            document.getElementById('totalRow').value = totalMarks;
            document.getElementById('percentageRow').value = percentage.toFixed(2) + "%";
            document.getElementById('remarksRow').value = remarks;

            // Inside calculateResult() function
            const formData = new FormData(document.getElementById('resultForm'));
            formData.append('operation', 'Calculate');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Handle success response
                    console.log(xhr.responseText);
                } else {
                    // Handle error response
                    console.error('Error:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                // Handle network errors
                console.error('Network Error');
            };
            xhr.send(formData); // Send form data

        }




    </script>
</body>

</html>