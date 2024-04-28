<?php
include("../connection.php");

$cid = $_GET['id'];

$query = "DELETE from tbl_classes where id = '$cid'";

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