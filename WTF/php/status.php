<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo "请登录";
	exit;
}
require_once "../../config/config.php";
$id=$_POST['id'];
$status=$_POST['status'];
$sql="INSERT INTO hdd_teachers_status (tid, status, time) VALUES ('$id', '$status', NOW())";
@mysql_query($sql) or die;//(mysql_error());
echo '1';
?>