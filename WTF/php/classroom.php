<?php
session_start();
if(!isset($_SESSION['login']))
{
	exit;
}
require_once "../../config/config.php";
$week=$_POST['week'];
$time=$_POST['time'];
$room=$_POST['room'];
$content=$_POST['content'];
$sql="SELECT * FROM hdd_classroom WHERE week='$week' AND time='$time' AND room='$room'";
$result=@mysql_query($sql) or die;//(mysql_error());
$num=mysql_num_rows($result);
if(!$num)
{
	$sql="INSERT INTO hdd_classroom (week, time, room, content) VALUES ('$week', '$time', '$room', '$content')";
	@mysql_query($sql) or die(mysql_error());
	echo '<script>alert("添加成功！");history.go(-1);</script>';
}else{
	echo '<script>alert("添加时间冲突了~请注意是否需要清空上周数据。");history.go(-1);</script>';
}
?>

