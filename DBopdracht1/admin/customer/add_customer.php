<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
?>

<h1>Add customer</h1>

<?php
    if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['password'])){
        $name = $con->real_escape_string($_POST['name']);
        $mail = $con->real_escape_string($_POST['mail']);
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $liqry = $con->prepare("INSERT INTO customer (name, mail, password) VALUES (?, ?, ?)");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('sss',$name,$mail,$passwordHash);
            if($liqry->execute()){
                echo "Customer with email " . $email . " added.";
                header('Location: index.php');
            }
        }
        $liqry->close();
    }
?>

<form action="" method="POST">
    Name: <input type="text" name="name"><br>
    Email: <input type="text" name="mail"><br>
    Password: <input type="password" name="password"><br>
    <br>
    <input type="submit" name="submit" value="Add">
    <a href="index.php">Go Back</a>
</form>



<?php
    include('../core/footer.php');
?>