<?php
session_start();
if(!isset($_SESSION['login']))
{
	exit;
}
include "../../config/config.php";
$id=$_GET['id'];
$sql="DELETE FROM hdd_classroom WHERE id='$id'";
@mysql_query($sql) or die;//(mysql_error());
echo '<script>alert("删除成功！");history.go(-1);</script>';
?>