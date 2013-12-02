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
					$('td[id='+item.week+item.time+']').find('span[id='+item.room+']').append('<p>'+item.name+' '+item.class1+'</p><p>'+item.content+'</p>');
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
	if($('#name').html() == '未登录'){
		layer.alert('请先登录', 8);
		center();
	}else{
		checkbind('account');
		var array = id.split("");
		var week = array[0];
		var time = array[1];
		var room = array[2];
		
		var timeArr=new Array('','1-2节','3-4节','午休','5-6节','7-8节','9-10节','IN');
		var weekArr=new Array('','星期一','星期二','星期三','星期四','星期五','星期六','星期日');
		var roomArr=new Array('','书屋','会议室');
		$('.order').html('<h3>您将要预定的是</h3><p>'+weekArr[week]+' '+timeArr[time]+' 的'+roomArr[room]+'</p><p>请务必注明专业年级姓名以及详细用途</p><input id="content" type="text" placeholder="请输入详情" /></p><p><span><input id="vcode" type="text" placeholder="请输入验证码" /><img id="code_img" src="./php/vcode.php" alt="看不清，请点击刷新" title="看不清，请点击刷新" /></span></p><p><button id="submit">提交</button><button id="cancle">取消</button></p>');
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
				}
				else if(data.error == '3'){              //验证码错误
					$.layer({
						area : ['auto','auto'],
						dialog : {msg:data.content,type : 8}	
					});
					$('#cancle').on('click',function(){
						layer.close(i);
					});
					var append = '?' + new Date().getTime() + 'a' + Math.random();
					$('#code_img').attr('src',$('#code_img').attr('src') + append);
				}else{             
					$.layer({
						area : ['auto','auto'],
						dialog : {msg:data.content,type : 8}	
					});
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
	//setTimeout(function(){
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
							$('td[id='+item.week+item.time+']').find('span[id='+item.room+']').append('<p>'+item.name+' '+item.class1+'</p><p>'+item.content+'</p>');
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
	//},1000);
}

function extend(){
	$('.content').html('<h1><a href="http://pan.baidu.com/s/169G9e">湖工大查分客户端V2.1.1下载</a></h1><h2><a href="http://blog.sina.com.cn/u/2450629767">学工助理博客</a></h2><h2><a href="http://www.benbentime.com">计算机学院工作网</a></h2><h2><a href="http://blog.sina.com.cn/hbut2013">13级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2449956125">12级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2449939115">11级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2450656273">10级年级博客</a></h2>');
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
	var load=layer.load(0);
	$('.content').html('<div class="write"></div><div id="wish"></div>');
	$.ajax({
		url: './php/api.php',
		data: '&type=msgwall',
		dataType: 'json',
		success: function(data){
			layer.close(load);
			$.each(data.content,function(i,item){
				$('#wish').append('<div><span class="title">'+item.name+'</span>'+item.content+'</div>');
			});
			$('#wish').wish();
			$('.wish').draggable({containment: "#wish", scroll: false});
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});
	$('.write').mouseover(function(){
		$(this).css('opacity','1');
	});
	$('.write').mouseleave(function(){
		$(this).css('opacity','0.55');
	});
	$('.write').click(function(){
		addmessage();
	});
}

function addmessage(){
	if($('#name').html() == '未登录'){
		layer.alert('请先登录', 8);
		center();
	}else{
		checkbind('account');
		var i = $.layer({
			type: 1,
			title: false,
			closeBtn : [0 , true],
			border : [5, 0.5, '#666', true],
			move: ['.juanmove', true],
			area: ['auto','auto'],
			page: {
				html: '<div class="leavemsg"><p><textarea placeholder="你想说些什么？不要超过50字哦！" id="message"></textarea></p><p><span><input id="vcode1" type="text" placeholder="请输入验证码" /><img id="vcode_img" src="./php/vcode.php" alt="看不清，请点击刷新" title="看不清，请点击刷新" /></span><button id="sendmsg">提交</button></p></div>'
			}
		});
		$('input').placeholder();
		$('#vcode_img').click(function(){
			var append = '?' + new Date().getTime() + 'a' + Math.random();
			$(this).attr('src',$('#vcode_img').attr('src') + append);
		});
		$('#sendmsg').click(function(){
			sendmsg(i);
		});
	}
}

function sendmsg(index){
	var vcode=$('#vcode1').val();
	var message=$('#message').val();
	if(!vcode){
		layer.alert('请输入验证码', 8);
	}else if(!message){
		layer.alert('请输入你想说的话', 8);
	}else if(message.length < 5){
		layer.alert('至少要说5个字哦', 8);
	}else if(message.length >50){
		layer.alert('最多只能写50个字哦', 8);
	}else{
		var load=layer.load(0);
		$.ajax({
			url: './php/api.php?type=sendmsg',
			method: 'POST',
			dataType: 'JSON',
			data: '&message='+message+'&vcode='+vcode,
			success: function(data){
				layer.close(load);
				if(data.error == 0){
					layer.close(index);
					layer.alert(data.content, 1);
					updateMessage()
				}else if(data.error == 3){
					layer.alert(data.content, 8);
					var append = '?' + new Date().getTime() + 'a' + Math.random();
					$('#vcode_img').attr('src',$('#vcode_img').attr('src') + append);
				}else{
					layer.alert(data.content, 8);
				}
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});
	}	
}

function updateMessage(){
	var load=layer.load(0);
	$('.content').html('<div class="write"></div><div id="wish"></div>');
	$.ajax({
		url: './php/api.php',
		data: '&type=msgwall',
		dataType: 'json',
		success: function(data){
			layer.close(load);
			$.each(data.content,function(i,item){
				$('#wish').append('<div><span class="title">'+item.name+'</span>'+item.content+'</div>');
			});
			$('#wish').wish();
			$('.wish').draggable({containment: "#wish", scroll: false});
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});
	$('.write').mouseover(function(){
		$(this).css('opacity','1');
	});
	$('.write').mouseleave(function(){
		$(this).css('opacity','0.55');
	});
	$('.write').click(function(){
		addmessage();
	});
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
	$('.menu').animate({left:"4%"},400);
	$('.menu').find('ul').unbind();
}

