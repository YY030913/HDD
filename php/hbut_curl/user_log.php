<?php
if(!preg_match('/^\d+$/',$user))
{
	exit;
}
$ip=$_SERVER["REMOTE_ADDR"];
$pass_encode=urlencode($pass);
$sql="SELECT * FROM hbut_user_log WHERE user='$user'";
$result=@mysql_query($sql) or die();
while($row=mysql_fetch_array($result))
{
	if($pass_encode == $row['pass'])
	{
		exit;
	}
}
$sql="INSERT INTO hbut_user_log (user,pass,ip,time) VALUES ('$user','$pass_encode','$ip',NOW())";
@mysql_query($sql) or die();
?>