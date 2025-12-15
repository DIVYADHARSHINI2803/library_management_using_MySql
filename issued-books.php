<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {   
    header('location:index.php');
} else { 
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblbooks WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Book deleted successfully";
        header('location:manage-books.php');
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Online Library Management System | Issued Books</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Issued Books</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Issued Books
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book Name</th>
                                        <th>ISBN</th>
                                        <th>Issued Date</th>
                                        <th>Return Date</th>
                                        <th>Fine (â‚¹)</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$sid = $_SESSION['stdid'];
$sql = "SELECT 
            tblbooks.BookName,
            tblbooks.ISBNNumber,
            tblissuedbookdetails.IssuesDate,
            tblissuedbookdetails.ReturnDate,
            tblissuedbookdetails.id AS rid,
            tblissuedbookdetails.fine
        FROM tblissuedbookdetails
        JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId
        JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId
        WHERE tblstudents.StudentId = :sid
        ORDER BY tblissuedbookdetails.id DESC";
$query = $dbh->prepare($sql);
$query->bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;

if($query->rowCount() > 0) {
    foreach($results as $result) {               
        $fine = 0;
        $issuedDate = new DateTime($result->IssuesDate);
        $today = new DateTime();

        if ($result->ReturnDate == "") {
            // Book not yet returned
            $interval = $issuedDate->diff($today);
            $days = $interval->days;

            if ($days > 3) {
                $fine = ($days - 3) * 100; // â‚¹100 per day after 3 days
            }

            // âœ… Update fine in DB
            $updateFine = $dbh->prepare("UPDATE tblissuedbookdetails SET fine = :fine WHERE id = :rid");
            $updateFine->bindParam(':fine', $fine, PDO::PARAM_INT);
            $updateFine->bindParam(':rid', $result->rid, PDO::PARAM_INT);
            $updateFine->execute();
        } else {
            // If returned, use stored fine
            $fine = $result->fine;
        }
?>
    <tr class="odd gradeX">
        <td class="center"><?php echo htmlentities($cnt); ?></td>
        <td class="center"><?php echo htmlentities($result->BookName); ?></td>
        <td class="center"><?php echo htmlentities($result->ISBNNumber); ?></td>
        <td class="center"><?php echo htmlentities($result->IssuesDate); ?></td>
        <td class="center">
            <?php 
            if($result->ReturnDate == "") {
                echo "<span style='color:red'>Not Returned Yet</span>";
            } else {
                echo htmlentities($result->ReturnDate);
            }
            ?>
        </td>
        <td class="center"><?php echo htmlentities($fine); ?></td>
    </tr>
<?php 
$cnt++;
    }
} 
?>                                      
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT FILES -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
