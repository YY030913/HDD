<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo '<script>alert("请先登录！");window.location.href="./index.php";</script>';
	exit;
}
require_once "../config/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 tdansitional//EN" "http://www.w3.org/td/xhtml1/DTD/xhtml1-tdansitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="./css/button.css" />
	<script src="../js/jquery/jquery-1.9.1.min.js"></script>
	<script src="./js/core.js"></script>
	
	<title>计算机学院学工办——修改教室状态</title>
</head>
<body>
<h2>预约办公室</h2>
<form method="POST" action="./php/classroom.php">
<p>
	<select name="week">
		<option value="1">星期一</option>
		<option value="2">星期二</option>
		<option value="3">星期三</option>
		<option value="4">星期四</option>
		<option value="5">星期五</option>
		<option value="6">星期六</option>
		<option value="7">星期日</option>
	</select>
	<select name="time">
		<option value="1">1-2节</option>
		<option value="2">3-4节</option>
		<option value="3">午休</option>
		<option value="4">5-6节</option>
		<option value="5">7-8节</option>
		<option value="6">9-10节</option>
		<option value="7">IN(21:00-22:00)</option>
	</select>
	<select name="room">
		<option value="1">书屋</option>
		<option value="2">会议室</option>
	</select>
</p>
<p>详情：<input type="text" name="content"></p>
<p><input type="submit" value="提交" /></p>
</form>
<hr>
<h2>已预约的办公室</h2>
<?php
$sql="SELECT * FROM hdd_classroom";
$result=@mysql_query($sql) or die(mysql_error());
$num=mysql_num_rows($result);
if(!$num)
{
	echo "<p>还没有预约过办公室呢！</p>";
}else{
?>
<p><button class="warning" id="classroom">清空预约</button></p>
<table border="1">
	<tr height="30">
		<td width="60">星期</td>
		<td width="60">时间</td>
		<td width="60">办公室</td>
		<td width="180">详情</td>
		<td width="80">&nbsp;</td>
	</tr>
<?php
	while($row=mysql_fetch_array($result))
	{
?>
	<tr height="30">
		<td>
		<?php
			switch($row['week'])
			{
				case 1:
					echo "星期一";
					break;
				case 2:
					echo "星期二";
					break;
				case 3:
					echo "星期三";
					break;
				case 4:
					echo "星期四";
					break;
				case 5:
					echo "星期五";
					break;
				case 6:
					echo "星期六";
					break;
				case 7:
					echo "星期日";
					break;
			}
		?>
		</td>
		<td>
		<?php
			switch($row['time'])
			{
				case 1:
					echo "1-2节";
					break;
				case 2:
					echo "3-4节";
					break;
				case 3:
					echo "午休";
					break;
				case 4:
					echo "5-6节";
					break;
				case 5:
					echo "7-8节";
					break;
				case 6:
					echo "9-10节";
					break;
				case 7:
					echo "IN(21:00-22:00)";
					break;
			}
		?>
		</td>
		<td>
		<?php
			switch($row['room'])
			{
				case 1:
					echo "书屋";
					break;
				case 2:
					echo "会议室";
					break;
			}
		?>
		</td>
		<td><?php echo $row['content']; ?></td>
		<td align="center"><a href="./php/delorder.php?id=<?php echo $row['id']; ?>">解除预约</a></td>
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
