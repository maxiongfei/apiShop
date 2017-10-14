'use strict';
define(function (require, exports, module) {
    var form = layui.form();
    module.exports = {
        init:function(){
            this.addActionTable();
            this.deleteActionTable();
        },
        addActionTable:function(){
            var action_num = 0;
            $(".action-add-btn").on('click',function(){
                action_num ++ ;
                var html = `<tr>
                    <td><input type="text"  class="layui-input" name="new[${action_num}][title]"></td>
                    <td><input type="text" class="layui-input" name="new[${action_num}][name]"></td>
                    <td><input type="text" class="layui-input" name="new[${action_num}][sort]"></td>
                    <td>
                    <select name="new[${action_num}][is_show]">
                    <option value="1" >显示</option>
                    <option value="2" >隐藏</option>
                    </select>
                    </td>
                    <td>
                    <a class="layui-btn layui-btn-danger action-delete-btn">删除</a>
                    </td>
                    </tr>`;
                $(".action-table").append(html);
                form.render(); //更新全部
            });
        },
        deleteActionTable:function()
        {
            $(".action-table").on('click','.action-delete-btn',function(e){
                $(this).parents('tr').remove();
            });
        },
        addActions:function(){
            /*var title = $('.menu_title').val();
            if(!title){
                layer.msg('请输入菜单名称',{icon:2,time:2000});
                return false;
            }
            var title = $('.icon_title').val();
            if(!title){
                layer.msg('请输入icon名称',{icon:2,time:2000});
                return false;
            }
            if(!(/^[A-Za-z0-9\u4e00-\u9fa5]+$/).test(title)){
                layer.msg('角色名称输入不合法',{icon:2,time:3000});
                $('.role_title').attr('placeholder','角色名称输入不合法,请重新输入');
                return false;
            }*/
            var url = $('#action_form').attr('data-url');
            var load = '';
            $.ajax({
                url: url,
                type: "POST",
                data: $("#action_form").serialize(),
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