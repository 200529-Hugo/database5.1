<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
    include('customer-menu.php');
?>

<h1>Customer overview</h1>

<?php
        $liqry = $con->prepare("SELECT id, name, mail FROM customer");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_result($custId,$name,$mail);
            if($liqry->execute()){
                $liqry->store_result();
                echo '<table border=1>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Email</td>
                        </tr>';
                while ($liqry->fetch() ) { ?>
                        <tr>
                        <td><?php echo $custId; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $mail; ?></td>
                        <td><a href="edit_customer.php?uid=<?php echo $custId; ?>">edit</a></td>
                        <td><a href="delete_customer.php?uid=<?php echo $custId; ?>">delete</a></td>
                    </tr>
                    <?php 
                }
                echo '</table>';
            }

            $liqry->close();
        }

?>

<?php
    include('../core/footer.php');
?>
