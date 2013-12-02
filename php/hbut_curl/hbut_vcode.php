<?php
$url=$baseurl;
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$result=curl_exec($ch);
curl_close($ch);

//echo $result;
if(!preg_match($reg,$result,$session))
{ 
	$err= "1";
	$text="获取SessionID失败！";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;
}

$url=$baseurl."/Account/GetValidateCode";
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$result=curl_exec($ch);
curl_close($ch);
$fp = fopen($jpg,'w');
fwrite($fp,$result);
fclose($fp);
?>
