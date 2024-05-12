<?php
require_once ('../connection.php'); // Database connection

// Fetch all unique classes
$query = "SELECT DISTINCT className FROM tbl_classes";
$classes_result = mysqli_query($conn, $query);

// Check for errors in fetching classes
if (!$classes_result) {
    die("Error fetching classes: " . mysqli_error($conn));
}

// Function to add a new result
// Function to add a new result
function AddResult($conn, $studentId, $className, $subject_combinations, $theoryMarks, $practicalMarks)
{
    // Check if all required data is present
    if (!isset($studentId) || !isset($className) || !isset($subject_combinations) || !isset($theoryMarks) || !isset($practicalMarks)) {
        die("Error: Missing required data for adding result.");
    }

    // Calculate total marks, percentage, and remarks for each subject
    $totalMarks = 0;
    $maxTheoryMarks = 75; // Maximum possible marks for theory
    $maxPracticalMarks = 25; // Maximum possible marks for practical

    // Check if subject_combinations is an array
    if (!is_array($subject_combinations)) {
        die("Error: Subject combinations should be an array.");
    }

    $subject_count = count($subject_combinations);

    foreach ($subject_combinations as $index => $subject) {
        // Check if theoryMarks and practicalMarks have values at this index
        if (!isset($theoryMarks[$index]) || !isset($practicalMarks[$index])) {
            die("Error: Missing marks for subject at index $index.");
        }

        $theory = (float) $theoryMarks[$index];
        $practical = (float) $practicalMarks[$index];
        $subject_combinations[$index]['totalMarks'] = $theory + $practical;
        $totalMarks += $theory + $practical;
    }

    $totalPossibleMarks = $subject_count * ($maxTheoryMarks + $maxPracticalMarks);
    $percentage = ($totalMarks / $totalPossibleMarks) * 100;
    $remarks = ($percentage >= 25 && $totalMarks >= 100) ? 'Pass' : 'Fail';

    // Insert the results into the database
    $insert_query = "INSERT INTO tbl_result(stdId, className, subCode, subName, theoryMarks, practicalMarks, totalMarks, percentage, remarks) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);

    // Bind parameters and execute the statement for each subject
    foreach ($subject_combinations as $index => $subject) {
        $subjectCode = $subject['subCode'];
        $subjectName = $subject['subName'];
        $theory = (float) $theoryMarks[$index];
        $practical = (float) $practicalMarks[$index];
        $combinedMarks = $theory + $practical;

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssss",
            $studentId,
            $className,
            $subjectCode,
            $subjectName,
            $theory,
            $practical,
            $combinedMarks,
            $percentage,
            $remarks
        );

        if (!mysqli_stmt_execute($stmt)) {
            die("Error inserting result: " . mysqli_stmt_error($stmt));
        }
    }

    echo "<script>alert('Result added successfully');</script>";
}


// Function to edit an existing result
function EditResult($conn, $studentId, $theoryMarks, $practicalMarks)
{
    // Implement your logic to update the result in the database
    $update_query = "UPDATE tbl_result 
                     SET theoryMarks = ?, practicalMarks = ?
                     WHERE stdId = ?";
    $stmt = mysqli_prepare($conn, $update_query);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "sss", $theoryMarks, $practicalMarks, $studentId);
    if (!mysqli_stmt_execute($stmt)) {
        die("Error updating result: " . mysqli_stmt_error($stmt));
    }
    echo "<script>alert('Result updated successfully'); window.location.href = 'manageResults.php';</script>";
}

// Function to display results
function DisplayResult($conn)
{
    // Your code for displaying results goes here
}

// Function to delete a result
function DeleteResult($conn, $studentId)
{
    // Implement your logic to delete the result from the database
    $delete_query = "DELETE FROM tbl_result WHERE stdId = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    if (!mysqli_stmt_bind_param($stmt, "i", $studentId)) {
        die("Error binding parameters: " . mysqli_stmt_error($stmt));
    }
    if (!mysqli_stmt_execute($stmt)) {
        die("Error deleting result: " . mysqli_stmt_error($stmt));
    }
    echo "<script>alert('Result deleted successfully'); window.location.href = 'result/manageResults.php';</script>";
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    switch ($operation) {
        case 'AddResult':
            // Add result logic
            AddResult($conn, $_POST['stdId'], $_POST['className'], $_POST['subject_combinations'], $_POST['theoryMarks'], $_POST['practicalMarks']);
            break;
        case 'EditResult':
            // Edit result logic
            EditResult($conn, $_POST['stdId'], $_POST['theoryMarks'], $_POST['practicalMarks']);
            break;
        case 'DisplayResult':
            // Display result logic
            DisplayResult($conn);
            break;
        case 'DeleteResult':
            // Delete result logic
            DeleteResult($conn, $_POST['stdId']);
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
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="resultForm"> <!-- Correct form setup -->
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
<!-- 


           

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




            <button type="button" onclick="calculateResults()" class="btn btn-primary">Calculate</button>
            <!-- Button to calculate results -->
            <input type="submit" value="AddResult" name="operation" class="btn btn-primary" />
            <!-- Add button -->

            <input type="submit" value="EditResult" name="operation" class="btn btn-primary" />
            <!-- Edit button -->

            <input type="submit" value="DisplayResult" name="operation" class="btn btn-primary" />
            <!-- Display button -->

            <input type="submit" value="DeleteResult" name="operation" class="btn btn-primary" />
            <!-- Delete button -->


        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS -->

    <script>

        function calculateResults() {
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
            document.getElementById('totalRow').innerText = ` ${totalMarks}`;
            document.getElementById('percentageRow').innerText = `Percentage: ${percentage.toFixed(2)}%`;
            document.getElementById('remarksRow').innerText = `Remarks: ${remarks}`;
        }



    </script>
</body>

</html>