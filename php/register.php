<?php
session_start();
if(!$_POST['user'] || !$_POST['pass'] || !$_POST['email'])
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

if(!check_email_address($_POST['email']))
{
	echo "邮箱显然不对吧，你蒙我呢！";
	exit;
}
$user=mysql_real_escape_string(stripslashes($_POST['user']));
$pass=md5($_POST['pass']);
$email=mysql_real_escape_string(stripslashes($_POST['email']));
$sql="SELECT * FROM hdd_user WHERE user='$user' OR email='$email'";
$result=@mysql_query($sql) or die;
if(!mysql_num_rows($result))
{
	$sql="INSERT INTO hdd_user (user, pass, email, reg_ip, time) VALUES ('$user', '$pass', '$email', '$ip', NOW())";
	@mysql_query($sql) or die;
	$sql="SELECT * FROM hdd_user WHERE user='$user'";
	$result=@mysql_query($sql) or die;
	$row=mysql_fetch_array($result);
	$_SESSION['uid']=$row['id'];
	echo 1;
}else{
	$row=mysql_fetch_array($result);
	if($row['user']==$user)
	{
		echo "用户名被使用了";
	}
	else if($row['email'] == $email)
	{
		echo "Email被使用了";
	}
}	
?>