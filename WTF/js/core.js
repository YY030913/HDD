function submit(id){
	status=$("[class=status][id="+id+"]").val();
	$.ajax({
		type: "POST",
		url: "./php/status.php", 
		data: "&id="+id+"&status="+status,
		success: 
		function(returnKey){
			if(returnKey==1){
				$("[class=btn][id="+id+"]").html('更新成功');
				$("[class=btn][id="+id+"]").attr('disabled',true);
			}else{
				alert(returnKey);
			}
		}
	});
}

function select(id){
	$('.select').html('<p>选择开始时间：<input id="startdate" type="text" /></p><p>选择结束时间：<input id="stopdate" type="text" /></p><p><button onclick="disphis('+id+')">提交</button><button id="cancle"">取消</button></p>');
	$('#startdate').datepicker();
	$('#stopdate').datepicker();
	var i=$.layer({
		shade : [0.5, '#000', true],
		closeBtn : [0, false],
		type : 1,
		area : ['auto', 'auto'],
		title : false,
		border : [10, 0.6, '#000', true],
		page : {dom : '.select'},
	});
	$('#cancle').on('click',function(){
		layer.close(i);
	});
}

function disphis(id){
	layer.close(layer.index);
	var startdate = $('#startdate').val();
	var stopdate = $('#stopdate').val();
	var load=layer.load(0);
	$.ajax({
		url: "./php/his.php", 
		data: "&id="+id+"&start="+startdate+"&stop="+stopdate,
		dataType: 'json',
		success: 
		function(data){
			var table = '<hr><p>老师：'+data.name+'</p><p>'+data.position+'</p><table border="1"><tr height="30" align="center"><td width="220">状态</td><td width="180">时间</td></tr>';
			$.each(data.content,function(i,item){
				table += '<tr><td>'+item.status+'</td><td>'+item.time+'</td></tr>';
			});
			table += '</table>';
			$('body').append(table);
		}
	});
	layer.close(load);
}