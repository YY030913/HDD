<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
session_start();
require_once "../config/config.php";
if(!$_SESSION['uid']){
	echo '请先登录';
	exit;
}
$uid=$_SESSION['uid'];
$targetFolder = '../uploads'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

$name=time().rand(1000,9999);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $targetFolder;
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	$name=$name.'.'.$fileParts['extension'];
	$targetFile = rtrim($targetPath,'/') . '/' . $name;
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','png'); // File extensions
	
	if(filesize($_FILES['Filedata']['tmp_name']) > 512*1024){
		echo '图片大小不能超过512K';
		exit;
	}else if(!in_array($fileParts['extension'],$fileTypes)){
		echo '只能上传JPEG、JPG、PNG格式的图片';
		exit;
	}else{
		move_uploaded_file($tempFile,$targetFile);
		$sql="SELECT * FROM hdd_user WHERE id='$uid'";
		$result=@mysql_query($sql) or die;
		if(mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			if (file_exists(rtrim($targetPath,'/') . '/' .$row['avatar'])){
				unlink(rtrim($targetPath,'/') . '/' .$row['avatar']);
			}
		}
		$sql="UPDATE hdd_user SET avatar = '$name' WHERE id = '$uid'";
		mysql_query($sql)or die;
		echo '1';
	}
}
?>