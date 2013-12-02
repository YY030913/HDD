<?php
//字体颜色设置
$font_color = array('r' => 190, 'g' => 170, 'b' => 255);

//---------------------------------将验证码二值化-------------------------------
$file = $jpg;

$rgb_stat = array('r'=>array(),'g'=>array(),'b'=>array(), 'a'=>array());//点集颜色统计

$im = imagecreatefromjpeg($file);
$w = imagesx($im);
$h = imagesy($im);

//二值化
$im2 = imagecreatetruecolor($w, $h);
$black = imagecolorallocate($im2, 0, 0, 0);
$white = imagecolorallocate($im2, 255, 255, 255);
for ($i=0; $i<$w; $i++)
{
    for ($j=0; $j<$h; $j++)
    {
        $rgb = imagecolorsforindex($im, imagecolorat($im, $i, $j));

        $rgb_stat['r'][$rgb['red']%8]++;
        $rgb_stat['g'][$rgb['green']%8]++;
        $rgb_stat['b'][$rgb['blue']%8]++;
        $rgb_stat['rgb'][$rgb['red']%8][$rgb['green']%8][$rgb['blue']%8]++;
        $rgb_stat['rg'][$rgb['red']%8][$rgb['green']%8]++;

        if ($rgb['red'] < $font_color['r'] && $rgb['green'] < $font_color['g'] && $rgb['blue'] < $font_color['b'])
        {
            imagesetpixel($im2, $i, $j, $black);
			$data[$i][$j]=1;
        }
        else
        {
            imagesetpixel($im2, $i, $j, $white);
			$data[$i][$j]=0;
        }
    }
}
//-----------------------------------------------------------------------------------



//----------------------------处理杂色----------------------------
for ($i=0; $i<$w; $i++)
{
    for ($j=0; $j<$h; $j++)
    {
		$num = 0;
		if($data[$i][$j] == 1)
		{
			// 上
			if($data[$i-1][$j]==1){
				$num = $num + 1;
			}
			// 下
			if($data[$i+1][$j]==1){
				$num = $num + 1;
			}
			// 左
			if($data[$i][$j-1]==1){
				$num = $num + 1;
			}
			// 右
			if($data[$i][$j+1]==1){
				$num = $num + 1;
			}
			// 上左
			if($data[$i-1][$j-1]==1){
				$num = $num + 1;
			}
			// 上右
			if($data[$i-1][$j+1]==1){
				$num = $num + 1;
			}
			// 下左
			if($data[$i+1][$j-1]==1){
				$num = $num + 1;
			}
			// 下右
			if($data[$i+1][$j+1]==1){
				$num = $num + 1;
			}
		}
		if($num < 3){
			imagesetpixel($im2, $i, $j, $white);
		}
	}
}
imagejpeg($im2,$file,100);
//-----------------------------------------------------------


//-----------------------OCR识别-----------------------------
$outFile=$file;
exec("tesseract ".$file." ".$outFile." nobatch ./include/config.conf");
$vcode = file_get_contents($outFile.'.txt');
$vcode=substr($vcode,0,4);
if(!$vcode)
{
	$err= "1";
	$text="识别验证码失败！";
	$json_data=array(
		'error'=>$err,
		'text'=>urlencode($text)
		);
	$json=json_encode($json_data);
	echo urldecode($json);
	exit;
}
//-----------------------------------------------------------
?>