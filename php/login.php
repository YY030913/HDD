<?php
session_start();
if(!$_POST['user'] || !$_POST['pass'])
{
	echo "非法访问！";
	exit;
}
require_once "../config/config.php";
if(!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/',$_POST['user']))
{
	echo "用户名只能是英文字母和数字，必须以字母开头，大于4位小于15位！";
	exit;
}
if(strlen($_POST['pass']) < 6)
{
	echo "你的密码太短了，至少6位数呢！";
	exit;
}
$user=mysql_real_escape_string(stripslashes($_POST['user']));
$pass=md5($_POST['pass']);
$sql="SELECT * FROM hdd_user WHERE user='$user'";
$result=@mysql_query($sql) or die;
if(mysql_num_rows($result))
{
	$row=mysql_fetch_array($result);
	if($row['pass'] == $pass)
	{
		$_SESSION['uid']=$row['id'];
		$_SESSION['emailverify']=$row['emailverify'];
		$_SESSION['accountverify']=$row['accountverify'];
		echo 1;
	}else{
		echo "密码错误！";
	}
}else{
	echo "用户名不存在！";
}	
?>