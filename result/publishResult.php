<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="") {   
    header("Location: index.php"); 
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Publish Results</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="css/main.css" media="screen">
    <style>
        /* Your custom CSS styles here */
    </style>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');?> 
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php');?>  
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Publish Results</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Results</a></li>
                                    <li class="active">Publish Results</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Publish Student Results</h5>
                                            </div>
                                        </div>
                                        <!-- Display success or error message here -->
                                        <?php if($msg) {?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } elseif($error) {?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-body p-20">
                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th>Student ID</th>
                                                        <th>Class</th>
                                                        <th>Theory Marks</th>
                                                        <th>Practical Marks</th>
                                                        <th>Total Marks</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = "SELECT tbl_student.*, tbl_result.* FROM tbl_student JOIN tbl_result ON tbl_student.stdId = tbl_result.stdId";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if($query->rowCount() > 0) {
                                                        foreach($results as $result) { ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt);?></td>
                                                                <td><?php echo htmlentities($result->stdname);?></td>
                                                                <td><?php echo htmlentities($result->stdId);?></td>
                                                                <td><?php echo htmlentities($result->classname);?></td>
                                                                <td><?php echo htmlentities($result->theoryMarks);?></td>
                                                                <td><?php echo htmlentities($result->practicalMarks);?></td>
                                                                <td><?php echo htmlentities($result->totalMarks);?></td>
                                                                <td><?php echo ($result->totalMarks >= 35) ? 'Pass' : 'Fail'; ?></td>
                                                                <td>
                                                                    <!-- Add appropriate action buttons for edit, delete, and publish -->
                                                                    <a href="edit-result.php?id=<?php echo htmlentities($result->id);?>"><i class="fa fa-edit" title="Edit Result"></i></a> 
                                                                    <a href="delete-result.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete this result?');"><i class="fa fa-trash-o" title="Delete Result"></i></a> 
                                                                    <a href="#" onclick="publishResult(<?php echo htmlentities($result->id);?>);"><i class="fa fa-check" title="Publish Result"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php $cnt++;
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
        $(function($) {
            $('#example').DataTable();
        });

        function publishResult(resultId) {
            // Add AJAX request here to publish the result with ID resultId
            // Example: $.post('publish-result.php', { id: resultId }, function(response) { alert(response); });
        }
    </script>
</body>
</html>

<?php } ?>
