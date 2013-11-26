<?php
//数据库设置
$_ip='localhost';
$_user='root';
$_pass="zyb940708";
$_dbname="hdd_is_sb";
$_charset="utf8";

//后台密码设置
$_password="zyb940708";

//访问频率限制，单位秒
$_keep=5;
$_alert="你访问太快了，休息一下吧！";

//数据库连接参数，不要动！（debug 请把注释去掉）
$_conn=mysql_connect($_ip,$_user,$_pass);// or die('不能连接服务器'.mysql_error());  
mysql_select_db("$_dbname",$_conn);// or die("数据库访问错误".mysql_error());  
mysql_query("SET NAMES ".$_charset);// or die("数据库查询错误".mysql_error());

//获取客户端IP函数
function getIP()
{
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else 
		$ip = "Unknow";
		
	return $ip;
}

//访问频率限制
$client_ip=getIP();
$_sql="SELECT * FROM hdd_ip_log WHERE ip='$client_ip'";
$_result=@mysql_query($_sql) or die;
if(mysql_num_rows($_result))
{
	$_row=mysql_fetch_array($_result);
	$_time=strtotime($_row['time']);
	$_now=time();
	if($_now-$_time<$_keep)
	{
		echo $_alert;
		exit;
	}
}else{
	$_sql="INSERT INTO hdd_ip_log (ip, time) VALUES ('$client_ip', NOW())";
	@mysql_query($_sql) or die;
}





?>