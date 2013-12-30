<?php
session_start();
if(!isset($_SESSION['login']))
{
	exit;
}
require_once "../config/config.php";
if($_GET['type'] == 'over')
{
	$sql="UPDATE hdd_onduty SET enabled = 0";
	@mysql_query($sql) or die;//(mysql_error());
	echo '<script>alert("下班啦！");history.go(-1);</script>';
}else{
	$name=$_POST['name'];
	$mobile=$_POST['mobile'];
	$sql="UPDATE hdd_onduty SET enabled = 0";
	@mysql_query($sql) or die;//(mysql_error());
	$sql="INSERT INTO hdd_onduty (name, mobile, enabled, time) VALUES ('$name', '$mobile', 1, NOW())";
	@mysql_query($sql) or die;//(mysql_error());
	echo '<script>alert("更新成功！");history.go(-1);</script>';
}
?>

