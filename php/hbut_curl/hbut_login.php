<?php
$url=$baseurl."/Account/LogOn";
$data="isRemember=1&Role=Student&UserName=".$user."&Password=".$pass."&ValidateCode=".$vcode;
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_POST, 1);
$result=curl_exec($ch);
curl_close($ch);

$html=str_get_html($result);
foreach($html->find('span') as $e)
{
	if($e->innertext == '验证码错误')
	{
		$err= "2";
		$text="验证码最讨厌啦！拜托重新查询下~";
		$json_data=array(
			'error'=>$err,
			'text'=>urlencode($text)
			);
		$json=json_encode($json_data);
		echo urldecode($json);
		exit;
	}
	if($e->innertext == '账户或密码错误')
	{
		$err= "1";
		$text="学号或密码错误！";
		$json_data=array(
			'error'=>$err,
			'text'=>urlencode($text)
			);
		$json=json_encode($json_data);
		echo urldecode($json);
		exit;
	}
}
$html->clear();
?>