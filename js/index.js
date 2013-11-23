function callBack(){
	var navHeight = $('.nav-bar').height();
	var navWidth = $('.nav-bar').width();
	var menuWidth = $('.menu').width();
	var menuHeight = $('li').height();
	var footerHeight = $('.footer').height();
	$('.nav-bar').css("line-height", navHeight+'px');
	$('.nav-bar').css("font-size", navHeight*0.3+'px');
	$('.nav-bar').css("text-indent", navWidth*0.1+'px');
	$('.menu').css("font-size", menuHeight*0.5+'px');
	$('.menu').css("text-indent", menuWidth*0.18+'px');
	$('.menu').css("line-height", menuHeight+'px');
	$('.footer').css("line-height", footerHeight+'px');
	$('.footer').css("font-size", footerHeight*0.45+'px');
}

function dutyUpdate(){
	menu('onduty');
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
		}
	});
}

function teaUpdate(){
	menu('teacher');
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
		}
	});
}

function classUpdate(){
	var now = new Date();
	var weekShader = now.getDay();
	if(weekShader == 0){
		weekShader = 7;
	}
	menu('order');
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
	$('.order').html('<h3>您将要预定的是</h3><p>'+weekArr[week]+' '+timeArr[time]+' 的'+roomArr[room]+'</p><p>请务必注明专业年级姓名以及详细用途</p><input id="content" type="text" placeholder="请输入详情" /></p><p><span><input id="vcode" type="text" placeholder="请输入验证码" /><img id="code_img" src="./php/vcode.php" alt="看不清，请点击刷新" title="看不清，请点击刷新" onClick="this.src=this.src" /></span><p><button id="submit">提交</button><button id="cancle">取消</button></p>');
	$('input').placeholder();
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
						dialog : {msg:data.content,type : 1}	
					});
					classUpdate('order');
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
			}
		});
	}else{
		$.layer({
			area : ['auto','auto'],
			dialog : {msg:'请输入详情',type : 8}	
		});
	}
}

function extend(){
	menu('extend');
	$('.content').html('<h2><a href="http://blog.sina.com.cn/u/2450629767">学工助理博客</a></h2><h2><a href="http://www.benbentime.com">计算机学院工作网</a></h2><h2><a href="http://blog.sina.com.cn/hbut2013">13级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2449956125">12级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2449939115">11级年级博客</a></h2><h2><a href="http://blog.sina.com.cn/u/2450656273">10级年级博客</a></h2>');
}

function menu(rel){
	$('.list').removeClass('active');
	$('[rel='+rel+']').addClass('active');
}

function empty(object){
	$(this).val('');
}

window.onload = function(){
	$("body").iealert({
		support: "ie8",
		title: "你的浏览器过时了！",
		text: 'JQuery+CSS3+HTML5纯手工打造，显示不正常或功能不正常的同学——你该换个<font color="red">高级货</font>了。双核浏览器务必打开<font color="red">[高速模式]</font>、<font color="red">[急速模式]</font>、<font color="red">[超速模式]</font>、<font color="red">[音速模式]</font>、<font color="red">[光速模式]</font>。',
		upgradeLink: "https://www.google.com/intl/zh-CN/chrome/browser/"
	});
	callBack();
	$(".footer").mouseover(function(){
		$(".footer").addClass('over');
	});
	$(".footer").mouseleave(function(){
		$(".footer").removeClass('over');
	});
	$(window).resize(function() {
		callBack();
	});
}



