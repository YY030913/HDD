<?php
session_start();
if(!isset($_SESSION['login']))
{
	exit;
}
include "../../config/config.php";
$name=$_POST['name'];
$position=$_POST['position'];
$mobile=$_POST['mobile'];
$sql="INSERT INTO hdd_teachers (name, position, mobile) VALUES ('$name', '$position', '$mobile')";
@mysql_query($sql) or die;//(mysql_error());
echo '<script>alert("添加成功！");history.go(-1);</script>';
?>

