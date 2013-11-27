var warning='访问过快导致时空出现异常，数据丢失在了次元空间裂缝之中。。。预计3秒后恢复正常。'

function callBack(){
	var navHeight = $('.nav-bar').height();
	var navWidth = $('.nav-bar').width();
	var footerHeight = $('.footer').height();
	$('.nav-bar').css("line-height", navHeight+'px');
	$('.nav-bar').css("font-size", navHeight*0.3+'px');
	$('.nav-bar').css("text-indent", navWidth*0.1+'px');
	$('.footer').css("line-height", footerHeight+'px');
	$('.footer').css("font-size", footerHeight*0.45+'px');
	$('.version').css("font-size", navHeight*0.12+'px');
}

function dutyUpdate(){
	var load=layer.load(0);
	$.ajax({
		url: './php/api.php',
		data: '&type=onduty',
		dataType: 'json',
		success: function(data){
			layer.close(load);
			if(data.content.name != null){
				$('.content').html('<div class="welcome"><h2>当前值班人员：'+data.content.name+'</h2><p>联系电话：'+data.content.mobile+'</p><img src="./images/duty.jpg" width="80%"></img></div>');
			}else{
				$('.content').html('<div class="welcome"><h2>这个时间还没有值班人员呢！</h2><img src="./images/duty.jpg" width="80%"></img></div>');
			}
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});
}

function teaUpdate(){
	var load=layer.load(0);
	$.ajax({
		url: './php/api.php',
		data: '&type=teacher',
		dataType: 'json',
		success: function(data){
			layer.close(load);
			result = '<table><tr height="50" align="center"><td width="120">老师</td><td width="120">职务</td><td width="120">联系方式</td><td width="240">状态</td></tr>';
			$.each(data.content,function(i,item){
				result += '<tr height="50"><td align="center">'+item.name+'</td><td align="center">'+item.position+'</td><td align="center">'+item.mobile+'</td><td align="center">'+item.status+'</td></tr>';
			});
			result += '</table>';
			$('.content').html(result);	
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});
}

function classUpdate(){
	var now = new Date();
	var weekShader = now.getDay();
	if(weekShader == 0){
		weekShader = 7;
	}
	var load=layer.load(0);
	var table='<p rel="info" style="text-align:center;">P.S. 把鼠标放在红色标记上查看详细信息，预定不可取消</p><p style="text-align:center;"><img src="./images/1.png" width="5%"></img><span>书屋已预订</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/2.png" width="5%"></img><span>会议室已预订</span></p><table><tr height="40"><td width="80" align="center">&nbsp;</td><td width="80" align="center">星期一</td><td width="80" align="center">星期二</td><td width="80" align="center">星期三</td><td width="80" align="center">星期四</td><td width="80" align="center">星期五</td><td width="80" align="center">星期六</td><td width="80" align="center">星期日</td></tr>';
	var time=new Array('','1-2节','3-4节','午休','5-6节','7-8节','9-10节','IN');
	for(var i=1;i<=7;i++){
		table += '<tr height="40">';
		for(var j=0;j<=7;j++){
			if(j==0){
				table += '<td align="center">'+time[i]+'</td>';
			}else{
				if(j<weekShader){
					table += '<td class="sign" id="'+j+i+'" align="center"><div id="1" class="half shader">&nbsp;<span id="1" class="tag"></span></div><div id="2" class="halfright shader">&nbsp;<span id="2" class="tag"></span><div></td>';
				}else{
					table += '<td class="sign" id="'+j+i+'" align="center"><div id="1" class="half">&nbsp;<span id="1" class="tag"></span></div><div id="2" class="halfright">&nbsp;<span id="2" class="tag"></span><div></td>';
				}
			}
		}
		table += '</tr>';
	}
	table += '</table>';
	$.ajax({
		url: './php/api.php',
		data: '&type=classroom',
		dataType: 'json',
		success: function(data){
			layer.close(load);
			$('.content').html(table);
			if(data.content){
				$.each(data.content,function(i,item){
					$('td[id='+item.week+item.time+']').find('div[id='+item.room+']').addClass('red');
					$('td[id='+item.week+item.time+']').find('span[id='+item.room+']').append(item.content);
				});
			}
			$(".red").mousemove(function(e){
				var height = $(window).height();
				$(this).find('.tag').css('display','block');
				$(this).find('.tag').css('left', e.pageX);
				$(this).find('.tag').css('bottom', height - e.pageY);
			});
			$(".red").mouseleave(function(e){
				$(this).find('.tag').css('display','none');
			});
			$("[class=half],[class=halfright]").mouseover(function(){
				$(this).addClass('over');
			});
			$("[class=half],[class=halfright]").mouseleave(function(){
				$(this).removeClass('over');
			});
			$("[class=half],[class=halfright]").click(function(){
				var id = $(this).parent('.sign').attr('id')+$(this).attr('id');
				order(id);
			});
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});
}

function order(id)
{
	var array = id.split("");
	var week = array[0];
	var time = array[1];
	var room = array[2];
	
	var timeArr=new Array('','1-2节','3-4节','午休','5-6节','7-8节','9-10节','IN');
	var weekArr=new Array('','星期一','星期二','星期三','星期四','星期五','星期六','星期日');
	var roomArr=new Array('','书屋','会议室');
	$('.order').html('<h3>您将要预定的是</h3><p>'+weekArr[week]+' '+timeArr[time]+' 的'+roomArr[room]+'</p><p>请务必注明专业年级姓名以及详细用途</p><input id="content" type="text" placeholder="请输入详情" /></p><p><span><input id="vcode" type="text" placeholder="请输入验证码" /><img id="code_img" src="./php/vcode.php" alt="看不清，请点击刷新" title="看不清，请点击刷新" /></span><p><button id="submit">提交</button><button id="cancle">取消</button></p>');
	$('input').placeholder();
	$('#code_img').click(function(){
		var append = '?' + new Date().getTime() + 'a' + Math.random();
		$(this).attr('src',$('#code_img').attr('src') + append);
	});
	var i=$.layer({
		shade : [0.5, '#000', true],
		closeBtn : [0, false],
		type : 1,
		area : ['auto', 'auto'],
		title : false,
		border : [10, 0.6, '#000', true],
		page : {dom : '.order'},
	});
	$('#cancle').on('click',function(){
		layer.close(i);
	});
	$('#submit').on('click',function(){
		submit(week+time+room+i);
	});
}

function submit(id){
	var array = id.split("");
	var week = array[0];
	var time = array[1];
	var room = array[2];
	var index = array[3];
	var content = $('#content').val();
	var vcode = $('#vcode').val();
	if(content){
		var load=layer.load(0);
		$.ajax({
			url: './php/api.php',
			data: '&type=order&week='+week+'&time='+time+'&room='+room+'&content='+content+'&vcode='+vcode,
			dataType: 'json',
			success: function(data){
				layer.close(load);
				if(data.error == '0'){                   //添加成功
					layer.close(index);
					$.layer({
						area : ['auto','auto'],
						closeBtn: false,
						time: 2,
						dialog : {msg:data.content,type : 1}	
					});
					submitUpdate();
				}else if(data.error == '1'){               //信息不全
					$.layer({
						area : ['auto','auto'],
						dialog : {msg:data.content,type : 8}	
					});
					var append = '?' + new Date().getTime() + 'a' + Math.random();
					$('#code_img').attr('src',$('#code_img').attr('src') + append);
				}else if(data.error == '2'){                //时间冲突
					$.layer({
						area : ['auto','auto'],
						dialog : {msg:data.content,type : 8}	
					});
				}else if(data.error == '3'){              //验证码错误
					$.layer({
						area : ['auto','auto'],
						dialog : {msg:data.content,type : 8}	
					});
					var append = '?' + new Date().getTime() + 'a' + Math.random();
					$('#code_img').attr('src',$('#code_img').attr('src') + append);
				}
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});
	}else{
		$.layer({
			area : ['auto','auto'],
			dialog : {msg:'请输入详情',type : 8}	
		});
	}
}

function submitUpdate(){
	$("[class=half],[class=halfright]").unbind('mouseover');
	$("[class=half],[class=halfright]").unbind('mouseleave');
	setTimeout(function(){
		var load=layer.load(0);
		$.ajax({
			url: './php/api.php',
			data: '&type=classroom',
			dataType: 'json',
			success: function(data){
				layer.close(load);
				if(data.content){
					$.each(data.content,function(i,item){
						$('td[id='+item.week+item.time+']').find('div[id='+item.room+']').addClass('red');
						var content = $('td[id='+item.week+item.time+']').find('span[id='+item.room+']').html();
						if(!content){
							$('td[id='+item.week+item.time+']').find('span[id='+item.room+']').append(item.content);
						}
					});
				}
				$(".red").mousemove(function(e){
					var height = $(window).height();
					$(this).find('.tag').css('display','block');
					$(this).find('.tag').css('left', e.pageX);
					$(this).find('.tag').css('bottom', height - e.pageY);
				});
				$(".red").mouseleave(function(e){
					$(this).find('.tag').css('display','none');
				});
				$("[class=half],[class=halfright]").mouseover(function(){
					$(this).addClass('over');
				});
				$("[class=half],[class=halfright]").mouseleave(function(){
					$(this).removeClass('over');
				});
				$("[class=half],[class=halfright]").click(function(){
					var id = $(this).parent('.sign').attr('id')+$(this).attr('id');
					order(id);
				});
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});
	},1000);
}

function extend(){
	$('.content').html('<h2><a href="http://blog.sina.com.cn/u/2450629767">学工助理博客</a></h2><h2><a href="http://www.benbentime.com">计算机学院工作网</a></h2><h2><a href="http://blog.sina.com.cn/hbut2013">13级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2449956125">12级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2449939115">11级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2450656273">10级年级博客</a></h2><h3>湖工大查分客户端现已下线，查分功能将整合到即将发布的用户中心内，敬请期待！</h3>');
}

function center(){
	if($('#widget').attr('class') == 'widget'){
		$('#widget').addClass('show');
		$('#userCenter').addClass('show');
		$('#widget').find('img').attr('src','./images/arrow-back.png');
	}else{
		$('#widget').removeClass('show');
		$('#userCenter').removeClass('show');
		$('#widget').find('img').attr('src','./images/arrow.png');
	}
}

function message(){
	$('.content').html('<div id="wish"><div>1. text</div><div>2. text</div></div>');
	$('.wish').draggable({containment: "#wish", scroll: false});
	$('#wish').wish();
}

function testScreen(){
	if(screen.width < 1024){
		layer.alert('您的屏幕分辨率太小，网页可能无法正常显示。</br>（推荐分辨率1280x720以上）', 8);
	}else{
		if(document.body.offsetWidth < 1200){
			slidemenu();
		}else{
			fixedmenu();
		}
		if(document.body.offsetWidth < 1020){
			layer.alert('您的浏览器没有最大化吗？</br>当浏览器窗口宽度小于1024时网页可能无法正常显示哦！', 8);
		}
	}
}

function slidemenu(){
	$('.menu').animate({left:"-220px"},400);
	$('.menu').find('ul').mouseover(function(){
		$('.menu').animate({left:"0"},400);
	});
	$('.menu').find('ul').mouseleave(function(){
		$('.menu').animate({left:"-220px"},400);
	});
}

function fixedmenu(){
	$('.menu').animate({left:"6%"},400);
	$('.menu').find('ul').unbind();
}

