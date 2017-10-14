function navBar(strData){
	var data;
	if(typeof(strData) == "string"){
		var data = JSON.parse(strData); //部分用户解析出来的是字符串，转换一下
	}else{
		data = strData;
	}
	var ulHtml = '<ul class="layui-nav layui-nav-tree">';
	for(var i=0;i<data.length;i++){
		if(data[i].is_spread){
			ulHtml += '<li class="layui-nav-item layui-nav-itemed">';
		}else{
			ulHtml += '<li class="layui-nav-item">';
		}
		if(data[i]._child != undefined && data[i]._child.length > 0){
			ulHtml += '<a href="javascript:;">';
			if(data[i].icon != undefined && data[i].icon != ''){
				if(data[i].icon.indexOf("icon-") != -1){
					ulHtml += '<i class="iconfont '+data[i].icon+'" data-icon="'+data[i].icon+'"></i>';
				}else{
					ulHtml += '<i class="layui-icon" data-icon="'+data[i].icon+'">'+data[i].icon+'</i>';
				}
			}
			ulHtml += '<cite>'+data[i].title+'</cite>';
			ulHtml += '<span class="layui-nav-more"></span>';
			ulHtml += '</a>';
			ulHtml += '<dl class="layui-nav-child">';
			for(var j=0;j<data[i]._child.length;j++){
				if(data[i]._child[j].target == "_blank"){
					ulHtml += '<dd><a href="javascript:;" data-url="'+data[i]._child[j].name+'" target="'+data[i]._child[j].target+'">';
				}else{
					ulHtml += '<dd><a href="javascript:;" data-url="'+data[i]._child[j].name+'">';
				}
				if(data[i]._child[j].icon != undefined && data[i]._child[j].icon != ''){
					if(data[i]._child[j].icon.indexOf("icon-") != -1){
						ulHtml += '<i class="iconfont '+data[i]._child[j].icon+'" data-icon="'+data[i]._child[j].icon+'"></i>';
					}else{
						ulHtml += '<i class="layui-icon" data-icon="'+data[i]._child[j].icon+'">'+data[i]._child[j].icon+'</i>';
					}
				}
				ulHtml += '<cite>'+data[i]._child[j].title+'</cite></a></dd>';
			}
			ulHtml += "</dl>";
		}else{
			if(data[i].target == "_blank"){
				ulHtml += '<a href="javascript:;" data-url="'+data[i].name+'" target="'+data[i].target+'">';
			}else{
				ulHtml += '<a href="javascript:;" data-url="'+data[i].name+'">';
			}
			if(data[i].icon != undefined && data[i].icon != ''){
				if(data[i].icon.indexOf("icon-") != -1){
					ulHtml += '<i class="iconfont '+data[i].icon+'" data-icon="'+data[i].icon+'"></i>';
				}else{
					ulHtml += '<i class="layui-icon" data-icon="'+data[i].icon+'">'+data[i].icon+'</i>';
				}
			}
			ulHtml += '<cite>'+data[i].title+'</cite></a>';
		}
		ulHtml += '</li>';
	}
	ulHtml += '</ul>';
	return ulHtml;
}
