<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>subject creation</title>
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
    color: white; /* White text */
    padding: 15px 20px; /* Adequate padding */
    text-align: center; /* Center align text */
    font-size: 24px; /* Larger font */
    margin-bottom: 20px; /* Space below header */
}

/* Navigation Styling */
.nav {
    padding: 10px 20px; /* Padding for navigation */
    background: #333; /* Dark gray background */
}

.nav a {
    color: white; /* White text */
    text-decoration: none; /* No underline */
    transition: all 0.3s ease; /* Smooth transitions */
}

.nav a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Breadcrumb Styling */
.breadcrumb {
    padding: 10px; /* Padding for breadcrumb */
    background: none; /* No background */
    margin-bottom: 20px; /* Space below breadcrumb */
}

.breadcrumb-item {
    margin-right: 10px; /* Space between items */
}

/* Container Layout */
.container {
    max-width: 600px; /* Moderate width */
    margin: 0 auto; /* Center the container */
    padding: 20px; /* Padding around the container */
    background: white; /* White background */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
}

/* Form Styling */
.form {
    display: flex; /* Use flexbox */
    flex-direction: column; /* Vertical alignment */
    align-items: stretch; /* Align to container width */
}

/* Custom Select Field Styling */
.custom_select {
    margin-bottom: 15px; /* Space between elements */
}

.custom_select label {
    font-weight: bold; /* Bold labels */
    color: #555; /* Dark gray color */
}

select {
    width: 100%; /* Full width */
    padding: 10px; /* Padding for select fields */
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Adequate font size */
    transition: all 0.3s ease; /* Smooth transitions */
}

select:focus {
    border-color: #0072ff; /* Blue border on focus */
    outline: none; /* No default outline */
}

/* Submit Button Styling */
input[type="submit"] {
    background: #0072ff; /* Blue background */
    color: white; /* White text */
    padding: 10px 20px; /* Padding for the button */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Consistent font size */
    cursor: pointer; /* Pointer cursor on hover */
    transition: all 0.3s ease; /* Smooth transitions */
    width: 100%; /* Full width */
}

input[type="submit"]:hover {
    background: #005bb5; /* Darker blue on hover */
}

input[type="submit"]:active {
    transform: scale(0.95); /* Slight shrink on click (active state) */
}

/* Responsive Design with Media Queries */
@media (max-width: 768px) {
    .container {
        padding: 15px; /* Adjusted padding for smaller screens */
    }

    .form {
        align-items: stretch; /* Ensure items align to the container */
    }

    .custom_select {
        margin-bottom: 10px; /* Adjust spacing for smaller screens */
    }

    select {
        padding: 8px 12px; /* Adjusted padding for smaller screens */
        font-size: 14px; /* Smaller font size */
    }

    input[type="submit"] {
        padding: 8px 16px; /* Adjusted padding */
        font-size: 14px; /* Smaller font size */
    }
}

@media (max-width: 480px) {
    header {
        font-size: 20px; /* Smaller font size for smaller screens */
    }

    .container {
        padding: 10px; /* Reduced padding */
    }

    .breadcrumb {
        font-size: 14px; /* Smaller font size */
    }
}

</style>
</head>

<body>


    <header>

        <h3>Add Subject Combination</h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Subjects</a></li>
                <li class="breadcrumb-item"><a href="#">Add Subject Combination</a></li>

            </ol>
        </nav>
    </div>

    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="title">Add Subject Combination</div>


            <div class="form">

                <div class="custom_select">
                    <label>class</label>
                    <select name="selectClass" id="selectClass">Select Class</select>
                </div>

                <div class="custom_select">
                    <label>Subject</label>
                    <select name="selectSubject" id="selectSubject">Select Subject</select>
                </div>


                <div class="input_field">
                    <input type="submit" value="Add" class="btn" name="Add" />


                </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>