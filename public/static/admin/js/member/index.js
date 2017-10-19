'use strict';
define(function (require, exports, module) {
    var laypage = layui.laypage;
    module.exports = {
        deleteMember:function(){
            $(".j-deleteMember").click(function(){
                var url  = $(this).attr('url');
                layer.confirm('确定删除该用户？', {
                    btn: ['删除', '取消']
                }, function(index, layero){
                    var load = '';
                    $.ajax({
                        url: url,
                        type: "get",
                        beforeSend: function () {
                            load = layer.load(2);
                        },
                        success: function (res) {
                            layer.close(load);
                            if (res.status) {
                                layer.msg(res.msg, {icon: 1, time: 1000}, function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(res.msg, {icon: 2, time: 2000});
                            }
                        }
                    });
                }, function(index){
                });
            });
        },
    }
});