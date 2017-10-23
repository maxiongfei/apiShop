layui.config({
    base : window.staticPath+"/admin/js/"
}).use(['form','layer'],function(){
	var form = layui.form(),
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery;
	/*//video背景
	$(window).resize(function(){
		if($(".video-player").width() > $(window).width()){
			$(".video-player").css({"height":$(window).height(),"width":"auto","left":-($(".video-player").width()-$(window).width())/2});
		}else{
			$(".video-player").css({"width":$(window).width(),"height":"auto","left":-($(".video-player").width()-$(window).width())/2});
		}
	}).resize();*/
	//验证码切换
	$(".code").on('click',function(){
        var src = $(this).find('img').data('url');
        var newSrc = src+'?'+Math.random();
        $(this).find('img').attr('src',newSrc);
	})
	//登录按钮事件
	form.on("submit(login)",function(param){
		var url = $(".login-form").data('url');
		$.ajax({
			url:url,
			method:"POST",
			dataType:"JSON",
			data:param.field,
			success:function(res){
				if(res.status == 1){
					window.location.href  = res.url;
				}else{
					layer.msg(res.msg);
				}
			}
		});
		return false;
	})
})
