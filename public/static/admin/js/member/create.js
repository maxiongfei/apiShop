'use strict';
define(function (require, exports, module) {
    module.exports = {
        addMember:function(){
            var account = $('.member_account').val();
            if(!account){
                layer.msg('请输入账号',{icon:2,time:2000});
                return false;
            }
            if(!(/^[A-Za-z0-9]+$/).test(account)){
                layer.msg('账号格式不正确',{icon:2,time:3000});
                $('.member_account').attr('placeholder','账号格式不正确,字母或数字');
                return false;
            }
            var account = $('.member_name').val();
            var password = $('.member_password').val();
            if(!account){
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
                type: "POST",
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