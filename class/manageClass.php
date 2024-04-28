<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

<?php

include("../connection.php");

$query = "SELECT * FROM tbl_classes";

$total = mysqli_num_rows($data);

if($total>0){
    ?>
    <table border = "2px">
        <tr>
            <th>ID</th>
            <th>Class Name </th>
            <th>Section </th>
            <th>Operation</th>
        </tr>

        <?php
        while($result = mysqli_fetch_array($data))
        {
            echo "<tr>
            <td>".$result['className']."</td>
            <td>".$result['section']."</td>

            <td><a id='update' href='classUpdate.php?id=$result[id]'>
        <input type='submit' value='update' class='update'></a>

        <a id='update' href='classdelete.php?id=$result[id]'>
        <input type='submit' value='delete' class='delete'
         onclick = 'return checkdelete();' ></a>
      
       ";

        }
    }
    else{
        echo "No records found";

    }
    ?>
</table>

<script>
  function checkdelete() {
    return confirm('Are you sure you want to delete this record?')
  }
</script>

