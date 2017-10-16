<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 18:00
 */

namespace app\admin\controller;


use app\extend\auth\Auth;
use think\Controller;
use think\Request;

class Base extends Controller
{


    protected $path = STATIC_PATH .'admin/json/navs.json';
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if(!file_exists($this->path)){
            $menuModel = new \app\admin\model\Menu();
            $menuModel->refreshMenus();
        }


        /*$module = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        $auth = new Auth();
        if(!$auth->check($module . '/' . $controller . '/' . $action, session('uid'))){
            $this->error('你没有权限访问');
        }*/
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