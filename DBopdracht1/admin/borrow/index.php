<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
    include('borrow-menu.php');
?>

<h1>Borrow overview</h1>

<?php
    $liqry = $con->prepare("SELECT `id`, `book_isbn`, `book_name`, `customer_name`, `borrow_date`, `email_date` FROM `borrow` ORDER BY email_date");
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
                echo '<a href="edit_borrow.php?isbn='.$isbn.'">edit</a><br>';
                echo '<br> <br>';
            }
        }
        $liqry->close();
    }

?>

<?php
    include('../core/footer.php');
?>
