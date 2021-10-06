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
    <title>BIEB</title>
</head>
<body>
<div class="container">
    <header>
        <h1>Welcome by <b>BIEB</b></h1>
    </header>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $email = $con->real_escape_string($_POST['email']);
        $password = $con->real_escape_string($_POST['password']);
        $liqry = $con->prepare("SELECT id, name, mail, password FROM customer WHERE mail = ? LIMIT 1;");
        if($liqry === false) {
            trigger_error(mysqli_error($con));
        } else{
            $liqry->bind_param('s',$email);
            $liqry->bind_result($custId,$name,$email,$dbHashPassword);
            if($liqry->execute()){
                $liqry->store_result();
                $liqry->fetch();
                if(password_verify($password, $dbHashPassword)){
                    $_SESSION['cust_id'] = $custId;
                    $_SESSION['cust_email'] = stripslashes($email);
                    $_SESSION['cust_name'] = $name;
                    echo "Bezig met inloggen... <meta http-equiv=\"refresh\" content=\"1; URL=index_loggedin.php\">";
                    exit();
                } else {
                    echo "ERROR tijdens inloggen";
                }
            }
            $liqry->close();
        }
    }
?>

<main>
    <h1>Login here!</h1>
    <form action="index.php" method="post">
        <input type="email" name="email" id="" placeholder="Email">
        <input type="password" name="password" id="" placeholder="Password">
        <input type="submit" name="submit" value="Login">
        <p>Don't have an account? <a href="register.php">Make one!</a></p>
    </form>
</main>

<?php
    include('core/footer.php');
?>
