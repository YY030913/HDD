<?php
session_start();
if(!isset($_SESSION['login']))
{
	exit;
}
include "../../config/config.php";

if($_GET['type'] == 'classroom')
{
	$sql="TRUNCATE TABLE hdd_classroom";
	$location="../classstatus.php";
}
elseif($_GET['type'] == 'duty')
{
	$sql="TRUNCATE TABLE hdd_onduty";
	$location="../onduty.php";
}else{
	exit;
}
@mysql_query($sql) or die;//(mysql_error());
echo '<script>alert("删除成功！");history.go(-1);</script>';
?>
