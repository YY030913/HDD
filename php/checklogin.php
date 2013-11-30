<?php
session_start();
require_once "../config/config.php";
$uid=$_SESSION['uid'];
if($uid)
{
	$sql="SELECT * FROM hdd_user WHERE id='$uid'";
	$result=@mysql_query($sql) or die;//(mysql_error());
	$row=mysql_fetch_array($result);
	$_SESSION['emailverify']=$row['emailverify'];
	$_SESSION['accountverify']=$row['accountverify'];
	echo 1;
}else{
	echo 0;
}
?>