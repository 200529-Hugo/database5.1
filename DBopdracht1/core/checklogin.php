<?php
$loginError = false;
if (!isset($_SESSION['cust_id']) || $_SESSION['cust_id'] == "" || $_SESSION['cust_id'] == '0' || 
	!isset($_SESSION['cust_email']) || $_SESSION['cust_email'] == "" || $_SESSION['cust_email'] == '0' ||
	!isset($_SESSION['cust_name']) || $_SESSION['cust_name'] == "" || $_SESSION['cust_name'] == '0'){
	$loginError = true;
}

if ($loginError){
	exit('Sessie verlopen<meta http-equiv="refresh" content="2; URL='.BASEURL.'index.php">');
}