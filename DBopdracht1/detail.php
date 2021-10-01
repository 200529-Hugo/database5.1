<?php 
    include('core/header.php');
    include('core/checklogin.php');
    $uid = $con->real_escape_string($_GET['uid']);

    if (isset($_GET['pid']) && $_GET['pid'] != '') {
        $pid = $con->real_escape_string($_GET['pid']);

        $liqry = $con->prepare("SELECT `title`, `author`, `isbn13`, `format`, `publisher`, `pages`, `dimensions` FROM books WHERE isbn13 = ? LIMIT 1;");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('i',$pid);
            $liqry->bind_result($title, $author, $isbn, $format, $publisher, $pages, $dimensions);
            if($liqry->execute()){
                $liqry->store_result();
                while($liqry->fetch()) {
                    $columns = array('title','author', 'isbn', 'format','dimensions', 'pages', 'publisher');
                    foreach ($columns as $key) {
                        if ($key == 'author' || $key == 'isbn') {
                            $class = 'detailinfo';
                        } else {
                            $class = 'buy';
                        }
                        echo '<div class="'.$class.'"><b>' . $key .'</b>: ' . $$key . '</div>';
                        if ($key == 'author' || $key == 'isbn') {
                            echo '<br>';
                        } else {
                            echo '';
                        }
                    }
                    echo '<br> <br>';
                }
            }
        }
    }
?>
<a href="form.php?pid=<?php echo $isbn; ?>&uid=<?php echo $uid; ?>&pname=<?php echo $title; ?>">
    <div class="buyButn">
        Borrow it
    </div>
</a>
<?php
    include('core/footer.php');
?>