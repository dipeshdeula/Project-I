<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

    <header>

        <h3>Register Subjects</h3>

    </header>

    <div class="nav">

        <nav aria-label="breadcrumb" text-decoration="none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Subject Name</a></li>
                <li class="breadcrumb-item"><a href="#">Subject Code</a></li>

            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="form">
            <form action="#">
                <table>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Operations</th>
                    </tr>

                    <?php

                    include ("../connection.php");
                    $query = "SELECT * FROM tbl_subjects";
                    $data = mysqli_query($conn, $query);
                    $total = mysqli_num_rows($data);


                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                   <td>" . $result['subCode'] . "</td>
                   <td>" . $result['subName'] . "</td>
                   <td>
                   <a id='update' href='http://localhost/student_project/subject/upateSubject.php?id=$result[subCode]?id=$result[subCode]'>
                    <input type='submit' value='update' class='update'>
                   </a>
                   <a id='delete' href='http://localhost/student_project/subject/deleteSubject.php?id=$result[subCode]'>
                     <input type='submit' value='delete' class='delete' onclick='return checkdelete();'>

                                        
                                        </a>
                                        </td>
                   

                    </tr>";
                    }
                    ?>
                </table>
            </form>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        function checkdelete() {
            return confirm("Are you sure want to delete?");
        }
    </script>

</body>

</html>