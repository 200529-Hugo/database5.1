<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
    include('users-menu.php');
?>

<h1>Admin overview</h1>

<?php
        $liqry = $con->prepare("SELECT id, mail FROM admin");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_result($adminId,$email);
            if($liqry->execute()){
                $liqry->store_result();
                echo '<table border=1>
                        <tr>
                            <td>admin id</td>
                            <td>email</td>
                            <td>edit</td>
                            <td>delete</td>
                        </tr>';
                while ($liqry->fetch() ) { ?>
                        <tr>
                            <td><?php echo $adminId; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><a href="edit_user.php?uid=<?php echo $adminId; ?>">edit</a></td>
                            <td><a href="delete_user.php?uid=<?php echo $adminId; ?>">delete</a></td>
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
