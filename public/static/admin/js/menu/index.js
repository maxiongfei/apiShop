'use strict';
define(function (require, exports, module) {
    module.exports = {
        init:function(){
            require('treeTable');
            $("#fold-table").treetable({ expandable: true });
            // this.deleteMenu();
        },
        deleteMenu:function(){
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

    }
});