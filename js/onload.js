window.onload = function(){
	testScreen();
	checklogin();
	$(window).resize(function() {
		testScreen();
	});
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
	$("#widget").click(function(){
		center();
	});
	$(".list").click(function(){
		$('.list').removeClass('active');
		$(this).addClass('active');
	});
	$(".optionsBtn").click(function(){
		var rel=$(this).attr('rel');
		switcher(rel);
	});
	$("#widget").mouseover(function(){
		if($('#widget').attr('class') == 'widget'){
			$(this).find('img').attr('src','./images/arrow-red.png');
		}else{
			$(this).find('img').attr('src','./images/arrow-back-red.png');
		}
	});
	$("#widget").mouseleave(function(){
		if($('#widget').attr('class') == 'widget'){
			$(this).find('img').attr('src','./images/arrow.png');
		}else{
			$(this).find('img').attr('src','./images/arrow-back.png');
		}
	});
	$(".reset").click(function(){
		$('input').val('');
	});
	$("#login").click(function(){
		login();
	});
	$("#register").click(function(){
		register();
	});
	$(window).resize(function() {
		callBack();
	});
	anti_piracy(key);
}