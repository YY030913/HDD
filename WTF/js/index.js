window.onload = function(){
	$('a[id!=index]').click(function(){
		$('#content').attr('src',$(this).attr('id')+'.php');
	});
}