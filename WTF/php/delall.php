<?php
session_start();
if(!isset($_SESSION['login']))
{
	echo 0;
	exit;
}
include "../../config/config.php";

if($_GET['type'] == 'classroom')
{
	$sql="TRUNCATE TABLE hdd_classroom";
}
elseif($_GET['type'] == 'duty')
{
	$sql="TRUNCATE TABLE hdd_onduty";
}else{
	echo 0;
	exit;
}
@mysql_query($sql) or die('0');//(mysql_error());
echo 1;
?>
