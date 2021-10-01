<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
?>

<h1>Delete admin</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $uid = $con->real_escape_string($_POST['uid']);
        $query1 = $con->prepare("DELETE FROM admin WHERE id = ? LIMIT 1;");
        if ($query1 === false) {
            echo mysqli_error($con);
        }
                    
        $query1->bind_param('i',$uid);
        if ($query1->execute() === false) {
            echo mysqli_error($con);
        } else {
            echo '<div style="border: 2px solid red; width: fit-content;">Admin with id '.$uid.' Deleted!</div>';
            header('Refresh: 2; index.php');
        }
        $query1->close();
                    
    }
?>


<?php
    if (isset($_GET['uid']) && $_GET['uid'] != '') {

        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

        <h2 style="color: red">Are you sure you want to delete admin?</h2><?php

        $uid = $con->real_escape_string($_GET['uid']);

        $liqry = $con->prepare("SELECT id,mail FROM admin WHERE id = ? LIMIT 1;");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('i',$uid);
            $liqry->bind_result($adminId,$email);
            if($liqry->execute()){
                $liqry->store_result();
                $liqry->fetch();
                if($liqry->num_rows == '1'){
                    echo '$adminId: ' . $adminId . '<br>';
                    echo '<input type="hidden" name="uid" value="' . $adminId . '" />';
                      echo '$email: ' . $email . '<br>';
                }
            }
        }
        $liqry->close();

        ?>
        <br>
        <input type="submit" name="submit" value="Yes, delete!">
        <a href="index.php">Go Back</a>
        </form>
        <?php

    }
?>

<?php
    include('../core/footer.php');
?>