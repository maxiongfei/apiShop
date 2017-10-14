'use strict';
define(function (require, exports, module) {
    module.exports = {
        addMenu:function(){
            var title = $('.menu_title').val();
            if(!title){
                layer.msg('请输入菜单名称',{icon:2,time:2000});
                return false;
            }
            var title = $('.icon_title').val();
            if(!title){
                layer.msg('请输入icon名称',{icon:2,time:2000});
                return false;
            }
            var url = $('#create_form ').attr('data-url');
            var load = '';
            $.ajax({
                url: url,
                type: "POST",
                data: $("#create_form").serialize(),
                beforeSend: function () {
                    load = layer.load(2);
                },
                success: function (res) {
                    layer.close(load);
                    if (res.status) {
                        layer.msg(res.msg, {icon: 1, time: 1000}, function () {
                            window.location.href = res.url;
                        });
                    } else {
                        layer.msg(res.msg, {icon: 2, time: 3000});
                    }
                }
            });
        }
    }
});