<?php
    include('core/header.php');
    include('core/checklogin.php');
?>
<h1>Welcome back <?php echo $_SESSION['cust_name']; ?>!</h1>
<br>
<?php
    if ( isset($_GET['logout'])  && $_GET['logout'] == '1') {
        unset($_SESSION['cust_id']);
        unset($_SESSION['cust_email']);
        header("location:index.php");
    }

    $liqry = $con->prepare("SELECT `title`, `author`, `isbn13`, `format`, `publisher`, `pages`, `dimensions`, `overview` FROM books WHERE borrow = 1");
    if($liqry === false) {
       echo mysqli_error($con);
    } else{
        $liqry->bind_result($title, $author, $isbn, $format, $publish, $pages, $dimensions, $overview);
        if($liqry->execute()){
            $liqry->store_result();
            while($liqry->fetch()) {
                $columns = array('title', 'author', 'isbn', 'format', 'publish', 'pages', 'dimensions', 'overview');
                echo '<a href="detail.php?pid='.$isbn.'&uid='.$_SESSION['cust_name'] . '"';
                foreach ($columns as $key) {
                    if ($key == 'title' || $key == 'overview') {
                        $class = '';
                    } else {
                        $class = 'buy';
                    }
                    echo '<article class="overview ' . $class . '"><b>' . $key .'</b><br>' . $$key . '</article>';
                    if ($key == 'title' || $key == 'overview') {
                        echo '<br>';
                    } else {
                        echo '';
                    }
                }
                echo '</a><br> <br>';
            }
        }
        $liqry->close();
    }
    include('core/footer.php');
?>