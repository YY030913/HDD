<?php
include "./config/config.php";
$sql="SELECT * FROM hdd_update_log ORDER BY time DESC";
$result=@mysql_query($sql) or die;
$row=mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>更新日志</title>
</head>

<body>
<h1>学工办自助平台更新日志</h1>
<h2>当前版本：<?php echo $row['version']; ?></h2>
<p>更新日期：<?php echo $row['time']; ?></p>
<p>更新内容：</p>
<p><?php echo $row['content']; ?></p>
<hr>
<h2>历史更新</h2>
<?php
while($row=mysql_fetch_array($result))
{
?>
<h2>更新版本：<?php echo $row['version']; ?></h2>
<p>更新日期：<?php echo $row['time']; ?></p>
<p>更新内容：</p>
<p><?php echo $row['content']; ?></p>
<hr>
<?php
}
?>