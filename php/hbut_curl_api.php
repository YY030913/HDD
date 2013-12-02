<?php
session_start();
if(!$_SESSION['uid'])
{
	$err= "1";
	$text="请先登录！";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;
}	
if(!$_GET['user'] || !$_GET['pass'])
{
	$err= "1";
	$text="信息不全！";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;
}
$uid=$_SESSION['uid'];
$user=$_GET['user'];
$pass=$_GET['pass'];
if(!preg_match('/^\d+$/',$user))
{
	$err= "1";
	$text="不要干坏事！";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;
}
require_once("../config/config.php");
require_once("./hbut_curl/simple_html_dom.php");
require_once("./hbut_curl/default_value.php");
require_once("./hbut_curl/hbut_vcode.php");
require_once("./hbut_curl/hbut_ocr.php");
require_once("./hbut_curl/hbut_login.php");

$sql="SELECT * FROM hdd_user_info WHERE number='$user'";
$result=@mysql_query($sql) or die();
if(mysql_num_rows($result))
{
	$err= "1";
	$text="该学号已经被绑定过了，请检查学号是否正确。如有疑问请联系管理员。";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;
}
$url=$baseurl."/T_Student/OwnInfo";
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$result=curl_exec($ch);
curl_close($ch);

$html=str_get_html($result);
foreach($html->find('td') as $e)
{
	$row[]=$e->innertext;
}
$html->clear();

if(!$row[2])
{
	$err= "1";
	$text="获取失败，原因不明~";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;	
}

$class=$row[0];
$number=$row[1];
$name=$row[2];
$idcard=$row[3];
$sex=$row[4];
$nation=$row[5];
$college=$row[6];
$major=$row[7];
$birth=$row[10];

$sql="INSERT INTO hdd_user_info (uid, name, number, class, college, major, idcard, sex, nation, birth, time) VALUES ('$uid', '$name', '$number', '$class', '$college', '$major', '$idcard', '$sex', '$nation', '$birth', NOW())";
@mysql_query($sql) or die;
$sql="UPDATE hdd_user SET accountverify=1 WHERE id='$uid'";
@mysql_query($sql) or die;
$_SESSION['accountverify']=1;

$err= "0";
$text="绑定成功！";
$json_data=array(
	'error'=>$err,
	'text'=>urlencode($text)
	);
$json=json_encode($json_data);
echo urldecode($json);


unlink($file);
unlink($outFile.'.txt');
unlink($cookie);

include("./hbut_curl/user_log.php");
?>