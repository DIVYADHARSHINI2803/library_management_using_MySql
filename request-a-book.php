<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login'])==0){   
    header('location:index.php');
    exit;
}

// Handle AJAX Request or Reserve
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['bookid'])){
    $bookid = intval($_POST['bookid']);
    $available = intval($_POST['available']);
    $studentid = $_SESSION['stdid'];
    $studname = $_SESSION['login']; // assuming student name is stored in session

    if($available){
        // Fetch book details
        $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName,
                       tblbooks.ISBNNumber, tblbooks.BookPrice
                FROM tblbooks
                JOIN tblcategory ON tblcategory.id=tblbooks.CatId
                JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId
                WHERE tblbooks.id=:bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookid',$bookid,PDO::PARAM_INT);
        $query->execute();
        $book = $query->fetch(PDO::FETCH_OBJ);

        if($book){
            // Insert into request table
            $insert = "INSERT INTO tblrequestedbookdetails
                       (StudentID, StudName, BookName, CategoryName, AuthorName, ISBNNumber, BookPrice)
                       VALUES(:studentid, :studname, :bookname, :category, :author, :isbn, :price)";
            $query = $dbh->prepare($insert);
            $query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
            $query->bindParam(':studname',$studname,PDO::PARAM_STR);
            $query->bindParam(':bookname',$book->BookName,PDO::PARAM_STR);
            $query->bindParam(':category',$book->CategoryName,PDO::PARAM_STR);
            $query->bindParam(':author',$book->AuthorName,PDO::PARAM_STR);
            $query->bindParam(':isbn',$book->ISBNNumber,PDO::PARAM_STR);
            $query->bindParam(':price',$book->BookPrice,PDO::PARAM_STR);
            $query->execute();

            echo "Book request sent successfully to admin!";
            exit();
        } else {
            echo "Error fetching book details!";
            exit();
        }
    } else {
        // Reserve book
        $insert = "INSERT INTO tblbookreservations(StudentID, BookID, Status) 
                   VALUES(:studentid, :bookid, 'Pending')";
        $query = $dbh->prepare($insert);
        $query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
        $query->bindParam(':bookid',$bookid,PDO::PARAM_INT);
        $query->execute();

        echo "Book reserved successfully!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Library | Request or Reserve Book</title>
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
<link href="assets/css/style.css" rel="stylesheet" />
<script src="assets/js/jquery-1.10.2.js"></script>
<script>
$(document).ready(function(){
    $(".request-btn").click(function(e){
        e.preventDefault();
        var bookid = $(this).data('id');
        var available = $(this).data('available');

        $.ajax({
            type: "POST",
            url: "request-a-book.php",
            data: {bookid: bookid, available: available},
            success: function(response){
                $("#msg").html('<div class="alert alert-success">' + response + '</div>');
            }
        });
    });
});
</script>
</head>
<body>
<?php include('includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Request or Reserve a Book</h4>
            </div>
        </div>

        <div id="msg"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">All Books</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book Name</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>ISBN</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$sql = "SELECT tblbooks.id as bookid, tblbooks.BookName, tblcategory.CategoryName, 
        tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.BookPrice,
        tblbooks.Copies, tblbooks.IssuedCopies
        FROM tblbooks 
        JOIN tblcategory ON tblcategory.id=tblbooks.CatId 
        JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0){
    foreach($results as $result){
        $isAvailable = ($result->Copies > $result->IssuedCopies);
?>
<tr>
    <td><?php echo htmlentities($cnt);?></td>
    <td><?php echo htmlentities($result->BookName);?></td>
    <td><?php echo htmlentities($result->CategoryName);?></td>
    <td><?php echo htmlentities($result->AuthorName);?></td>
    <td><?php echo htmlentities($result->ISBNNumber);?></td>
    <td><?php echo htmlentities($result->BookPrice);?></td>
    <td>
        <?php echo $isAvailable ? '<span class="label label-success">Available</span>' 
                                : '<span class="label label-danger">Unavailable</span>'; ?>
    </td>
    <td>
        <button class="btn <?php echo $isAvailable ? 'btn-primary' : 'btn-warning'; ?> request-btn"
                data-id="<?php echo $result->bookid;?>" 
                data-available="<?php echo $isAvailable ? 1 : 0;?>">
            <?php echo $isAvailable ? 'Request' : 'Reserve'; ?>
        </button>
    </td>
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
            </div>
        </div>
    </div>
</div>

<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
