'use strict';
define(function (require, exports, module) {
    module.exports = {
        editMember:function(){
            var name = $('.member_name').val();
            var password = $('.member_password').val();
            if(!name){
                layer.msg('请输入用户姓名',{icon:2,time:2000});
                return false;
            }
            if(!password){
                layer.msg('请输入用户密码',{icon:2,time:2000});
                return false;
            }
            var url = $('#member_form').attr('data-url');
            var load = '';
            $.ajax({
                url: url,
                type: "post",
                data: $("#member_form").serialize(),
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