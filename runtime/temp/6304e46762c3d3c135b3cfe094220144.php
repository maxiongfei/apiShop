<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:55:"H:\www\apiShop\public/../app/admin\view\menu\index.html";i:1508167607;s:58:"H:\www\apiShop\public/../app/admin\view\layout\layout.html";i:1507354959;s:58:"H:\www\apiShop\public/../app/admin\view\public\header.html";i:1507560874;s:58:"H:\www\apiShop\public/../app/admin\view\public\footer.html";i:1507448434;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--<meta name="apple-mobile-web-app-capable" content="yes">-->
    <meta name="format-detection" content="telephone=no">
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <!--<link rel="icon" href="__STATIC__/admin/image/favicon.ico">-->
    <link rel="stylesheet" type="text/css" href="__STATIC__/admin/plugin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_tnyc012u2rlwstt9.css" media="all" />
    <script type="text/javascript" src="__STATIC__/admin/plugin/layui/lay/dest/layui.all.js"></script>
    <script type="text/javascript" src="__STATIC__/common/plugin/seajs-2.2.3/dist/sea.js"></script>
    <script>

        ;!function (staticPath) {
            "use strict";
            seajs.config({
                base: staticPath,
                paths: {
                    admin_js: staticPath+'/admin/js',
                    static_path:staticPath
                },
                alias: {
                    'jquery':'https://cdn.bootcss.com/jquery/3.2.1/jquery.js',
                    'treeTable':"static_path/common/plugin/jquery-treetable/jquery.treetable",
                },
                preload: [
                    'jquery'
                ],
                'map': [
                    [/^(.*\.(?:css|js))(.*)$/i, '$1?' + (new Date()).valueOf()]
                ],
                debug: true,
                charset: 'utf-8'
            });
        }('__STATIC__');
        seajs.use('admin_js/init',function(init){
            init.init();
        });
    </script>
</head>
<body class="childrenBody">
    <link href="__STATIC__/common/plugin/jquery-treetable/css/jquery.treetable.css" rel="stylesheet">
    <style>
        table.treetable tr.collapsed span.indenter a {
            background-image: url('__STATIC__/admin/images/add.png');
        }
        table.treetable tr.expanded span.indenter a {
            background-image: url("__STATIC__/admin/images/close.png");
            /*background-image: url("http://html.pacteracmf.51unite.com/Common/plugins/jquery-treetable/images/minus.jpg");*/


        }
    </style>

<blockquote class="layui-elem-quote">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="" placeholder="请输入关键字" class="layui-input search_input">
        </div>
        <a class="layui-btn search_btn">查询</a>
    </div>
    <div class="layui-inline">
        <?php echo BAC('Menu/create','',['name'=>'添加菜单','callback'=>'addMenu','size'=>['40%', '60%'],'class'=>"layui-btn layui-btn-normal"]); ?>
    </div>
</blockquote>
<div class="layui-form news_list">
    <table class="layui-table" id="fold-table">
        <colgroup>
            <col width="50">
            <col width="9%">
            <col width="9%">
            <col width="9%">
            <col width="20%">
        </colgroup>
        <thead>
        <tr>
            <th width="20%">菜单名称</th>
            <th width="20%">排序</th>
            <th width="20%">是否展开</th>
            <th width="40%">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($menus as $menu): ?>
                <tr data-tt-id="<?php echo $menu['id']; ?>">
                    <td><?php echo $menu['title']; ?></td>
                    <td><?php echo $menu['sort']; ?></td>
                    <td><?php echo $menu['is_spread']; ?></td>
                    <td>
                        <?php echo BAC('Menu/create',['parent_id'=>$menu['id']],['name'=>'添加子菜单','callback'=>'addMenu','size'=>['40%', '60%'],'class'=>"layui-btn layui-btn-normal  layui-btn-mini"]); ?>
                        <?php echo BAC('Menu/edit',['id'=>$menu['id']],['name'=>'编辑菜单','callback'=>'addMenu','size'=>['40%', '60%'],'class'=>"layui-btn layui-btn-mini"]); if(empty($menu['_child']) || (($menu['_child'] instanceof \think\Collection || $menu['_child'] instanceof \think\Paginator ) && $menu['_child']->isEmpty())): ?>
                            <?php echo BAC('Menu/delete',['id'=>$menu['id']],['name'=>'删除菜单','type'=>'void','class'=>"layui-btn layui-btn-danger layui-btn-mini j-deleteMenus"]); endif; ?>
                    </td>
                </tr>
                <?php if(!(empty($menu['_child']) || (($menu['_child'] instanceof \think\Collection || $menu['_child'] instanceof \think\Paginator ) && $menu['_child']->isEmpty()))): foreach($menu['_child'] as $var): ?>
                        <tr data-tt-id="<?php echo $var['id']; ?>" data-tt-parent-id="<?php echo $var['parent_id']; ?>">
                            <td>|----<?php echo $var['title']; ?></td>
                            <td><?php echo $var['sort']; ?></td>
                            <td><?php echo $var['is_spread']; ?></td>
                            <td>
                                <?php echo BAC('Menu/action',['parent_id'=>$var['id'],'id'=>$var['id']],['name'=>'添加子节点','callback'=>'addActions','size'=>['80%', '80%'],'class'=>"layui-btn layui-btn-normal  layui-btn-mini"]); ?>
                                <?php echo BAC('Menu/edit',['id'=>$var['id']],['name'=>'编辑菜单','callback'=>'addMenu','class'=>"layui-btn layui-btn-mini"]); if(empty($var['_child']) || (($var['_child'] instanceof \think\Collection || $var['_child'] instanceof \think\Paginator ) && $var['_child']->isEmpty())): ?>
                                    <?php echo BAC('Menu/delete',['id'=>$var['id']],['name'=>'删除子菜单','type'=>'void','class'=>"layui-btn layui-btn-danger layui-btn-mini j-deleteMenu"]); endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; endforeach; ?>
        </tbody>
    </table>
</div>
<div id="page"></div>
<script>
    seajs.use('admin_js/menu/index', function (index) {
        index.init();
    });
</script>

</body>
</html>