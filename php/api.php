<?php
session_start();
require_once "../config/config.php";

$time=time();

if($_GET['type'] == 'teacher')
{
	$sql="SELECT * FROM hdd_teachers";
	$result=@mysql_query($sql) or die;//(mysql_error());
	while($row=mysql_fetch_array($result))
	{
		$tid=$row['id'];
		$sql="SELECT * FROM hdd_teachers_status WHERE tid='$tid' ORDER BY time DESC";
		$result2=@mysql_query($sql) or die;
		$row2=mysql_fetch_array($result2);
		$content[]=array(
			'name'=> urlencode($row['name']),
			'position' => urlencode($row['position']),
			'mobile' => $row['mobile'],
			'status' => urlencode($row2['status'])
		);
		$err=0;
	}
}
elseif($_GET['type'] == 'classroom')
{
	$sql="SELECT * FROM hdd_classroom ORDER BY week ASC, time ASC";
	$result=@mysql_query($sql) or die;//(mysql_error());
	while($row=mysql_fetch_array($result))
	{
		$content[]=array(
			'week' => $row['week'],
			'time' => $row['time'],
			'room' => $row['room'],
			'content' => urlencode($row['content']),
		);
	}
	$err=0;
}
elseif($_GET['type'] == 'onduty')
{
	$sql="SELECT * FROM hdd_onduty WHERE enabled = 1 ORDER BY time DESC";
	$result=@mysql_query($sql) or die;//(mysql_error());
	$num=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	$content=array(
		'name' => $row['name'],
		'mobile' => $row['mobile'],
		);
	$err=0;
}
elseif($_GET['type'] == 'order' && $_GET['week'] && $_GET['time'] && $_GET['room'] && $_GET['content'] && $_GET['vcode'])
{
	$vcode=$_GET['vcode'];
	if($_SESSION['code'] && $vcode == $_SESSION['code'])
	{
		$week=mysql_real_escape_string($_GET['week']);
		$time=mysql_real_escape_string($_GET['time']);
		$room=mysql_real_escape_string($_GET['room']);
		$_content=$_GET['content'];
		$sql="SELECT * FROM hdd_classroom WHERE week='$week' AND time='$time' AND room='$room'";
		$result=@mysql_query($sql) or die;//(mysql_error());
		$num=mysql_num_rows($result);
		if(!$num)
		{
			$sql="INSERT INTO hdd_classroom (week, time, room, content) VALUES ('$week', '$time', '$room', '$_content')";
			@mysql_query($sql) or die;//(mysql_error());
			$err=0;
			$content='添加成功！';
		}else{
			$err=2;
			$content= '添加时间冲突了~是不是被别人抢先了呢？';
		}
	}else{
		$err=3;
		$content= '验证码错误！';
	}
}
elseif($_GET['type'] == 'usercenter')
{
	$uid=$_SESSION['uid'];
	if($uid)
	{
		$sql="SELECT * FROM hdd_user WHERE id='$uid'";
		$result=@mysql_query($sql) or die;//(mysql_error());
		$row=mysql_fetch_array($result);
		$content=array(
			'user' => $row['user'],
			'name' => $row['name'],
			'sign' => $row['sign'],
			'avatat' => $row['avatar'],
			'email' => $row['email'],
			'verify' => $row['verify'],
			'reg_ip' => $row['reg_ip'],
			'time' => $row['time']
		);
		$err='0';
	}else{
		$err='1';
		$content='请先登陆';
	}
}else{
	$content = urlencode('信息不全');
	$err = '1';
}
$data=array(
	'content' => $content,
	'error' => $err,
	'timestamp' => $time
	);	
unset($_SESSION['code']);
$json=json_encode($data);
echo urldecode($json);
?>