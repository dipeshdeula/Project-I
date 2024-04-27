<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student Class</title>
    <style>

        /* Global styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: transparent; /* To blend with the dashboard background */
    margin: 0;
    padding: 0;
    height: 100%;
}

/* Container styling */
.container {
    background: white; /* White background */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
    padding: 30px; /* Adjusted padding for dashboard context */
    max-width: 500px; /* Moderate width */
    text-align: center;
    margin: auto; /* Center in parent container */
}

/* Form header styling */
.container h3 {
    font-size: 22px; /* Slightly larger for emphasis */
    color: #333; /* Dark text color */
    margin-bottom: 15px; /* Space below heading */
}

/* Horizontal rule styling */
.container hr {
    border-top: 1px solid #ccc; /* Light gray border */
    width: 80%; /* Shorter width for aesthetics */
    margin: 10px auto; /* Centered with spacing */
}

/* Form layout and styling */
.form {
    display: flex; /* Flexbox layout */
    flex-direction: column; /* Vertical direction */
    align-items: center; /* Center align elements */
}

/* Label styling */
label {
    font-size: 16px; /* Consistent font size */
    color: #555; /* Gray text color */
    display: block;
    margin-bottom: 8px; /* Space below labels */
    text-align: start; /* Align left for consistency */
}

/* Input fields styling */
input[type="text"] {
    width: 100%; /* Full width */
    padding: 12px; /* Adequate padding */
    border: 1px solid #ccc; /* Border color */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Consistent font size */
    margin-bottom: 15px; /* Spacing between input fields */
}

/* Paragraph styling */
p {
    color: #777; /* Light gray text */
    font-size: 14px; /* Slightly smaller font size */
    margin-bottom: 15px; /* Spacing between elements */
    text-align: start; /* Align left */
}

/* Submit button styling */
input[type="submit"] {
    background: #4CAF50; /* Green color */
    color: white; /* White text */
    padding: 12px; /* Adequate padding */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Consistent font size */
    cursor: pointer; /* Pointer cursor on hover */
    transition: all 0.3s ease; /* Smooth transition */
    width: 100%; /* Full width */
}

input[type="submit"]:hover {
    background: #388E3C; /* Darker green on hover */
}

input[type="submit"]:active {
    transform: scale(0.95); /* Slight shrink on click */
}

/* Responsive Design with Media Queries */
@media (max-width: 768px) {
    .container {
        padding: 20px; /* Reduced padding for smaller screens */
        max-width: 100%; /* Full width on smaller screens */
    }

    .form {
        align-items: stretch; /* Fill width */
    }

    input {
        padding: 10px; /* Adjusted padding */
        font-size: 14px; /* Adjusted font size */
    }

    input[type="submit"] {
        padding: 10px; /* Adjusted padding */
        font-size: 14px; /* Adjusted font size */
    }
}


    </style>
</head>

<body>
    <?php 
    // include('topbar.php');
    ?>
    <div class="container">
        <h3>Create Student Class</h3>
        <hr>
        <div class="form">
            <form action="#" method="POST">
                <label for="className">Class Name</label>
                <input type="text" name="className" />

                <p>Eg-BCAI,BIM IV, BBS III etc </p>
                <label for="classSection">Section</label>
                <input type="text" name="classSection" />

                <p>Eg- A, B, C etc </p>
                <input type="submit" name="sumbit" />
            </form>
        </div>
    </div>
</body>

</html>