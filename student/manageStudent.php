<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
       /* Global Styling */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5; /* Light gray background */
}

/* Header Styling */
header {
    background-color: #0072ff; /* Dark blue */
    color: white;
    padding: 10px 20px;
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px; /* Space below header */
    overflow: hidden;
}

/* Navigation Styling */
.nav {
    padding: 10px 20px; /* Padding around navigation */
    background: #333; /* Dark gray background */
    overflow: hidden;
}

.nav a {
    color: white; /* White text color */
    text-decoration: none; /* No underline */
    transition: all 0.3s ease;
}

.nav a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Breadcrumb Styling */
.breadcrumb {
    padding: 10px; /* Padding inside breadcrumb */
    background: none; /* No background */
}

.breadcrumb-item {
    margin-right: 10px; /* Space between breadcrumb items */
}

/* Container Layout */
.container {
    max-width: 1200px; /* Maximum width */
    margin: 20px auto; /* Center container */
    padding: 20px; /* Padding around container */
    background: white; /* White background */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
}

/* Form Styling */
.form {
    margin-bottom: 20px; /* Space below form */
}

.form input[type="search"] {
    display: flex;
    padding: 8px 12px; /* Padding for search input */
    border: 1px solid #ccc; /* Border color */
    border-radius: 5px; /* Rounded corners */
    width: 35%; /* Full width */
    box-sizing: border-box; /* Include padding in width */
    margin: 12px 0;


}

/* Table Design */
table {
    width: 100%; /* Full width */
    border-collapse: collapse; /* Collapse borders */
    text-align: left; /* Align text to the left */
}

table th, table td {
    padding: 10px; /* Padding around table cells */
    border: 1px solid #ddd; /* Border color */
}

table th {
    background-color: #f0f0f0; /* Light gray background for header */
}

/* Responsive Design with Media Queries */
@media (max-width: 768px) {
    .container {
        padding: 10px; /* Reduced padding for smaller screens */
    }

    .breadcrumb {
        font-size: 14px; /* Smaller font size */
    }

    .form input[type="search"] {
        width: 100%; /* Full width for smaller screens */
    }

    table {
        overflow-x: auto; /* Horizontal scrolling for small screens */
        display: block; /* Ensure table is block-level for scrolling */
    }
}

    </style>
</head>

<body>
    <header>
        
    <h3>Manage Students </h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Students</a></li>
                <li class="breadcrumb-item"><a href="#">Manage Students</a></li>

            </ol>
        </nav>
    </div>



    <div class="container">
        <div class="form">
            <form action="#" method=="POST">
            <p>View Student Info </p>
        Show <select name="" id=""></select> entries
        <br><br>
     <input type="search" placeholder="search" name="search" >
     

     <table>
        <tr>
            <th>StdId</th>
            <th>Photo</th>
            <th>Student Name</th>
            <th>Roll NO.</th>
            <th>Class</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Gender</th>
            <th>D.O.B</th>




        </tr>
     </table>

     <?php
     
     ?>

            </form>
        </div>
       

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>