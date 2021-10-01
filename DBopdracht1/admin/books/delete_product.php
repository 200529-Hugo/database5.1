<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
?>

<h1>Delete book</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $isbn = $con->real_escape_string($_POST['isbn']);
        $query = $con->prepare("DELETE FROM books WHERE isbn13 = ?;");
        if ($query === false) {
            echo mysqli_error($con);
        }
                    
        $query->bind_param('i',$isbn);
        if ($query->execute() === false) {
            echo mysqli_error($con);
        } else {
            echo '<div style="border: 2px solid red; width: fit-content;">Product with ISBN13 '.$isbn.' deleted!</div>';
            header('Refresh: 2; index.php');
        }
        $query->close();
                    
    }
?>


<?php
    if (isset($_GET['isbn']) && $_GET['isbn'] != '') {

        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

        <h2 style="color: red">Are you sure you want to delete this book?</h2>
        <?php

        $isbn = $con->real_escape_string($_GET['isbn']);

        $liqry = $con->prepare("SELECT title, author FROM books WHERE isbn13 = ? LIMIT 1;");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('i',$isbn);
            $liqry->bind_result($title,$author);
            if($liqry->execute()){
                $liqry->store_result();
                $liqry->fetch();
                if($liqry->num_rows == '1'){
                    echo 'Name: ' . $title . '<br>';
                    echo '<input type="hidden" name="isbn" value="' . $isbn . '" />';
                    echo 'Author: ' . $author . '<br>';
                    echo 'ISBN13: '. $isbn . '<br>';
                }
            }
        }
        $liqry->close();

        ?>
        <br>
        <input type="submit" name="submit" value="Yes, delete!">
        <a href="index.php">Go back</a>
        </form>
        <?php

    }
?>

<?php
    include('../core/footer.php');
?>