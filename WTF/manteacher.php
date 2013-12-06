<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo '<script>alert("请先登录！");window.location.href="./index.php";</script>';
	exit;
}
require_once "./config/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>计算机学院学工办——添加/删除老师</title>
</head>
<body>
<h2>添加老师</h2>
<form method="POST" action="./php/add.php">
<p>老师姓名：<input type="text" name="name" /></p>
<p>老师职务：<input type="text" name="position" /></p>
<p>联系方式：<input type="text" name="mobile" /></p>
<p><input type="submit" value="提交" /></p>
<hr>
<h2>删除老师</h2>
<?php
$sql="SELECT * FROM hdd_teachers";
$result=@mysql_query($sql) or die(mysql_error());
$num=mysql_num_rows($result);
if(!$num)
{
	echo "<p>还没有添加过老师呢！</p>";
}else{
?>
<table border="1" width="600">
	<tr height="30">
		<td>姓名</td>
		<td>职务</td>
		<td>联系方式</td>
		<td>&nbsp;</td>
	</tr>
<?php
	while($row=mysql_fetch_array($result))
	{
?>
	<tr height="30">
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['position']; ?></td>
		<td><?php echo $row['mobile']; ?></td>
		<td align="center"><a href="./php/del.php?id=<?php echo $row['id']; ?>">删除</a></td>
	</tr>
<?php
	}
}
?>
</table>
</body>
</html>
