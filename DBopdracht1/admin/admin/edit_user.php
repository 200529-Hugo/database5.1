<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
?>

<h1>Edit admin</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $uid = $con->real_escape_string($_POST['uid']);
        $email = $con->real_escape_string($_POST['email']);
        $query1 = $con->prepare("UPDATE admin SET mail = ? WHERE id = ? LIMIT 1;");
        if ($query1 === false) {
            echo mysqli_error($con);
        }
                    
        $query1->bind_param('si',$email,$uid);
        if ($query1->execute() === false) {
            echo mysqli_error($con);
        } else {
            echo '<div style="border: 2px solid red; width: fit-content;">Edited admin</div>';
            header('Refresh: 2; index.php');
        }
        $query1->close();
                    
    }
?>



<form action="" method="POST">
<?php
    if (isset($_GET['uid']) && $_GET['uid'] != '') {
        $uid = $con->real_escape_string($_GET['uid']);

        $liqry = $con->prepare("SELECT id, mail FROM admin WHERE id = ? LIMIT 1;");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('i',$uid);
            $liqry->bind_result($adminId,$email);
            if($liqry->execute()){
                $liqry->store_result();
                $liqry->fetch();
                if($liqry->num_rows == '1'){
                    echo '$adminId: <input type="text" name="uid" value="' . $adminId . '" readonly><br>';
                    echo '$email: <input type="text" name="email" value="' . $email . '"><br>';
                }
            }
        }
        $liqry->close();

    }
?>
<br>
<input type="submit" name="submit" value="Save">
<a href="index.php">Go Back</a>
</form>

<?php
    include('../core/footer.php');
?>