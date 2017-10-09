'use strict';
define(function (require, exports, module) {
    var laypage = layui.laypage;
    module.exports = {
        deleteGroup:function(){
            $(".j-deleteRole").click(function(){
                var url  = $(this).attr('url');
                layer.confirm('确定删除该角色？', {
                    btn: ['删除', '取消']
                }, function(index, layero){
                    var load = '';
                    $.ajax({
                        url: url,
                        type: "get",
                        data: $("#role_form").serialize(),
                        beforeSend: function () {
                            load = layer.load(2);
                        },
                        success: function (res) {
                            layer.close(load);
                            if (res.status) {
                                layer.msg(res.status, {icon: 1, time: 1000}, function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(res.status, {icon: 2, time: 2000});
                            }
                        }
                    });
                }, function(index){
                });
            });
        },
        pages:function(info,url){
            laypage({
                cont: $("#page")
                ,pages: info.totalPages //总页数
                ,groups: info.pageSize //连续显示分页数
                ,curr: info.p
                ,jump: function (obj, first) {
                    if(first!==true){ //是否首次进入页面
                        var p = obj.curr; //获取点击的页码
                        window.location.href = url+"&p="+p;
                    }
                }
            });
        }
    }
});