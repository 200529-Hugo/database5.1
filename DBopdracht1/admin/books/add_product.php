<?php
include('../core/header.php');
include('../core/checklogin_admin.php');
?>

    <h1>Add book</h1>

<?php
if (isset($_POST['submit']) && $_POST['submit'] != '') {
    $title = $con->real_escape_string($_POST['title']);
    $author = $con->real_escape_string($_POST['author']);
    $isbn = $con->real_escape_string($_POST['isbn']);
    $publisher = $con->real_escape_string($_POST['publisher']);
    $page = $con->real_escape_string($_POST['page']);
    $dimensions = $con->real_escape_string($_POST['dimensions']);
    $overview = $con->real_escape_string($_POST['overview']);
    $liqry = $con->prepare("INSERT INTO books (`title`, `author`, `isbn13`, `format`, `publisher`, `pages`, `dimensions`, `overview`) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    if($liqry === false) {
        echo mysqli_error($con);
    } else{
        $liqry->bind_param('sssssss',$title,$author,$isbn,$publisher,$page,$dimensions,$overview);
        if($liqry->execute()){
            echo "Product with ISBN13 " . $isbn . " added.";
            header('Refresh: 2; index.php');
        }
    }
    $liqry->close();
}

?>

    <form action="" method="POST" enctype="multipart/form-data">
        Title: <input type="text" name="title" value=""><br>
        Author: <input type="text" name="author" value=""><br>
        ISBN13: <input type="number" name="isbn" value=""><br>
        Format: <input type="text" name="format" value=""><br>
        Publisher: <input type="text" name="publisher" value=""><br>
        Pages: <input type="number" name="page" value=""><br>
        Dimensions: <input type="text" name="dimensions" value=""><br>
        overview: <textarea type="text" name="overview" value=""></textarea><br>
        
        <input type="submit" name="submit" value="Add">
        <a href="index.php">Go Back</a>
    </form>

<?php
include('../core/footer.php');
?>