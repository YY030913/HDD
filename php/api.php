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
		$uid=$row['uid'];
		$sql="SELECT * FROM hdd_user_info WHERE uid='$uid'";
		$result2=@mysql_query($sql) or die;//(mysql_error());
		if(mysql_num_rows($result2))
		{
			$row2=mysql_fetch_array($result2);
			$class=$row2['class'];
			$name=$row2['name'];
		}
		$content[]=array(
			'week' => $row['week'],
			'time' => $row['time'],
			'room' => $row['room'],
			'name' => urlencode($name),
			'class1' => urlencode($class),
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
	if(!$_SESSION['code'] || $vcode != $_SESSION['code'])
	{
		$err=3;
		$content= '验证码错误！';
	}
	else if(!$_SESSION['uid'])
	{
		$err=4;
		$content= '请登录后操作！';
	}
	else if(!$_SESSION['accountverify'])
	{
		$err=5;
		$content= '请绑定学号后操作！';
	}else{
		$uid=$_SESSION['uid'];
		$sql="SELECT * FROM hdd_user_info WHERE uid='$uid'";
		$result=@mysql_query($sql) or die;
		if(mysql_num_rows($result))
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
				$sql="INSERT INTO hdd_classroom (uid, week, time, room, content) VALUES ('$uid', '$week', '$time', '$room', '$_content')";
				@mysql_query($sql) or die;//(mysql_error());
				$err=0;
				$content='添加成功！';
			}else{
				$err=2;
				$content= '添加时间冲突了~是不是被别人抢先了呢？';
			}
		}else{
			$err=5;
			$content= '请绑定学号后操作！';
		}
	}
}
elseif($_GET['type'] == 'usercenter')
{
	$uid=$_SESSION['uid'];
	if($uid)
	{
		$sql="SELECT * FROM hdd_user WHERE id='$uid'";
		$result=@mysql_query($sql) or die;//(mysql_error());
		if(!mysql_num_rows($result))
		{
			$err='2';
			$content='用户不存在';
		}else{
			$row=mysql_fetch_array($result);
			if($row['accountverify'] == 1)
			{
				$sql="SELECT * FROM hdd_user_info WHERE uid='$uid'";
				$result=@mysql_query($sql) or die;//(mysql_error());
				$row2=mysql_fetch_array($result);
			}
			$content=array(
				'user' => $row['user'],
				'name' => urlencode($row2['name']),
				'sign' => urlencode($row2['class']),
				'avatat' => $row['avatar'],
				'email' => $row['email'],
				'emailverify' => $row['emailverify'],
				'accountverify' => $row['accountverify'],
				'reg_ip' => $row['reg_ip'],
				'time' => $row['time']
			);
			$err='0';
		}
	}else{
		$err='1';
		$content='请先登陆';
	}
}
elseif($_GET['type'] == 'msgwall')
{
	$sql="SELECT * FROM hdd_msg_wall ORDER BY time DESC";
	$result=@mysql_query($sql) or die;//(mysql_error());
	while($row=mysql_fetch_array($result))
	{
		$uid=$row['uid'];
		$sql="SELECT * FROM hdd_user_info WHERE uid='$uid'";
		$result2=@mysql_query($sql) or die;//(mysql_error());
		$row2=mysql_fetch_array($result2);
		$content[]=array(
			'content' => urlencode($row['content']),
			'name' => urlencode($row2['name']),
			'time' => $row['time']
		);
	}
}
else
{
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