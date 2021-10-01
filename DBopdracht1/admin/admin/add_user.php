<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
?>

<h1>Add admin</h1>

<?php
    if (isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['password']) && $_POST['password']) {
        $email = $con->real_escape_string($_POST['email']);
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $liqry1 = $con->prepare("INSERT INTO admin (mail, password) VALUES (?, ?)");
        if($liqry1 === false) {
           echo mysqli_error($con);
        } else{
            $liqry1->bind_param('ss',$email,$passwordHash);
            if($liqry1->execute()){
                echo "admin user with email " . $email . " added.";
                header('Refresh: 2; index.php');
            }
        }
        $liqry1->close();
    }
?>

<form action="" method="POST">
email: <input type="text" name="email" value=""><br>
password: <input type="password" name="password" value=""><br><br>
<input type="submit" name="submit" value="Add">
<a href="index.php">Go Back</a>
</form>



<?php
    include('../core/footer.php');
?>