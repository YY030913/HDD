<?php
header("Cache-Control: no-cache, must-revalidate");
include "./config/config.php";
$sql="SELECT * FROM hdd_onduty WHERE enabled = 1 ORDER BY time DESC";
$result=@mysql_query($sql) or die(mysql_error());
$num=mysql_num_rows($result);
$row=mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>计算机学院学工办</title>

	<link rel="stylesheet" href="css/index.css">

	<script src="js/uaredirect.js"></script>
	<script type="text/javascript">uaredirect("http://hs.itjesse.cn/mobile");</script>
	<script src="js/jquery/jquery-1.9.1.min.js"></script>
	<script src="js/html5placeholder.jquery.js"></script>
	<script src="js/layer.min.js"></script>
	<script src="js/iealert.min.js"></script>
	
	<link rel="stylesheet" href="js/iealert/style.css">
	
	<script src="js/index.js"></script>
</head>

<body>
	<div class="nav-bar">
		<p>湖北工业大学计算机学院学工办</p>
	</div>
	<div class="user">
	</div>
	<div class="menu">
		<ul>
			<li><a class="list" rel="onduty" href="#" onclick="dutyUpdate();">值班人员</a></li>
			<li><a class="list" rel="teacher" href="#" onclick="teaUpdate();">老师去向</a></li>
			<li><a class="list" rel="order" href="#" onclick="classUpdate();">办公室网上预定</a></li>
			<li><a class="list" rel="extend" href="#" onclick="extend();">拓展服务</a></li>
		</ul>
	</div>
	<div class="content">
		<div class="welcome">
			<h2>欢迎使用计算机学院学工办管理平台</h2>
			<?php
			if(!$num)
			{
				echo "<p>这个时间还没有值班人员呢！</p>";
			}else{
				echo "<p>现在值班人员：".$row['name'];
				echo "<p>联系电话：".$row['mobile'];
			}
			?>
		</div>
	</div>
	<div class="order"></div>
	<div class="footer"><p><a href="http://www.itjesse.cn/">Copyright&nbsp;&nbsp;&nbsp;&nbsp;ITJesse & Hs</a></div>
</body>
</html>
