<?php
    include('core/db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>LightSend</title>
</head>
<body>
<div class="container">
    <header>
        <h1>Welcome by <b>LightSend</b></h1>
    </header>
    <main>

<h1>Register here!</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != ''){
        $name = $con->real_escape_string($_POST['name']);
        $mail = $con->real_escape_string($_POST['mail']);
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $liqry = $con->prepare("INSERT INTO customer (name, mail, password) VALUES ( ?, ?, ?)");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('sss',$name, $mail, $passwordHash);
            if($liqry->execute()){
                header('Location: index.php');
            }
        }
        $liqry->close();
    }
?>

<form action="" method="POST">
    <span>Name:</span> <input type="text" name="name"><br><br>
    <span>Email: </span><input type="email" name="mail"><br><br>
    <span>Password: </span><input type="password" name="password"><br><br>
    <br>
    <input type="submit" name="submit" value="Add">
    <p>Already have an account? <a href="index.php">Login here!</a></p>
</form>



<?php
    include('core/footer.php');
?>