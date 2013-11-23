<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>		
<html>		
<head>	
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable = no">
	<title>计算机学院学工办</title>		
	<link rel="stylesheet" href="./css/jquery.mobile-1.3.2.min.css" />
	<link rel="stylesheet" href="./css/jquery.mobile.theme-1.3.2.min.css" />
	<link rel="stylesheet" href="./css/index.css" />
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery.mobile-1.3.2.min.js"></script>
	<script src="./js/core.js"></script>
</head>		
<body>		
<section id="page1" data-role="page">
	<header id="home" data-role="header" data-theme="b" >
		<h1>计算机学院学工办</h1>
	</header>
	<div data-role="content" class="content">
		<a href="#onduty" data-role="button" id="btnOnduty" data-transition="slide">值班人员查询</a>
		<a href="#teacher" data-role="button" id="btnTeacher" data-transition="slide">老师去向查询</a>
		<a href="#classroom" data-role="button" id="btnClassroom" data-transition="slide">办公室借用情况</a>
		<a href="#order" data-role="button" id="btnOrder" data-transition="slide">办公室网上预定</a>
		<a href="#extend" data-role="button" id="btnExtend" data-transition="slide">拓展服务</a>
	</div>
	<footer data-role="footer" data-position="fixed"><h1>©2013 ITJesse</h1></footer>
</section>

<section id="onduty" data-role="page" data-add-back-btn="true" data-back-btn-text="返回">
	<header data-role="header"	data-theme="b" >
		<h1>值班人员查询</h1>
		
	</header>
	<div data-role="content" class="content" id="dataOnduty" data-backbtn="true">
		<p>请返回主页并从主页进入</p>
	</div>
	<footer data-role="footer" data-position="fixed"><h1>©2013 ITJesse</h1></footer>
</section>

<section id="teacher" data-role="page" data-add-back-btn="true" data-back-btn-text="返回">
	<header data-role="header"	data-theme="b" >
		<h1>老师去向查询</h1>
	</header>
	<div data-role="content" class="content" id="dataTeacher" data-backbtn="true">
		<p>请返回主页并从主页进入</p>
	</div>
	<footer data-role="footer" data-position="fixed"><h1>©2013 ITJesse</h1></footer>
</section>

<section id="classroom" data-role="page" data-add-back-btn="true" data-back-btn-text="返回">
	<header data-role="header"	data-theme="b" >
		<h1>办公室借用情况</h1>
	</header>
	<div data-role="content" class="content" id="dataClassroom" data-backbtn="true">
		<p>请返回主页并从主页进入</p>
	</div>
	<footer data-role="footer" data-position="fixed"><h1>©2013 ITJesse</h1></footer>
</section>

<section id="order" data-role="page" data-add-back-btn="true" data-back-btn-text="返回">
	<header data-role="header"	data-theme="b" >
		<h1>办公室网上预定</h1>
	</header>
	<div data-role="content" class="content" id="dataOrder" data-backbtn="true">
		<p>开发中</p>
	</div>
	<footer data-role="footer" data-position="fixed"><h1>©2013 ITJesse</h1></footer>
</section>

<section id="extend" data-role="page" data-add-back-btn="true" data-back-btn-text="返回">
	<header data-role="header"	data-theme="b" >
		<h1>拓展服务</h1>
		
	</header>
	<div data-role="content" class="content" id="dataExtend" data-backbtn="true">
		<h2><a data-role="button" id="btnOnduty" href="http://pan.baidu.com/s/169G9e">湖工大查分客户端V2.1.1下载</a></h2>
		<h2><a data-role="button" id="btnOnduty" href="http://blog.sina.com.cn/u/2450629767">学工助理博客</a></h2>
		<h2><a data-role="button" id="btnOnduty" href="http://www.benbentime.com">计算机学院学生工作网</a></h2>
		<h2><a data-role="button" id="btnOnduty" href="http://blog.sina.com.cn/hbut2013">13级年级博客</a></h2>
		<h2><a data-role="button" id="btnOnduty" href="http://blog.sina.com.cn/u/2449956125">12级年级博客</a></h2>
		<h2><a data-role="button" id="btnOnduty" href="http://blog.sina.com.cn/u/2449939115">11级年级博客</a></h2>
		<h2><a data-role="button" id="btnOnduty" href="http://blog.sina.com.cn/u/2450656273">10级年级博客</a></h2>
	</div>
	<footer data-role="footer" data-position="fixed"><h1>©2013 ITJesse</h1></footer>
</section>
</body>
 
</body>	
</html>	