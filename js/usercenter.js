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