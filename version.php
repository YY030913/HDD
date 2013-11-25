<?php
include "./config/config.php";
$sql="SELECT * FROM hdd_update_log ORDER BY time DESC";
$_result=@mysql_query($sql) or die;
$_row=mysql_fetch_array($result);
echo $_row['version'];
?>