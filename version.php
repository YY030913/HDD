<?php
require_once "./config/config.php";
$sql="SELECT * FROM hdd_update_log ORDER BY time DESC";
$ver_result=@mysql_query($sql) or die();
$ver_row=mysql_fetch_array($ver_result);
echo $ver_row['version'];
?>