$(document).ready(function(){
	$("#btnOnduty").bind("tap", function() {
		onduty();
	});
	$("#btnTeacher").bind("tap", function() {
		teacher();
	});
	$("#btnClassroom").bind("tap", function() {
		classroom();
	});
});

function onduty(){
	$.ajax({
		url: '../php/api.php',
		data: '&type=onduty',
		dataType: 'json',
		success: function(data){
			if(data.content.name != null){
				$('#dataOnduty').html('<div class="welcome"><h2>当前值班人员：'+data.content.name+'</h2><p>联系电话：'+data.content.mobile+'</p></div>');
			}else{
				$('#dataOnduty').html('<div class="welcome"><h2>这个时间还没有值班人员呢！</h2></div>');
			}
		}
	});
}

function teacher(){
	$.ajax({
		url: '../php/api.php',
		data: '&type=teacher',
		dataType: 'json',
		success: function(data){
			result = '<ul data-role="listview">';
			$.each(data.content,function(i,item){
				result += '<li><div>'+item.name+'</div><ul><li><a href="#" data-rel="back" data-icon="back">..上一级</a></li><li>职务：'+item.position+'</li><li>联系电话：'+item.mobile+'</li><li>去向：'+item.status+'</li></ul>';
			});
			result += '</ul>';
			$('#dataTeacher').html(result);	
			$("div[data-role=content] ul").listview();
		}
	});
}

function classroom(){
	var time=new Array('','1-2节','3-4节','午休','5-6节','7-8节','9-10节','IN');
	var day=new Array('','星期一','星期二','星期三','星期四','星期五','星期六','星期日');
	var now = new Date();
	var week = now.getDay();
	$.ajax({
		url: '../php/api.php',
		data: '&type=classroom',
		dataType: 'json',
		success: function(data){
			result = '<ul data-role="listview">';
			$.each(data.content,function(i,item){
				if(item.week >= week){
					result += '<li><div>'+day[item.week]+' '+time[item.time]+'</div><ul><li><a href="#" data-rel="back" data-icon="back">..上一级</a></li><li>详情：'+item.content+'</li></ul>';
				}
			});
			result += '</ul>';
			$('#dataClassroom').html(result);	
			$("div[data-role=content] ul").listview();
		}
	});
}
			
			
			
			
			
			