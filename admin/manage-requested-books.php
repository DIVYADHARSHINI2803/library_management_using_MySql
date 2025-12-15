<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
    exit;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Manage Requested & Reserved Books</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Requested & Reserved Books</h4>
            </div>
        </div>

        <!-- Requested Books Section -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Requested Books</strong>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-requested">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Book Name</th>
                                <th>Category Name</th>
                                <th>Author Name</th>
                                <th>ISBN Number</th>
                                <th>Book Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php 
$sql = "SELECT StudentID, StudName, BookName, CategoryName, AuthorName, ISBNNumber, BookPrice 
        FROM tblrequestedbookdetails";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if($query->rowCount() > 0){
    foreach($results as $result){ ?>                          
        <tr class="odd gradeX">
            <td class="center"><?php echo htmlentities($cnt);?></td>
            <td class="center"><?php echo htmlentities($result->StudentID);?></td>
            <td class="center"><?php echo htmlentities($result->StudName);?></td>
            <td class="center"><?php echo htmlentities($result->BookName);?></td>
            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
            <td class="center"><?php echo htmlentities($result->AuthorName);?></td>
            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
            <td class="center"><?php echo htmlentities($result->BookPrice);?></td>
            <td class="center">
                <a href="issue-book2.php?ISBNNumber=<?php echo $result->ISBNNumber;?>&StudentID=<?php echo $result->StudentID;?>">
                    <i class="fa fa-edit"></i> Issue
                </a>
            </td>
        </tr>
<?php $cnt++; }} else { ?>
        <tr><td colspan="9" class="text-center">No requested books found</td></tr>
<?php } ?>                                      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reserved Books Section -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Reserved Books</strong>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-reserved">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Book Name</th>
                                <th>Reservation Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
<?php 
$sql2 = "SELECT r.StudentID, b.BookName, r.RequestDate, r.Status 
         FROM tblbookreservations r
         JOIN tblbooks b ON b.id = r.BookID";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$results2 = $query2->fetchAll(PDO::FETCH_OBJ);
$cnt2 = 1;
if($query2->rowCount() > 0){
    foreach($results2 as $res){ ?>                          
        <tr class="odd gradeX">
            <td class="center"><?php echo htmlentities($cnt2);?></td>
            <td class="center"><?php echo htmlentities($res->StudentID);?></td>
            <td class="center"><?php echo htmlentities($res->BookName);?></td>
            <td class="center"><?php echo htmlentities($res->RequestDate);?></td>
            <td class="center">
                <?php 
                    if($res->Status == 'Pending'){
                        echo '<span class="label label-warning">Pending</span>';
                    } elseif($res->Status == 'Approved'){
                        echo '<span class="label label-success">Approved</span>';
                    } else {
                        echo '<span class="label label-danger">Rejected</span>';
                    }
                ?>
            </td>
        </tr>
<?php $cnt2++; }} else { ?>
        <tr><td colspan="5" class="text-center">No reserved books found</td></tr>
<?php } ?>                                      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
