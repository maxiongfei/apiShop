'use strict';
define(function (require, exports, module) {
    var form = layui.form();
    //全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parent().parent().parent().next('tbody').find('input[type="checkbox"]');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
    module.exports = {
        authorizeRole: function () {
            var url = $('#authorize_form').attr('data-url');
            var load = '';
            $.ajax({
                url: url,
                type: "POST",
                data: $("#authorize_form").serialize(),
                beforeSend: function () {
                    load = layer.load(2);
                },
                success: function (res) {
                    layer.close(load);
                    if (res.status) {
                        layer.msg(res.msg, {icon: 1, time: 2000}, function () {
                            window.location.href = res.url;
                        });
                    } else {
                        layer.msg(res.msg, {icon: 2, time: 2000});
                    }
                }
            });
        }
    }
});