<?php 
/*
 * Plugin Name: weichuncai(WP伪春菜)
 * Plugin URI: http://www.lmyoaoa.com/inn/?p=3134
 * Description: 萌化。移植自wordpress博客插件
		临时移植的东西，所以代码如何就无视过去吧
 * Version: 1.3.1
 * Author: lmyoaoa(油饼小明猪)
 * Author URI: http://www.lmyoaoa.com
 * date: 2012-04-14
 */

$weichuncai_path = substr(__FILE__, 0, -17);

require $weichuncai_path.'config.inc.php';

$wcc = get_option('sm-weichuncai');

//获得春菜的详细数据与js交互
function dataToJs(){
	global $wcc;
	if($_GET['a'] == 'getdata'){
		if( preg_match('/userdefccs_/i', $wcc['defaultccs']) )
			$key = str_replace( 'userdefccs_', '', $wcc['defaultccs']);
		else
			$key = $wcc['defaultccs'];
		
		$lifetime = get_wcc_lifetime($wcc['lifetime'][$key]);
		$wcc['showlifetime'] = '我已经与主人 '.$wcc["adminname"].' 一起生存了 <font color="red">'.$lifetime["day"].'</font> 天 <font color="red">'.$lifetime["hours"].'</font> 小时 <font color="red">'.$lifetime["minutes"].'</font> 分钟 <font color="red">'.$lifetime["seconds"].'</font> 秒的快乐时光啦～*^_^*';
		$wcc['notice'] = stripslashes($wcc['notice']);

/*这段代码for gbk
function convertData($data, $from='gbk', $to='utf-8') {
	if(is_array($data)) {
		foreach($data as $key=>$value) {
			if(is_array($value)) {
				foreach($value as $k => $v) {
					$data[$key][$k] = convertData($v, $from, $to);
				}
			} else {
				$data[$key] = convertData($value, $from, $to);
			}
		}
		return $data;
	} else {
		return mb_convert_encoding($data, $to, $from);
	}
}
$wcc = convertData($wcc);
*/


		$wcc = json_encode($wcc);
		echo $wcc;
		die();
	}
}
add_action('init', 'dataToJs');

//获得春菜
function get_chuncai($weichuncai_base_data, $weichuncai_path){
	echo '<link rel="stylesheet" type="text/css" href="'.$weichuncai_base_data['weichuncai_path'].'css/style.css">';
	echo '<script>';
	$wcc = get_option('sm-weichuncai');
	$talkself_user = get_option('sm-wcc-talkself_user');
	if($wcc == ''){
		sm_init();
		$wcc = get_option('sm-weichuncai');
	}

	if( preg_match('/userdefccs_/i', $wcc['defaultccs']) ) {
		$key = str_replace( 'userdefccs_', '', $wcc['defaultccs']);
		$fpath = $wcc['userdefccs'][$key]['face'];
		$fpath1 = $fpath[0];
		$fpath2 = $fpath[1] ? $fpath[1] : $fpath1;
		$fpath3 = $fpath[2] ? $fpath[2] : $fpath1;
	}else {
		$path = $weichuncai_path.'skin/'.$wcc[defaultccs].'/';
		$fpath1 = plugins_url('skin/'.$wcc[defaultccs].'/face1.gif', $weichuncai_base_data);
		$fpath2 = plugins_url('skin/'.$wcc[defaultccs].'/face2.gif', $weichuncai_base_data);
		$fpath3 = plugins_url('skin/'.$wcc[defaultccs].'/face3.gif', $weichuncai_base_data);

		$fpath2 = file_exists($path.'face2.gif') ? $fpath2 : $fpath1;
		$fpath3 = file_exists($path.'face3.gif') ? $fpath3 : $fpath1;
	}

	$size = getimagesize($fpath1);

	$notice_str = '&nbsp;&nbsp;'.$wcc['notice'].'<br />';
	echo 'var _site_path = "'.$weichuncai_base_data['site_path'].'";';
	echo 'var _weichuncai_path = "'.$weichuncai_base_data['weichuncai_path'].'";';
	echo "var imagewidth = '{$size[0]}';";
	echo "var imageheight = '{$size[1]}';";	
	echo "if(!$){var $=null;} var smjq_tmp = $;";
	echo '</script>';
	echo '<script src="'.$weichuncai_base_data['weichuncai_path'].'js/jquery.js"></script>';
	echo '<script src="'.$weichuncai_base_data['weichuncai_path'].'js/common.js"></script>';
	echo '<script>$=smjq_tmp;createFace("'.$fpath1.'", "'.$fpath2.'", "'.$fpath3.'");</script>';
	echo '<script>';
	//自定义自言自语
	if(!empty($talkself_user) && is_array($talkself_user)) {
		$talkself_user_str = 'var talkself_user = [ ';
		$dot = '';
		foreach($talkself_user['says'] as $k=>$v) {
			$tmpf = $talkself_user['face'][$k] ? $talkself_user['face'][$k] : 1;
			$talkself_user_str .= $dot.'["'.$v.'", "'.$tmpf.'"]';
			$dot = ',';
		}
		$talkself_user_str .= ' ];';
		echo $talkself_user_str;
		echo 'var talkself_arr = talkself_arr.concat(talkself_user);';
	}
	echo '</script>';
}

#if(empty($_GET)) {
	get_chuncai($weichuncai_base_data, $weichuncai_path);
#}

wp_enqueue_script('jquery');
add_filter('wp_head', 'get_chuncai');
add_action('admin_menu', 'chuncaiadminPage');


function chuncaiadminPage(){
	$wcc = get_option('sm-weichuncai');
	if($wcc == ''){
		sm_init();
		$wcc = get_option('sm-weichuncai');
	}
	if(function_exists('add_options_page')){
		add_options_page(__('伪春菜控制面板', "weichuncai"), __('伪春菜控制面板', "weichuncai"), 9, 'weichuncai/sm-options.php');
	}
}


function get_pic_path($name){
	$fpath1 = dirname(__FILE__).'/skin/'.$name.'/face1.gif';
	$fpath2 = dirname(__FILE__).'/skin/'.$name.'/face2.gif';
	$fpath3 = dirname(__FILE__).'/skin/'.$name.'/face3.gif';
	return array($fpath1, $fpath2, $fpath3);
}

function isset_face($array){
	foreach($array as $k=>$v){
		if(file_exists($v)){
			$narr[] = $v;
		}
	}
	if(empty($narr)){
		echo '<script>alert("'._e("您没有上传表情，暂时无法使用伪春菜的说").'");</script>>';
	}else{
		return $narr;
	}
}


/*
create table `weichuncai_table` (
`id` int(11) not null auto_increment,
`title` varchar(150) not null default '',
`value` text not null,

primary key (`id`)
)ENGINE=MyISAM;

*/
