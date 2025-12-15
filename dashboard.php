<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0){ 
    header('location:index.php');
} else {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | User Dashboard</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<?php include('includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">User DASHBOARD</h4>
            </div>
        </div>

        <div class="row">
            <!-- Total Issued Books -->
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="alert alert-info back-widget-set text-center">
                    <i class="fa fa-bars fa-5x"></i>
                    <?php 
                    $sid = $_SESSION['stdid'];
                    $sql1 = "SELECT id FROM tblissuedbookdetails WHERE StudentID=:sid";
                    $query1 = $dbh->prepare($sql1);
                    $query1->bindParam(':sid', $sid, PDO::PARAM_STR);
                    $query1->execute();
                    $issuedbooks = $query1->rowCount();
                    ?>
                    <h3><?php echo htmlentities($issuedbooks);?></h3>
                    Book Issued
                </div>
            </div>

            <!-- Books Not Returned -->
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="alert alert-warning back-widget-set text-center">
                    <i class="fa fa-recycle fa-5x"></i>
                    <?php 
                    $rsts = 0;
                    $sql2 = "SELECT id FROM tblissuedbookdetails WHERE StudentID=:sid AND ReturnStatus=:rsts";
                    $query2 = $dbh->prepare($sql2);
                    $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
                    $query2->bindParam(':rsts', $rsts, PDO::PARAM_STR);
                    $query2->execute();
                    $returnedbooks = $query2->rowCount();
                    ?>
                    <h3><?php echo htmlentities($returnedbooks);?></h3>
                    Books Not Returned Yet
                </div>
            </div>
        </div>

        <!-- ==================== NEW SECTION: MESSAGES ==================== -->
        <div class="row" style="margin-top:40px;">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-envelope"></i> Messages from Admin
                    </div>
                    <div class="panel-body">
                        <?php
                        $sql3 = "SELECT * FROM tblmessage WHERE StudentID = :sid ORDER BY SentDate DESC";
                        $query3 = $dbh->prepare($sql3);
                        $query3->bindParam(':sid', $sid, PDO::PARAM_STR);
                        $query3->execute();
                        $messages = $query3->fetchAll(PDO::FETCH_OBJ);

                        if($query3->rowCount() > 0){ ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Message</th>
                                            <th>Date Sent</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $cnt = 1;
                                        foreach($messages as $msg){ ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($msg->Message);?></td>
                                                <td><?php echo htmlentities(date("d M Y - h:i A", strtotime($msg->SentDate)));?></td>
                                                <td>
                                                    <?php if($msg->Status == 'Unread'){ ?>
                                                        <span class="label label-danger">Unread</span>
                                                    <?php } else { ?>
                                                        <span class="label label-success">Read</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php $cnt++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info text-center">
                                <strong>No messages found.</strong>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- ==================== END MESSAGES SECTION ==================== -->

    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
