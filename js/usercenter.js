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
}

function register(){
	$('#register').attr('disabled',true);
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
						time : 3,
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
}

function login(){
	$('#login').attr('disabled',true);
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
						time : 3,
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
}

function logout(){
	$('#logout').attr('disabled',true);
	var load=layer.load(0);
	setTimeout(function(){
		$.ajax({
			url: './php/logout.php',
			success: function(returnKey){
				window.location.reload(); 
			}
		});
	}, 3000);
	$('#logout').attr('disabled',false);
}

function loadCenter(){
	setTimeout(function(){
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
						var sign = data.content.name;
					}else{
						var sign = '无签名';
					}
					if(data.content.avatar != '0'){
						var avatar = data.content.avatar;
					}
					$('#name').html(name);
					$('#sign').html(sign);
					$('.options').html('');
					$('.optionContent').html('<p><button class="logout" id="logout">退出登陆</button>');
					$("#logout").click(function(){
						logout();
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
	}, 3000);
}
	
			