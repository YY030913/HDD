<?php
 function xiaojo($keyword){
		$header=array(
			"User-Agent" => "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36"
			);
        $curlPost=array("chat"=>$keyword);
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,'http://www.xiaojo.com/bot/chata.php');//抓取指定网页
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        if(!empty($data)){
            return $data;
        }else{
            $ran=rand(1,5);
            switch($ran){
                case 1:
                    return "我才不要和你聊天呢！";
                    break;
                case 2:
                    return "睡觉喽~~";
                    break;
                case 3:
                    return "呼呼~~呼呼~~";
                    break;
                case 4:
                    return "大话痨，人家不理你了。";
                    break;
                default:
                    return "主人叫我呢，我先走一步~";
                    break;
            }
        }
    }
	
	function filter($content)
	{
		$keyword=array(
			'nmlgb',
			'金华',
			'订单',
			'宝贝'
		);
		foreach($keyword as $value)
		{
			if(preg_match('/'.$value.'/',$content))
				return '......？';
			else
				return $content;
		}
	}
	
	echo filter(xiaojo($_GET['key']));
?>