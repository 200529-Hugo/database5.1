<?php
    include('../core/header.php');
    include('../core/checklogin_admin.php');
    include('products-menu.php');
?>

<h1>Book overview</h1>

<?php
    $liqry = $con->prepare("SELECT `title`, `author`, `isbn13`, `format`, `publisher`, `pages`, `dimensions`, `overview` FROM books");
    if($liqry === false) {
       echo mysqli_error($con);
    } else{
        $liqry->bind_result($title, $author, $isbn, $format, $publish, $pages, $dimensions, $overview);
        if($liqry->execute()){
            $liqry->store_result();
            while($liqry->fetch()) {
                $columns = array('title', 'author', 'isbn', 'format', 'publish', 'pages', 'dimensions', 'overview');
                foreach ($columns as $key) {
                    echo '<b>' . $key .'</b> : ' . $$key;
                    echo '<br>';
                }
                echo '<a href="edit_product.php?isbn='.$isbn.'">edit</a><br>';
                echo '<a href=delete_product.php?isbn='.$isbn.'>delete</a><br>';
                echo '<br> <br>';
            }
        }
        $liqry->close();
    }

?>

<?php
    include('../core/footer.php');
?>
