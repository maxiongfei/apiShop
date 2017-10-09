'use strict';
define(function (require, exports, module) {
    module.exports = {
        editGroup:function(){
            var title = $('.group_title').val();
            if(!title){
                layer.msg('请输入角色名',{icon:2,time:2000});
                return false;
            }
            if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/).test(title)){
                layer.msg('角色名称输入不合法',{icon:2,time:3000});
                $('.role_title').attr('placeholder','角色名称输入不合法,请重新输入');
                return false;
            }
            var url = $('#group_form').attr('data-url');
            var load = '';
            $.ajax({
                url: url,
                type: "post",
                data: $("#group_form").serialize(),
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