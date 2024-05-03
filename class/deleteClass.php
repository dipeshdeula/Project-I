<?php
include("../connection.php");

$className = $_GET['className'];
$classSection = $_GET['classSection'];

$query = "DELETE from tbl_classes where className = '$className' AND classSection = '$classSection'";

$data = mysqli_query($conn,$query);

if($data)
{
    header("Location:http://localhost/student_project/class/manageClass.php");
    exit();
}
else{
    echo "<script>alert('Delete unsucessful');</scipt>";
}
?>