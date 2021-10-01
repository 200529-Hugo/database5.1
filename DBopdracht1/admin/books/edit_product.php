<?php
include('../core/header.php');
include('../core/checklogin_admin.php');
?>

    <h1>Edit book</h1>

<?php
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $isbn = $con->real_escape_string($_POST['isbn']);
        $title = $con->real_escape_string($_POST['title']);
        $author = $con->real_escape_string($_POST['author']);
        $format = $con->real_escape_string($_POST['format']);
        $publisher = $con->real_escape_string($_POST['publisher']);
        $pages = $con->real_escape_string($_POST['pages']);
        $dimensions = $con->real_escape_string($_POST['dimensions']);
        $overview = $con->real_escape_string($_POST['overview']);
        $query1 = $con->prepare("UPDATE books SET `title` = ?, `author`= ?, `format` = ?, `publisher` = ?, `pages` = ?, `dimensions` = ?, `overview` = ? WHERE isbn13 = ? LIMIT 1;");
        if ($query1 === false) {
            echo mysqli_error($con);
        }

        $query1->bind_param('sssssssi',$title,$author,$format,$publisher,$pages,$dimensions,$overview,$isbn);
        if ($query1->execute() === false) {
            echo mysqli_error($con);
        } else {
            echo '<div style="border: 2px solid red">Edited product</div>';
            header('Refresh: 2; index.php');
        }
        $query1->close();

    }
?>



    <form action="" method="POST">
        <?php
        if (isset($_GET['isbn']) && $_GET['isbn'] != '') {
            $isbn = $con->real_escape_string($_GET['isbn']);

            $liqry = $con->prepare("SELECT `title`, `author`, `isbn13`, `format`, `publisher`, `pages`, `dimensions`, `overview` FROM books WHERE isbn13 = ? LIMIT 1;");
            if($liqry === false) {
                echo mysqli_error($con);
            } else{
                $liqry->bind_param('i',$isbn);
                $liqry->bind_result($title, $author, $isbn, $format, $publisher, $pages, $dimensions, $overview);
                if($liqry->execute()){
                    $liqry->store_result();
                    $liqry->fetch();
                    if($liqry->num_rows == '1'){
                        $columns = array('title', 'author', 'isbn', 'format', 'publisher', 'pages', 'dimensions', 'overview');
                        foreach ($columns as $key) {
                            $typeInput = "input";
                            $read = "";
                            $txtOrNum = "text";
                            if ($key == 'isbn') {
                                $read = "readonly";
                            }
                            if ($key == 'overview'){
                                $typeInput = "textarea";
                            }
                            if ($key == 'pages') {
                                $txtOrNum = "number";
                            }
                            echo '<b>' . $key .'</b> :<'.$typeInput.' type="' . $txtOrNum . '" name="'.$key.'" value="' . $$key . '" '.$read.'>';
                            if ($typeInput == "textarea") {
                                echo $$key.'</textarea><br>';
                            } else{
                                echo '<br>';
                            }
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