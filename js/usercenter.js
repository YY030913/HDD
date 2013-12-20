function switcher(rel){
	$('.optionsBtn').removeClass('selected');
	$('[rel='+rel+']').addClass('selected');
	if(rel == 'register'){
		$('#pageLogin').css('left','420px');
		$('#pageReg').css('left','0px');
	}
	if(rel == 'login'){
		$('#pageLogin').css('left','0px');
		$('#pageReg').css('left','420px');
	}
	if(rel == 'bindaccount'){
		$('#pageBind').css('left','0px');
		$('#pageCenter').css('left','420px');
	}
	if(rel == 'usercenter'){
		$('#pageCenter').css('left','0px');
		$('#pageBind').css('left','420px');
	}
}

function updateAQI(data){
	if(data.error == null){
		$('#aqi').html(data.aqi);
		$('#quality').html('（'+data.quality+'）');
		$('#primary_pollutant').html(data.primary_pollutant);
	}else{
		$('#aqi').html('0');
		$('#quality').html('无数据');
		$('#primary_pollutant').html('无数据');
	}
}

function showmenu(rel){
	var list=$('[class='+rel+'],[class='+rel+'-show]');
	var arrow=$('[rel='+rel+']').find('.extSt');
	if(list.attr('class') == rel){
		list.removeClass(rel);
		list.addClass(rel+'-show');
		arrow.addClass('down');
	}else{
		list.removeClass(rel+'-show');
		list.addClass(rel);
		arrow.removeClass('down');
	}
}

function updateAvatar(){
	var load=layer.load(0);
	$.ajax({
		url: './php/api.php',
		data: '&type=usercenter',
		dataType: 'json',
		success: function(data){
			layer.close(load);
			if(data.content.avatar != '0'){
				$('.avatar').find('img').attr('src', './uploads/'+data.content.avatar);
				$('.oldAvatar').css('background-image', 'url("./uploads/'+data.content.avatar+'")');
			}
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});
}

function register(){
	$('#register').attr('disabled',true);
	$('#register').addClass('disabled');
	var username = $('#regUsername').val();
	var password = $('#regPassword').val();
	var password_repeat = $('#regPassword_repeat').val();
	var email = $('#regEmail').val();
	if(!username){
		layer.alert('请输入用户名', 8);
	}else if(!password){
		layer.alert('请输入密码', 8);
	}else if(!password_repeat){
		layer.alert('请确认密码', 8);
	}else if(!email){
		layer.alert('请输入邮箱', 8);
	}else if(password != password_repeat){
		layer.alert('两次密码输入不一致', 8);
	}else{
		var load=layer.load(0);
		$.ajax({
			url: './php/register.php',
			data: '&user='+username+'&pass='+password+'&email='+email,
			type: 'POST',
			success: function(returnKey){
				layer.close(load);
				if(returnKey == '1'){
					$.layer({
						area : ['auto','auto'],
						time : 2,
						closeBtn: false,
						title : false,
						dialog : {msg:'注册成功！', type : 1}	
					});
					loadCenter();
				}else{
					layer.alert(returnKey, 8);
				}
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});
	}
	$('#register').attr('disabled',false);
	$('#register').removeClass('disabled');
}

function login(){
	$('#login').attr('disabled',true);
	$('#login').addClass('disabled');
	var username = $('#logUsername').val();
	var password = $('#logPassword').val();
	if(!username){
		layer.alert('请输入用户名', 8);
	}else if(!password){
		layer.alert('请输入密码', 8);
	}else{
		var load=layer.load(0);
		$.ajax({
			url: './php/login.php',
			data: '&user='+username+'&pass='+password,
			type: 'POST',
			success: function(returnKey){
				layer.close(load);
				if(returnKey == '1'){
					$.layer({
						area : ['auto','auto'],
						time : 2,
						closeBtn: false,
						title : false,
						dialog : {msg:'登陆成功！', type : 1}	
					});
					loadCenter();
				}else{
					layer.alert(returnKey, 8);
				}
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});
	}
	$('#login').attr('disabled',false);
	$('#login').removeClass('disabled');
}

function logout(){
	$('#logout').attr('disabled',true);
	$('#logout').addClass('disabled');
	var load=layer.load(0);
	setTimeout(function(){
		$.ajax({
			url: './php/logout.php',
			success: function(returnKey){
				window.location.reload(); 
			}
		});
	}, 1000);
	$('#logout').attr('disabled',false);
	$('#logout').removeClass('disabled');
}

function loadCenter(){
	//setTimeout(function(){
		var load=layer.load(0);
		$.ajax({
			url: './php/api.php',
			data: '&type=usercenter',
			type: 'GET',
			dataType: 'JSON',
			success: function(data){
				layer.close(load);
				if(data.error == '0'){
					if(data.content.name != null){
						var name = data.content.name;
					}else{
						var name = data.content.user;
					}
					if(data.content.sign != null){
						var sign = data.content.sign;
					}else{
						var sign = '无签名';
					}
					if(data.content.avatar != '0'){
						$('.avatar').find('img').attr('src', './uploads/'+data.content.avatar);
						$('.oldAvatar').css('background-image', 'url("./uploads/'+data.content.avatar+'")');
					}
					$('#name').html(name);
					$('#sign').html(sign);
					$('#centerContent').load('./ajax/uc_success.html',function(){
						updateAvatar();
						$("#sendmail").click(function(){
							sendmail();
						});
						$("#bindaccount").click(function(){
							bindaccount();
						});
						$("#logout").click(function(){
							logout();
						});
						$(".optionsBtn").click(function(){
							var rel=$(this).attr('rel');
							switcher(rel);
						});
						$('.centerlist').click(function(){
							showmenu($(this).attr('rel'));
						});
						if(data.content.emailverify != '0'){
							$('#sendmail').attr('disabled','disabled');
							$('#sendmail').addClass('disabled');
							$('#sendmail').html('邮箱已验证');
						}
						if(data.content.accountverify != '0'){
							$('#bindaccount').attr('disabled','disabled');
							$('#bindaccount').addClass('disabled');
							$('#bindaccount').html('教务平台已绑定');
						}
					});
				}else{
					layer.alert(data.content, 8);
				}
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});
	//}, 1000);
}

function sendmail(){
	var load=layer.load(0);
	$.ajax({
		url: './php/sendmail.php',
		success: function(data){
			layer.close(load);
			if(data == '1'){
				$('#sendmail').attr('disabled',true);
				$('#sendmail').addClass('disabled');
				var time=60;
				var i=setInterval(function(){
					time -= 1;
					$('#sendmail').html('发送成功('+time+')');
					if(time == 0){
						$('#sendmail').html('发送验证邮件');
						$('#sendmail').attr('disabled',false);
						$('#sendmail').removeClass('disabled');
						clearInterval(i);
					}
				},1000);
			}else{
				layer.alert(data, 8);
			}
		},
		error: function(){
			layer.close(load);
			layer.alert(warning, 8);
		}
	});	
}
				
function bindaccount(){
	var i = $.layer({
		type: 1,
		title: false,
		closeBtn: false,
		border : [5, 0.5, '#666', true],
		area: ['252px','auto'],
		page: {
			html: '<div class="bindaccount"><p><input type="text" id="account" placeholder="请输入学号"></p><p><input type="password" id="pass" placeholder="请输入密码"></p><p><button id="btnBind">提交</button><button id="cancle">取消</button></p></div>'
		}
	});
	$('input').placeholder();
	$('#btnBind').click(function(){
		bindsubmit(i);
	});
	$('#cancle').click(function(){
		layer.close(i);
	});
}

function bindsubmit(index){
	var account=$('#account').val();
	var pass=$('#pass').val();
	if(account.length != 10){
		layer.alert('请输入正确的学号', 8);
	}
	else if(!pass){
		layer.alert('请输入密码', 8);
	}else{
		var load=layer.load(0);
		$.ajax({
			url: './php/hbut_curl_api.php',
			data: '&user='+account+'&pass='+pass,
			dataType: 'json',
			success: function(data){
				layer.close(load);
				if(data.error == '0'){
					layer.close(index);
					$.layer({
						area : ['auto','auto'],
						time : 2,
						closeBtn: false,
						title : false,
						dialog : {msg:data.text, type : 1}	
					});
					loadCenter();
				}
				else if(data.error == '2'){
					layer.alert('教务处服务器繁忙，请重试。。。', 8);
				}else{
					layer.alert(data.text, 8);
				}
			},
			error: function(){
				layer.close(load);
				layer.alert(warning, 8);
			}
		});	
	}
}

function checkbind(type){
	$.ajax({
		url: './php/checkbind.php',
		data: '&type='+type,
		type: 'GET',
		success: function(data){
			if(data == '0'){
				layer.alert('请先绑定学号', 8);
				center();
			}
		}
	});
}
	
function checklogin(){
	$.ajax({
		url: './php/checklogin.php',
		success: function(data){
			if(data == '1'){
				var load=layer.load(0);
				loadCenter();
			}
		}
	});
}