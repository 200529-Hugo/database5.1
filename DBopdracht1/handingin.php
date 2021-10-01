<?php
    include('core/header.php');
    include('core/checklogin.php');
    $pid = $con->real_escape_string($_GET['pid']);
    $isbn = $con->real_escape_string($_GET['isbn']);
?>
<?php
    if ( isset($_GET['logout'])  && $_GET['logout'] == '1') {
        unset($_SESSION['cust_id']);
        unset($_SESSION['cust_email']);
        header("location:index.php");
    }

    if (isset($_POST['submit']) && $_POST['submit'] != '') {       
        $query1 = $con->prepare("UPDATE books SET borrow = true WHERE isbn13 = ?");
        
        $query1->bind_param('i',$isbn);
        if($query1->execute()){
            $query2 = $con->prepare("DELETE FROM borrow WHERE id = ? LIMIT 1");
            $query2->bind_param('i',$pid);
            $query2->execute();
            echo '<div style="border: 2px solid red; width: fit-content;">BOOK HANDED IN</div>';
            header('Refresh: 2; handin.php');
            $query2->close();
        } else{
            echo "bruhhh";
        }
        $query1->close();   
    }

    $liqry = $con->prepare("SELECT `id`, `book_isbn`, `book_name`, `customer_name`, `borrow_date`, `email_date` FROM `borrow` WHERE id = ?");
    $liqry->bind_param('i',$pid);
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
                echo '<br><form action="" method="POST"><input type="submit" name="submit" value="Hand in"></form><br>';
                echo '<a href="handin.php">BACK</a><br>';
                echo '<br> <br>';
            }
        }
        $liqry->close();
    }
    include('core/footer.php');
?>