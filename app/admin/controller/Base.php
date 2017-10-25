<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 18:00
 */

namespace app\admin\controller;


use think\Controller;
use think\Hook;
use think\Request;

class Base extends Controller
{


    protected $path = STATIC_PATH .'admin/json/navs.json';
    public function __construct(Request $request = null)
    {

        parent::__construct($request);

        Hook::listen('checkLogin');
        Hook::listen('checkAuth');

        if(!file_exists($this->path)){
            $menuModel = new \app\admin\model\Menu();
            $menuModel->refreshMenus();
        }


        /**/
    }
    public function menu2()
    {
        $this->assign('menus',$this->menus);
        /*<ul class="layui-nav layui-nav-tree">
            {foreach $menus as $menu}
            <li class="layui-nav-item {eq name="menu['is_spread']" value="1"}layui-nav-itemed{/eq} ">
                <a href="javascript:;" data-url="{:url($menu['name'])}">
                    <i class="iconfont icon-computer" data-icon="{$menu.icon}"></i>
                    <cite>{$menu.title}</cite>
                </a>
                {if condition="isset($menu['_child']) && empty($menu['child'])"}
                <dl class="layui-nav-child">
                    {foreach $menu['_child'] as $m}
                    <dd>
                        <a href="javascript:;" data-url="{:url($m['name'])}">
                            <i class="layui-icon" data-icon="{$m.icon}"></i>
                            <cite>{$m.title}</cite>
                        </a>
                    </dd>
                    {/foreach}
                </dl>
                {/if}
            </li>
            {/foreach}
        </ul>*/
    }

}