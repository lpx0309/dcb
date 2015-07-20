// JavaScript Document
//改变url
function url_change(op,index,col,new_val){
	var url=window.location.href;
	var new_url=false;
	var new_val=encodeURI(new_val);
	
	//获得当前url参数中指定键的表达式和值
	if(url_get(col)){
		var val=url_get(col);
		var key=col+'='+val;
	}

	switch(op){
		case "all":
			if(url_get(col)){
				var url_arr=url.split("?");
				var val_arr=url_arr[1].split("&");
				
				if(val_arr[0]==key){
					if(val_arr.length==1){
						var new_url=url.replace("?"+key,"");
					}else{
						var new_url=url.replace(key+"&","");
					}
				}else{
					var new_url=url.replace("&"+key,"");
				}
			}
		break;
		
		case "replace":
			if(url_get(col)){
				var new_url=url.replace(key,col+'='+new_val);
			}else{
				if(url.indexOf("?")!=-1){
					var new_url=url+"&"+col+"="+new_val;
				}else{
					if(url.indexOf(index)!=-1){
						var new_url=url+"?"+col+"="+new_val;
					}else{
						var new_url=url+index+"?"+col+"="+new_val;
					}
				}
			}
		break;
	}
	
	if(new_url){
		window.location=new_url;
	}else{
		window.location=url;
	}
}
//获得指定url参数的值
function url_get(col){
	var url_arr=window.location.href.split("?");
	if(url_arr[1]){
		var col_arr=url_arr[1].split("&");
		for(i in col_arr){
			var val_arr=col_arr[i].split("=");
			if(col==val_arr[0]){
				return val_arr[1];
			}
		}
		return false;
	}else{
		return false;
	}
}
//搜索
function list_search(tab){
	if($("#"+tab+"_keyword").val()){
		url_change("replace","index.php","kw",$("#"+tab+"_keyword").val());
	}else{
		url_change("all","index.php","kw");
	}
}
//排序
function list_sort(od,by){
	if(url_get("st")){
		var val=url_get("st").split("_");
		if(val[0]==od&&val[1]=="asc"){
			var by="desc";
		}else{
			var by="asc";
		}
	}
	url_change("replace","index.php","st",od+"_"+by);
}