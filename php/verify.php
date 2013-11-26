<?php
if(strlen($_GET['code']) != 32 || !$_GET['uid'])
{
	echo '<script>alert("非法访问");</script>';
	exit;
}
require_once "../config/config.php";
$code=mysql_real_escape_string($_GET['code']);
$uid=mysql_real_escape_string($_GET['uid']);
$sql="SELECT * FROM hdd_email_verify WHERE uid='$uid'";
$result=@mysql_query($sql) or die;//(mysql_error());
if(!mysql_num_rows($result))
{
	echo '<script>alert("链接无效或已过期");</script>';
	exit;
}else{
	$row=mysql_fetch_array($result);
	$time=strtotime($row['time']);
	$now=time();
	if($time - $now > 60*60)
	{
		echo '<script>alert("链接已过期");</script>';
		exit;
	}
	if($row['code'] == $code)
	{
		$sql="UPDATE hdd_user SET verify='1' WHERE id='$uid'";
		@mysql_query($sql) or die;//(mysql_error());
		echo '<script>alert("验证成功！请回到主页并刷新页面。");</script>';
		$deadline=date("Y-m-d H:i:s",time()-60*60);
		$sql="DELETE FROM hdd_email_verify WHERE uid='$uid' OR time < '$deadline'";
		@mysql_query($sql) or die;//(mysql_error());
	}else{
		echo '<script>alert("链接无效或已过期");</script>';
	}
}
?>