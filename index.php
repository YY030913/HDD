<?php
header("Cache-Control: no-cache, must-revalidate");
require_once "./config/config.php";
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

<?php
if(strpos($_SERVER['HTTP_REFERER'],'www.benbentime.com'))
{
	echo '<script>var key=1;</script>';
}
?>
	
	<script src="js/anti_piracy.js"></script>
	<script src="js/onload.js"></script>
	<script src="js/index.js"></script>
	<script src="js/usercenter.js"></script>
	
</head>
<body>
	<div class="nav-bar">
		<p>计算机学院学工办自助平台</p>
		<div class="version"><a href="./changelog.php"><?php require_once "version.php"; ?></a></p></div>
	</div>
	<div class="widget" id="widget"><span><img src="./images/arrow.png" height="50px"></img></span></div>
	<div class="userCenter" id="userCenter">
		<div class="info">
			<div class="name">
				<p id="name">未登录</p>
				<p id="sign" style="font-size:15px;">预览版，纯观赏，功能无效。。。</p>
			</div>
			<div class="avatar">
				<div class="avatar_mask"></div>
				<img src="./images/noimg.jpg"></img>
			</div>
		</div>
		<div class="options">
			<ul>
				<li><a href="#" class="optionsBtn selected" rel="login">登陆</a></li>
				<li><a href="#" class="optionsBtn" rel="register">注册</a></li>
			</ul>
		</div>
		<div class="optionContent">
			<div id="pageLogin">
				<p><input type="text" id="logUsername" placeholder="请输入用户名" /></p>
				<p><input type="password" id="logPassword" placeholder="请输入密码" /></p>
				<p><button id="reset" class="reset">重置</button><button id="login" class="login">登陆</button></p>
			</div>
			<div id="pageReg">
				<p><input type="text" id="regUsername" placeholder="请输入用户名" /></p>
				<p><input type="password" id="regPassword" placeholder="请输入密码" /></p>
				<p><input type="password" id="regPassword_repeat" placeholder="请再次输入密码" /></p>
				<p><input type="text" id="regEmail" placeholder="请输入邮箱" /></p>
				<p><button id="reset" class="reset">重置</button><button id="register" class="register">注册</button></p>
			</div>
		</div>
	</div>
	<script>$('input').placeholder();</script>
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
