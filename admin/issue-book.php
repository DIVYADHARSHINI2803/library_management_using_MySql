<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
    exit();
}

if(isset($_POST['issue']))
{
    $studentid = strtoupper($_POST['studentid']);
    $bookid = $_POST['bookdetails'];

    // Insert issued book record
    $sql = "INSERT INTO tblissuedbookdetails(StudentID, BookId) VALUES(:studentid, :bookid)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
    $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if($lastInsertId)
    {
        // Update issued copies
        $sql = "UPDATE tblbooks SET IssuedCopies = IssuedCopies + 1 WHERE id = :bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->execute();

        // Success alert and redirect
        echo "<script>alert('Book issued successfully'); window.location.href='manage-issued-books.php';</script>";
        exit();
    }
    else 
    {
        // Error alert and redirect
        echo "<script>alert('Something went wrong. Please try again'); window.location.href='manage-issued-books.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Online Library Management System | Issue a new Book</title>
    
    <!-- BOOTSTRAP CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script>
    function getstudent() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "get_student.php",
            data: 'studentid=' + $("#studentid").val(),
            type: "POST",
            success: function(data){
                $("#get_student_name").html(data);
                $("#loaderIcon").hide();
            },
            error: function (){}
        });
    }

    function getbook() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "get_book.php",
            data: 'bookid=' + $("#bookid").val(),
            type: "POST",
            success: function(data){
                $("#get_book_name").html(data);
                $("#loaderIcon").hide();
            },
            error: function (){}
        });
    }
    </script>
    <style>
        .others {
            color: red;
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Issue a New Book</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">Issue a New Book</div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label>Student ID <span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" autocomplete="off" required />
                            </div>

                            <div class="form-group">
                                <span id="get_student_name" style="font-size:16px;"></span> 
                            </div>

                            <div class="form-group">
                                <label>Book ID <span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()" required />
                            </div>

                            <div class="form-group">
                                <label>Book Title <span style="color:red;">*</span></label>
                                <select class="form-control" name="bookdetails" id="get_book_name" readonly>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="issue" id="submit" class="btn btn-info">Issue Book</button>
                            </div>
                        </form>
                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- content-wrapper -->

<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
