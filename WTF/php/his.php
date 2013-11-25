<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo "请登录";
	exit;
}
include "../../config/config.php";
$id=$_GET['id'];
$start=$_GET['start'].' 00:00:00';
$stop=$_GET['stop'].' 23:59:59';
$sql="SELECT * FROM hdd_teachers WHERE id='$id'";
$result=@mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($result);
$name=$row['name'];
$position=$row['position'];
$sql="SELECT * FROM hdd_teachers_status WHERE tid='$id' AND time >= '$start' AND time <= '$stop' ORDER BY time DESC";
$result=@mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_array($result))
{
	$time=$row['time'];
	$content[]=array(
		'status' => urlencode($row['status']),
		'time' => $time
	);
}
if(!$content)
{
	$content='';
}
$data=array(
	'name' => urlencode($name),
	'position' => urlencode($position),
	'content' => $content
);
$json=json_encode($data);
echo urldecode($json);
?>