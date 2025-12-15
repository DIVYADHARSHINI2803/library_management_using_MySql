<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {   
    header('location:index.php');
    exit();
}

// ✅ Fetch fine amount from database (from set-fine table)
$fineQuery = $dbh->prepare("SELECT fine FROM tblfine LIMIT 1");
$fineQuery->execute();
$fineResult = $fineQuery->fetch(PDO::FETCH_OBJ);
$finePerDay = $fineResult ? $fineResult->fine : 0;

// ✅ Fetch overdue books (not returned and more than 3 days)
$sql = "SELECT 
            tblstudents.FullName AS StudentName,
            tblstudents.StudentId AS StudentID,
            tblstudents.MobileNumber AS MobNumber,
            tblbooks.BookName,
            tblissuedbookdetails.IssuesDate,
            tblissuedbookdetails.ReturnDate,
            DATEDIFF(CURDATE(), DATE_ADD(tblissuedbookdetails.IssuesDate, INTERVAL 3 DAY)) AS DaysExceeded
        FROM 
            tblissuedbookdetails
        JOIN 
            tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId
        JOIN 
            tblbooks ON tblbooks.id = tblissuedbookdetails.BookId
        WHERE 
            (tblissuedbookdetails.ReturnDate IS NULL 
             OR tblissuedbookdetails.ReturnDate = '0000-00-00')
            AND DATE_ADD(tblissuedbookdetails.IssuesDate, INTERVAL 3 DAY) < CURDATE()";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Overdue Report | Library Management System</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Overdue Report (After 3 Days)</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Books Not Returned Within 3 Days</div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Mobile Number</th>
                                    <th>Book Name</th>
                                    <th>Issue Date</th>
                                    <th>Days Exceeded</th>
                                    <th>Total Fine (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $cnt = 1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) {
                                        $daysExceeded = max(0, $result->DaysExceeded);
                                        $totalFine = $daysExceeded * $finePerDay;
                                ?>  
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($result->StudentName);?></td>
                                            <td><?php echo htmlentities($result->StudentID);?></td>
                                            <td><?php echo htmlentities($result->MobNumber);?></td>
                                            <td><?php echo htmlentities($result->BookName);?></td>
                                            <td><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td><?php echo htmlentities($daysExceeded);?></td>
                                            <td><?php echo htmlentities($totalFine);?></td>
                                        </tr>
                                <?php $cnt++; } } else { ?>
                                        <tr><td colspan="8" align="center">No Overdue Books Found</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <button onclick="window.print()" class="btn btn-primary">Print Report</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
