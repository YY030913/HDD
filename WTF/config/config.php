<?php
//数据库设置
$_ip='localhost';
$_user='root';
$_pass="zyb940708";
$_dbname="hdd_is_sb";
$_charset="utf8";

//后台密码设置
$_password="Xgzx1121";

//数据库连接参数，不要动！（debug 请把注释去掉）
$_conn=mysql_connect($_ip,$_user,$_pass);// or die('不能连接服务器'.mysql_error());  
mysql_select_db("$_dbname",$_conn);// or die("数据库访问错误".mysql_error());  
mysql_query("SET NAMES ".$_charset);// or die("数据库查询错误".mysql_error());
?>