<?php
include('../core/header.php');
include('../core/checklogin_admin.php');
?>

    <h1>Edit book</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $id = $con->real_escape_string($_POST['id']);
        $email_date = $con->real_escape_string($_POST['email_date']);
        $query1 = $con->prepare("UPDATE borrow SET `email_date` = ? WHERE id = ? LIMIT 1;");
        if ($query1 === false) {
            echo mysqli_error($con);
        }

        $query1->bind_param('si',$email_date,$id);
        if ($query1->execute() === false) {
            echo mysqli_error($con);
        } else {
            echo '<div style="border: 2px solid red">Edited borrow</div>';
            header('Refresh: 2; index.php');
        }
        $query1->close();

    }
?>



    <form action="" method="POST">
        <?php
        if (isset($_GET['isbn']) && $_GET['isbn'] != '') {
            $isbn = $con->real_escape_string($_GET['isbn']);

            $liqry = $con->prepare("SELECT `id`, `book_isbn`, `book_name`, `customer_name`, `borrow_date`, `email_date` FROM borrow WHERE book_isbn = ? LIMIT 1;");
            if($liqry === false) {
                echo mysqli_error($con);
            } else{
                $liqry->bind_param('i',$isbn);
                $liqry->bind_result($id, $isbn, $book_name, $customer_name, $borrow_date, $email_date);
                if($liqry->execute()){
                    $liqry->store_result();
                    $liqry->fetch();
                    if($liqry->num_rows == '1'){
                        $columns = array('id', 'isbn', 'isbn', 'book_name', 'customer_name', 'borrow_date', 'email_date');
                        foreach ($columns as $key) {
                            $typeInput = "input";
                            $read = "";
                            $txtOrDate = "text";
                            if ($key == 'isbn' || $key == 'id' || $key == 'book_name' || $key == 'customer_name' || $key == 'borrow_date') {
                                $read = "readonly";
                            }
                            if ($key == 'email_date') {
                                $txtOrDate = "date";
                            }
                            echo '<b>' . $key .'</b> :<'.$typeInput.' type="' . $txtOrDate . '" name="'.$key.'" value="' . $$key . '" '.$read.'>';
                            if ($typeInput == "textarea") {
                                echo $$key.'</textarea><br>';
                            } else{
                                echo '<br>';
                            }
                        }


                    }
                }
            }
            $liqry->close();

        }
        ?>
        <br>
        <input type="submit" name="submit" value="Save">
        <a href="index.php">Go back</a>
    </form>

<?php
include('../core/footer.php');
?>