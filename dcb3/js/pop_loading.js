// JavaScript Document

//弹出载入
function pop_loading(){
    var flag = 0;
	$("body").append('<div id="pop_loading"><p id="pop_loading_word">加载中...</p><p id="pop_loading_second">0</p></div>');
    $("#pop_loading").dialog({
    	bgiframe: true,
    	autoOpen: true,
        resizable: false,
    	modal: true,
        height: 160,
        width: 300,
        open: function(){
            $(this).parent().find('.ui-dialog-titlebar').hide();
			flag = setInterval(pop_loading_second, 1000);
        },
        beforeclose: function(){
			clearInterval(flag);
        },
    	close: function(){
    		$(this).remove();
    	}
    });
}
//读秒
function pop_loading_second(){
	var pop_loading_second=parseInt($('#pop_loading_second').html());
	pop_loading_second++;
	$('#pop_loading_second').html(pop_loading_second);
}
//关闭
function pop_loading_close(){
	$('#pop_loading').dialog('close');
}
