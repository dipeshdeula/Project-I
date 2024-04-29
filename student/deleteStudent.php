<?php
include("../connection.php"); 

// Check if the 'id' parameter is passed
$stdId = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($stdId) {
    $query = "DELETE FROM tbl_student WHERE stdId = $stdId"; 
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
            alert('Data deleted successfully');
          
        </script>";
    } else {
        echo "<script>
            alert('Deletion failed: " . mysqli_error($conn) . "');
           
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid or missing ID');
        
    </script>";
}
?>
