<?php
    include('core/header.php');
    include('core/checklogin_admin.php');
?>
<h1>Welcome user <?php echo $_SESSION['Sadmin_id']; ?></h1>
- <a href="logout.php">Log-out</a> <br>

<?php
if ( isset($_GET['logout'])  && $_GET['logout'] == '1') {
    unset($_SESSION['Sadmin_id']);
    unset($_SESSION['Sadmin_email']);
    header("location:index.php");
}
?>


<ul>
    <li>
        <a href="admin/">Admin users</a>
    </li>
    <li>
        <a href="customer/">Customers</a>
    </li>
    <li>
        <a href="books/">Books</a>
    </li>
    <li>
        <a href="borrow/">Borrow</a>
    </li>
</ul>
<?php
    include('core/footer.php');
?>