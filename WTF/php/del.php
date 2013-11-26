<?php
session_start();
if(!isset($_SESSION['login']))
{
	exit;
}
require_once "../config/config.php";
$id=$_GET['id'];
$sql="DELETE FROM hdd_teachers WHERE id='$id'";
@mysql_query($sql) or die(mysql_error());
$sql="DELETE FROM hdd_teachers_status WHERE tid='$id'";
@mysql_query($sql) or die(mysql_error());
echo '<script>alert("删除成功！");history.go(-1);</script>';
?>
