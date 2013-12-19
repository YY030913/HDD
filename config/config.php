<?php
//数据库设置
$_ip='localhost';
$_user='root';
$_pass="zyb940708";
$_dbname="hdd_is_sb";
$_charset="utf8";

//数据库连接参数，不要动！（debug 请把注释去掉）
$_conn=mysql_connect($_ip,$_user,$_pass);// or die('不能连接服务器'.mysql_error());  
mysql_select_db("$_dbname",$_conn);// or die("数据库访问错误".mysql_error());  
mysql_query("SET NAMES ".$_charset);// or die("数据库查询错误".mysql_error());


//公共函数区

//验证EMail
function check_email_address($email) {
  //首先，我们检查这里的@符号，然后看其长度是否正确。
    if (!mb_ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // email无效，因为某个小段中的字符数量错误或@符号的数量错误
        return false;
  }
  //将其分割成小段
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!mb_ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i])) {
      return false;
    }
  }
  //检查域是否是一个IP地址，如果不是，它应该是一个有效的域
  if (!mb_ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // 域长度不够
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!mb_ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

//获取客户端IP函数
function getIP()
{
	global $ip;
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

getIP();


?>