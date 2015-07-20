// JavaScript Document
//弹出层
function pop_div(width,height,title,id,data){
	var loading='<div style="margin-top:25%; text-align:center"><img src="images/pop_loading.gif" width="30" height="30" /></div>';
	$("body").append('<div id="pop_div_'+id+'">'+loading+'</div>');
	$("#pop_div_"+id).dialog({
		modal: true,				 
		autoOpen:false,
		resizable:false,
		width:width,
		height:height,
		title:title,
		close:function(){
			$(this).remove();
		}
	});
	$("#pop_div_"+id).dialog("open");
	$("#pop_div_"+id).load('index.php?controller=view&view='+id+"&time="+new Date().getTime(),data,function(response,status,xhr){
		if(status=='error'){
			$(this).html(response);
		}
	});
}
//弹出层按钮
function pop_buttons(buttons,id){
	$("#pop_div_"+id).dialog("option","buttons",buttons);
}
//弹出警告
function pop_alert(content){
	$("body").append('<div id="pop_div_alert"><div style="line-height:20px; margin-top:15px; text-align:center">'+content+'</div></div>');
	$("#pop_div_alert").dialog({
		modal: true,				 
		autoOpen:false,
		resizable:false,
		width:300,
		height:170,
		title:'提示',
		close:function(){
			$(this).remove();
		},
		buttons:{
			"确定":function(){
				$(this).dialog("close");
			}
		}
	});
	$("#pop_div_alert").dialog("open");
}
