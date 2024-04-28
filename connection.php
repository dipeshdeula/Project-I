<?php
//error_reporting(0); //this function helps to hide error 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentproject"; //database name which is same at th php myadmin

$conn = mysqli_connect($servername,$username,$password,$dbname);



if($conn)
{
   // echo "Connection ok";
}
else{
    echo "Connection failed".mysqli_connect_error();
}
?>