/**
 * Created by mma on 2017/10/7.
 */
'use strict';
define(function (require, exports, module) {
    var element = layui.element(),
        device = layui.device(),
        form = layui.form(),
        layer = layui.layer;
    // 添加普通页面 from 监听
    $(function () {
        form.render();
    });
    module.exports = {
        'init':function(){
            this.bac();
        },
        'bac':function(){
                $("a[bac='bac']").unbind('click').on("click", function (e) {
                    e.preventDefault();
                    var load;
                    var jsonData = $.parseJSON($(this).attr('data-json'));
                    var href = $(this).attr('href');
                    if (jsonData.jump == 'true') {
                        window.location.href = href;
                    } else {
                        e.preventDefault();
                        $.ajax({
                            url: href,
                            type: 'get',
                            dataType: "html",
                            async:true,
                            beforeSend: function () {
                                load = layer.load(2);
                            },
                            success: function (data) {
                                layer.close(load);
                                var index = layer.open({
                                    type: 1, //1,2
                                    title: jsonData.name,
                                    skin: 'layui-layer-me', //样式类名
                                    area: (jsonData.size == undefined) ? ['600px', '50%'] : jsonData.size,
                                    shift: 0,
                                    shade: 0.6,
                                    id: 'LAY_layuipro', //设定一个id，防止重复弹出
                                    maxmin: true, //开启最大化最小化按钮
                                    content: !data ? '暂时没有数据' : data,
                                    btn: jsonData.haveBtn != undefined ? jsonData.haveBtn : ['保存', '取消'],
                                    yes: function (index, layero) {

                                        if (jsonData.hasOwnProperty('callback')) { //　加入回调 @祝海亮
                                            var callback = jsonData['callback'];
                                            if (callback.length > 0) {
                                                if (typeof window[callback] === 'function') {
                                                    window[callback]();
                                                    return false;
                                                }
                                                throw new TypeError('未找到或未定义 ' + callback + ' 方法');
                                            }
                                        } else {
                                            if (jsonData.closeLayer == 'true') {
                                                layer.close(index);
                                            } else {
                                                $('#layui-layer' + index).find('form').submit();
                                            }
                                        }

                                    },
                                    btn2: function (index, layero) {
                                        //取消按钮的回调事件，默认关闭弹窗
                                    }
                                });
                                form.render(); //更新全部
                            }
                        });
                    }
                });
        }
    };
})