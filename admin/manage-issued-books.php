<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
} else { 

// -----------------------------
// ✅ SEND MESSAGE SECTION
// -----------------------------
if(isset($_GET['sendmsg']) && isset($_GET['sid'])){
    $studentId = $_GET['sid'];
    $message = "Dear student, your book return date has exceeded. Please return the book as soon as possible.";

    // Insert message into tblmessage
    $sql = "INSERT INTO tblmessage (StudentID, Message) VALUES (:studentid, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentid', $studentId, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    
    if($query->execute()){
        $_SESSION['msg'] = "Message sent successfully to student ID: " . htmlentities($studentId);
    } else {
        $_SESSION['error'] = "Failed to send message.";
    }
    header('location:manage-issued-books.php');
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
    <title>Online Library Management System | Manage Issued Books</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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

        <!-- Alerts -->
        <div class="row">
            <?php if($_SESSION['error']!=""){ ?>
            <div class="col-md-6">
                <div class="alert alert-danger">
                    <strong>Error :</strong> <?php echo htmlentities($_SESSION['error']);?>
                    <?php $_SESSION['error']=""; ?>
                </div>
            </div>
            <?php } ?>

            <?php if($_SESSION['msg']!=""){ ?>
            <div class="col-md-6">
                <div class="alert alert-success">
                    <strong>Success :</strong> <?php echo htmlentities($_SESSION['msg']);?>
                    <?php $_SESSION['msg']=""; ?>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Issued Books</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Student ID</th>
                                        <th>Book Name</th>
                                        <th>Book ID</th>
                                        <th>ISBN</th>
                                        <th>Issued Date</th>
                                        <th>Return Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$sql = "SELECT tblstudents.FullName, tblstudents.StudentId, tblbooks.BookName, tblbooks.ISBNNumber, tblbooks.id as BookID, 
        tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate, tblissuedbookdetails.id as rid 
        FROM tblissuedbookdetails 
        JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
        JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
        ORDER BY tblissuedbookdetails.id DESC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;

if($query->rowCount() > 0){
    foreach($results as $result){ 
        $statusMsg = "";
        $days = 0;

        if($result->ReturnDate == ""){
            $date = date('Y/m/d');
            $date2 = date("Y/m/d", strtotime($result->IssuesDate));
            $diff = strtotime($date) - strtotime($date2);
            $days = floor($diff / 86400);
            
            if($days > 3){
                $exceededDays = $days - 3;
                $statusMsg = "$exceededDays days exceeded";
            } elseif($days < 3){
                $remaining = 3 - $days;
                $statusMsg = "$remaining days remaining";
            } else {
                $statusMsg = "Last day remaining";
            }
        }
?>
<tr class="odd gradeX">
    <td><?php echo htmlentities($cnt);?></td>
    <td><?php echo htmlentities($result->FullName);?></td>
    <td><?php echo htmlentities($result->StudentId);?></td>
    <td><?php echo htmlentities($result->BookName);?></td>
    <td><?php echo htmlentities($result->BookID);?></td>
    <td><?php echo htmlentities($result->ISBNNumber);?></td>
    <td><?php echo htmlentities($result->IssuesDate);?></td>
    <td>
        <?php 
        if($result->ReturnDate == ""){
            echo "Not Returned Yet <br><b>$statusMsg</b>";
        } else {
            echo htmlentities($result->ReturnDate);
        }
        ?>
    </td>
    <td>
        <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->rid);?>">
            <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button>
        </a>
        <?php if($days > 3){ ?>
            <a href="manage-issued-books.php?sendmsg=1&sid=<?php echo htmlentities($result->StudentId);?>" 
               onclick="return confirm('Send overdue message to this student?');">
               <button class="btn btn-danger"><i class="fa fa-envelope"></i> Send Msg</button>
            </a>
        <?php } ?>
    </td>
</tr>
<?php $cnt++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
<?php } ?>
