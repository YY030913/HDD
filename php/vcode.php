<?php
session_start();
require_once "./class.vcode.php";
$_vcode = new ValidateCode();		//实例化一个对象
$_vcode->doimg();			
$_SESSION['code'] = $_vcode->getCode();//验证码保存到SESSION中
?>