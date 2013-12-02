<?php
session_start();
if(!$_GET['type'])
{
	exit;
}
else if($_GET['type'] == 'email')
{
	if($_SESSION['emailverify'] == '1')
	{
		echo 1;
	}else{
		echo 0;
	}
}
else if($_GET['type'] == 'account')
{
	if($_SESSION['accountverify'] == '1')
	{
		echo 1;
	}else{
		echo 0;
	}
}
?>