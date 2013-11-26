<?php
session_start();
$uid=$_SESSION['uid'];
if($uid)
{
	echo 1;
}else{
	echo 0;
}
?>