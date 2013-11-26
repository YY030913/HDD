<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>计算机学院学工办——后台首页</title>
</head>
<body>
<?php
require_once "./config/config.php";
if(!$_POST['password'] && !$_SESSION['login'])
{
?>
<h2>请登录</h2>
<form method="POST" action="index.php">
<p>请输入密码：<input type="password" name="password" /></p>
<p><input type="submit" value="登录" /></p>
</form>
<?php
}
if(isset($_POST['password']) && $_POST['password'] != $_password)
{
	echo '<script>alert("密码不正确！");window.location.href="./index.php";</script>';
}
if((isset($_POST['password']) && $_POST['password'] == $_password) || isset($_SESSION['login']))
{
	$_SESSION['login'] = '1';
?>
<h2>后台首页</h2>
<p><a href="./manteacher.php">添加/删除老师</a></p>
<p><a href="./teastatus.php">修改老师状态</a></p>
<p><a href="./classstatus.php">修改办公室状态</a></p>
<p><a href="./onduty.php">值班人员管理</a></p>
<p><a href="./teacherhis.php">老师历史状态</a></p>
<?php
}
?>
<p><a href="../index.php">回到主页</a></p>
</body>
</html>
