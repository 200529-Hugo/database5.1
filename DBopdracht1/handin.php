<?php
    include('core/header.php');
    include('core/checklogin.php');
    $name = $_SESSION['cust_name'];
?>
<h1>Welcome back <?php echo $name ?>!</h1>
<br>
<?php
    if ( isset($_GET['logout'])  && $_GET['logout'] == '1') {
        unset($_SESSION['cust_id']);
        unset($_SESSION['cust_email']);
        header("location:index.php");
    }

    $liqry = $con->prepare("SELECT `id`, `book_isbn`, `book_name`, `customer_name`, `borrow_date`, `email_date` FROM `borrow` WHERE customer_name = ? ORDER BY email_date");
    $liqry->bind_param('i',$name);
    if($liqry === false) {
       echo mysqli_error($con);
    } else{
        $liqry->bind_result($id, $isbn, $book_name, $customer_name, $borrow_date, $email_date);
        if($liqry->execute()){
            $liqry->store_result();
            while($liqry->fetch()) {
                $columns = array('id', 'isbn', 'book_name', 'customer_name', 'borrow_date', 'email_date');
                foreach ($columns as $key) {
                    echo '<b>' . $key .'</b> : ' . $$key;
                    echo '<br>';
                }
                echo '<a href="handingin.php?pid='.$id.'&isbn='.$isbn. '">Hand in</a><br>';
                echo '<br> <br>';
            }
        }
        $liqry->close();
    }
    include('core/footer.php');
?>