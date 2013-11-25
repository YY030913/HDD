<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo '<script>alert("请先登录！");window.location.href="./index.php";</script>';
	exit;
}
include "../config/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 tdansitional//EN" "http://www.w3.org/td/xhtml1/DTD/xhtml1-tdansitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="./css/button.css" />
	<script src="../js/jquery/jquery-1.9.1.min.js"></script>
	<script src="./js/core.js"></script>
	
	<title>计算机学院学工办——值班人员管理</title>
</head>
<body>
<h2>值班人员管理</h2>
<form method="POST" action="./php/onduty.php">
<p>姓名：<input type="text" name="name" /></p>
<p>联系电话：<input type="text" name="mobile" /></p>
<p><input type="submit" value="提交" /></p>
</form>
<hr>
<?php
$sql="SELECT * FROM hdd_onduty WHERE enabled = 1";
$result=@mysql_query($sql) or die(mysql_error());
$num=mysql_num_rows($result);
if($num)
{
	$row=mysql_fetch_array($result);
	echo '<p>当前值班人员：'.$row['name'].'</p><p>联系方式：'.$row['mobile'].'</p><p><a href="./php/onduty.php?type=over">下班了~</a></p>';
}else{
	echo '<p>当前无人值班</p>';
}
?>

<hr>
<h2>历史值班人员</h2>
<p><button class="warning" id="duty">清空记录</button></p>
<?php
$sql="SELECT * FROM hdd_onduty ORDER BY time DESC";
$result=@mysql_query($sql) or die(mysql_error());
$num=mysql_num_rows($result);
if(!$num)
{
	echo "<p>还没有过值班人员呢！</p>";
}else{
?>
<table border="1" width="400">
	<tr height="30">
		<td>姓名</td>
		<td>电话</td>
		<td>登记时间</td>
	</tr>
<?php
	while($row=mysql_fetch_array($result))
	{
?>
	<tr height="30">
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['mobile']; ?></td>
		<td><?php echo $row['time']; ?></td>
	</tr>
<?php
	}
}
?>
</table>
<p><a href="../index.php">回到主页</a></p>
<p><a href="./index.php">回到后台主页</a></p>
</body>
</html>