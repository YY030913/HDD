<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo '<script>alert("请先登录！");window.location.href="./index.php";</script>';
	exit;
}
include "../config/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>计算机学院学工办——修改老师状态</title>
	<script src="../js/jquery/jquery-1.9.1.min.js"></script>
	<script src="./js/core.js"></script>
</head>
<body>
<h2>修改老师状态</h2>
<?php
$sql="SELECT * FROM hdd_teachers";
$result=@mysql_query($sql) or die(mysql_error());
$num=mysql_num_rows($result);
if(!$num)
{
	echo "<p>还没有添加过老师呢！</p>";
}else{
?>
<table border="1">
	<tr height="30">
		<td>姓名</td>
		<td>职务</td>
		<td>状态</td>
	</tr>
<?php
	while($row=mysql_fetch_array($result))
	{
		$tid=$row['id'];
		$sql="SELECT * FROM hdd_teachers_status WHERE tid='$tid' ORDER BY time DESC";
		$result2=@mysql_query($sql) or die;
		$row2=mysql_fetch_array($result2);
?>
	<tr height="30">
		<td width="80"><?php echo $row['name']; ?></td>
		<td width="200"><?php echo $row['position']; ?></td>
		<td width="230"><input type="text" class="status" id="<?php echo $row['id'];?>" class="status" value="<?php echo $row2['status'];?>" /><button class="btn" id="<?php echo $row['id'];?>" onclick="submit(<?php echo $row['id'];?>);">更新</button></td>
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