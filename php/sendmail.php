<?php
session_start();
if(!$_SESSION['uid'])
{
	echo '请先登陆';
	exit;
}
require_once "../config/config.php";
$uid=$_SESSION['uid'];
$sql="SELECT * FROM hdd_user WHERE id='$uid'";
$result=@mysql_query($sql) or die;//(mysql_error());
if(!mysql_num_rows($result))
{
	echo '用户不存在';
	exit;
}else{
	$row=mysql_fetch_array($result);
	$email=$row['email'];
	$verify=$row['verify'];
	$user=$row['user'];
}
if($verify=='1')
{
	echo '你的邮箱已经验证过了';
	exit;
}

$now=time();
$code=md5($now.rand(1000,9999));
$sql="SELECT * FROM hdd_email_verify WHERE uid='$uid'";
$result=@mysql_query($sql) or die;//(mysql_error());
if(mysql_num_rows($result))
{
	$row=mysql_fetch_array($result);
	$time=$row['time'];
	
	if($now-$time < 60)
	{
		echo '你需要等待60s才能再次发送验证邮件。';
		exit;
	}else{
		$sql="UPDATE hdd_email_verify SET code='$code', time=NOW() WHERE uid='$uid'";
		@mysql_query($sql) or die;//(mysql_error());
	}
}else{
	$sql="INSERT INTO hdd_email_verify (uid, code, time) VALUES ('$uid', '$code', NOW())";
	@mysql_query($sql) or die;//(mysql_error());
}


$content  = '<p>'.$user.'你好！</p>';
$content .= '<p>这是你的邮箱验证链接，链接有效期为1小时。</p>';
$content .= '<p>直接点击即可验证邮箱。如果无法点击，请尝试复制到地址栏访问。</p>';
$content .= '<p><a href="http://hs.itjesse.cn/php/verify.php?uid='.$uid.'&code='.$code.'">http://hs.itjesse.cn/php/verify.php?uid='.$uid.'&code='.$code.'</a></p>';
$content .= '<hr>';
$content .= '<p>本邮件为系统自动发送，请不要回复本邮件。联系我请发送邮件到jesse@itjesse.cn</p>';



require_once('class.phpmailer.php');
require_once("class.smtp.php");

$mail  = new PHPMailer(); 

$mail->CharSet    ="UTF-8";                 //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
$mail->IsSMTP();                            // 设定使用SMTP服务
$mail->SMTPAuth   = true;                   // 启用 SMTP 验证功能
$mail->SMTPSecure = "ssl";                  // SMTP 安全协议
$mail->Host       = "smtp.qq.com";       // SMTP 服务器
$mail->Port       = 465;                    // SMTP服务器的端口号
$mail->Username   = "webmaster@itjesse.cn";  // SMTP服务器用户名
$mail->Password   = "cs940708";        // SMTP服务器密码
$mail->SetFrom('webmaster@itjesse.cn', 'webmaster');    // 设置发件人地址和名称
$mail->Subject    = '验证你的邮箱——学工办自助平台';                     // 设置邮件标题
$mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端"; 
                                            // 可选项，向下兼容考虑
$mail->MsgHTML($content);                         // 设置邮件内容
$mail->AddAddress($email, "网站自动发送");
//$mail->AddAddress('info@itjesse.cn', "网站自动发送");
if(!$mail->Send()) {
    echo "发送失败：" . $mail->ErrorInfo;
} else {
    echo '1';
}
?>