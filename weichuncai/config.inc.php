<?php

/* ---------- 用户配置 START ----------- */
#数据库配置
$db_data = array(
'host'=>'localhost',	#主机
'dbname'=>'hdd_is_sb',	#数据库名称，假如你的数据库是database222，那么直接把这里的phpcms_v9改成database222即可
'username'=>'root',	#用户名，把root改成你的数据库用户名
'password'=>'zyb940708',	#库密码
);


#基础配置
$weichuncai_base_data = array(
#网站根目录地址(最后带/），
#假如你的站点地址是http://www.abc.com，直接将下面的http://localhost/phpcmsv9/替换成http://www.abc.com即可
'site_path'		=> 'http://localhost/hdd/',

#伪春菜根目录地址(最后带/)
'weichuncai_path'	=> 'http://localhost/hdd/weichuncai/',

);

/* ---------- 用户配置 END ----------- */




###############################
######以下程序不需要更改#######
###############################

$weichuncai_db = mysql_connect($db_data['host'], $db_data['username'], $db_data['password']);
mysql_select_db($db_data['dbname']);

##############################
##############################
//获得伪春菜生存时间
function get_wcc_lifetime($starttime){
	$endtime = time();
	$lifetime = $endtime-$starttime;
	$day = intval($lifetime / 86400);
	$lifetime = $lifetime % 86400;
	$hours = intval($lifetime / 3600);
	$lifetime = $lifetime % 3600;
	$minutes = intval($lifetime / 60);
	$lifetime = $lifetime % 60;
	return array('day'=>$day, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$lifetime);
}

function get_option($value) {
	global $weichuncai_db;
	if($value == 'sm-weichuncai') {
		$sql = "select * from weichuncai_table where id=1";
		$data = mysql_query($sql);
		$data = mysql_fetch_assoc($data);
		if(!$data) {
			$data['value'] = sm_init();
		}else{
			$data['value'] = unserialize($data['value']);
		}
		return $data['value'];
	}else{
		$sql = "select value from weichuncai_table where title='{$value}' limit 1";
		$data = mysql_query($sql);
		$data = mysql_fetch_assoc($data);
		if($data) {
			$data['value'] = unserialize($data['value']);
		}
	}
	return $data['value'];
}

function _e($str) {
	echo $str;
}
function __($str) {
	return $str;
}

function add_action($name, $func) {
	switch($name) {
		case 'init':
			dataToJs();
			break;
		default:
			break;
	}
}

function wp_enqueue_script($tmp) {
	return ;
}

function add_filter($a, $b) {
return;
}

function get_bloginfo($name) {
	global $weichuncai_base_data;
	switch($name) {
		case 'siteurl':
			return $weichuncai_base_data['site_path'];
			break;
		default:
			return '';
			break;
	}
}

function plugins_url($file, $weichuncai_base_data) {
	return $weichuncai_base_data['weichuncai_path'].$file;
}

function update_option($name, $value) {
	global $weichuncai_db;
	$value = serialize($value);
	if($name == 'sm-weichuncai') {
		$sql = "replace into weichuncai_table set id=1,title='', value='{$value}'";
		mysql_query($sql);
	}else{
		$sql = "select id from weichuncai_table where title='$name' limit 1";
		$r = mysql_fetch_assoc(mysql_query($sql));
		if($r) {
			$sql = "update weichuncai_table set value='{$value}' where title='{$name}' limit 1";
			mysql_query($sql);
		}else{
			$sql = "insert into weichuncai_table set title='$name', value='{$value}'";
			mysql_query($sql);
		}
	}
}


//默认的春菜设置
function sm_init(){
	global $wcc;
	$lifetime = time();
	$wcc = array(
		'notice'=>'主人暂时还没有写公告呢，这是主人第一次使用伪春菜吧',
		'adminname'=>'',
		'isnotice'=>'',
		'ques'=>array('早上好', '中午好', '下午好', '晚上好', '晚安'),
		'ans'=>array('早上好～', '中午好～', '下午好～', '晚上好～', '晚安～'),
		'lifetime'=>array(
			'rakutori'=>$lifetime,
			'neko'=>$lifetime,
			'chinese_moe'=>$lifetime,
			),
		'ccs'=>array('rakutori','neko','chinese_moe'),
		'defaultccs'=>'rakutori',
		'foods'=>array('金坷垃', '咸梅干'),
		'eatsay'=>array('吃了金坷垃，一刀能秒一万八～！', '吃咸梅干，变超人！哦耶～～～'),
	);
	update_option('sm-weichuncai', $wcc);
	return $wcc;
}




