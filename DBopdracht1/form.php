<?php 
    include('core/header.php');
    include('core/checklogin.php');
    $pid = $con->real_escape_string($_GET['pid']);
    $uid = $con->real_escape_string($_GET['uid']);
    $pname = $con->real_escape_string($_GET['pname']);
?>

<h1>UNDER CONSTRUCTION!</h1>

<?php
    $dDate = date("Y-m-d");
    $eDate = date("Y-m-d",strtotime($dDate."+ 4 weeks"));

    echo $uid . '<br>';
    echo $pid . '<br>';
    echo $pname . '<br>';
    echo $dDate . '<br>';
    echo $eDate . '<br>';
    if (isset($_POST['submit']) && $_POST['submit'] != ''){
        $liqry = $con->prepare("INSERT INTO `borrow`(`book_isbn`, `book_name`, `customer_name`, `borrow_date`, `email_date`) VALUES (?,?,?,?,?)");
        $liqry->bind_param('sssss',$pid, $pname, $uid, $dDate, $eDate);
        $liqry->execute();
        $liqry2 = $con->prepare("UPDATE books SET borrow = 0 WHERE isbn13 = ?");
        $liqry2->bind_param('i',$pid);
        $liqry2->execute();
        $liqry->close();
        $liqry2->close();
        header('location: wellDone.php?pid='.$pid);
    }
?>

<form action="" method="POST">
    <input type="hidden" value="Bruhhh">
    <input type="submit" name="submit" value="Borrow IT">
</form>
<br>
<a href="detail.php?pid=<?php echo $pid?>">
    <div>
        Go Back
    </div>
</a>

<?php
    include('core/footer.php');
?>