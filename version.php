<?php
include "./config/config.php";
$sql="SELECT * FROM hdd_update_log ORDER BY time DESC";
$result=@mysql_query($sql) or die;
$row=mysql_fetch_array($result);
echo $row['version'];
?>