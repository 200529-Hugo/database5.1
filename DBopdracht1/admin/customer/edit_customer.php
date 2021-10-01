<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
?>

<h1>Edit customer</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $cust_id = $con->real_escape_string($_POST['cust_id']);
        $name = $con->real_escape_string($_POST['name']);
        $mail = $con->real_escape_string($_POST['mail']);
        $query1 = $con->prepare("UPDATE customer SET name = ?, mail = ? WHERE id = ? LIMIT 1;");
        if ($query1 === false) {
            echo mysqli_error($con);
        }
                    
        $query1->bind_param('ssi',$name,$mail,$cust_id);
        if ($query1->execute() === false) {
            echo mysqli_error($con);
        } else {
            echo '<div style="border: 2px solid red; width: fit-content;">User edited</div>';
            header('Refresh: 2; index.php');
        }
        $query1->close();
                    
    }
?>



<form action="" method="POST">
<?php
    if (isset($_GET['uid']) && $_GET['uid'] != '') {
        $uid = $con->real_escape_string($_GET['uid']);

        $liqry = $con->prepare("SELECT id, name, mail FROM customer WHERE id = ? LIMIT 1;");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('i',$uid);
            $liqry->bind_result($cust_id,$name,$mail);
            if($liqry->execute()){
                $liqry->store_result();
                $liqry->fetch();
                if($liqry->num_rows == '1'){
                    $columns = array('cust_id', 'name', 'mail');
                    foreach ($columns as $key) {
                        $typeInput = "input";
                        $type = "text";
                        $read = "";
                        if ($key == 'cust_id') {
                            $read = "readonly";
                        }
                        if ($key == 'mail') {
                            $type = "email";
                        }
                        echo '<b>' . $key .'</b> :<'.$typeInput.' type="'.$type.'" name="'.$key.'" value="' . $$key . '" '.$read.'><br>';
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