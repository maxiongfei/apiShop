<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 18:00
 */

namespace app\admin\controller;


use app\admin\model\GroupAccess;
use app\admin\model\Group;
use think\Controller;
use think\Hook;
use think\Request;
use think\Session;
use app\admin\model\Menu;

class Base extends Controller
{


    protected $path = STATIC_PATH . 'admin/json/navs.json';
    protected $menus;

    public function __construct(Request $request = null)
    {

        parent::__construct($request);

        Hook::listen('checkLogin');
//        Hook::listen('checkAuth');
        define('uid', Session::get('admin.id'));
        $this->getMemberRoles();
        $this->assignData();
    }

    /**
     * 分配数据
     *
     * @author mma5694@gmail.com
     * @date 2017年10月28日22:29:12
     */
    public function assignData()
    {
        $this->assign([
                          'menus' => $this->menus
                      ]);
    }

    public function getMemberRoles()
    {
        $group = GroupAccess::get(['uid' => Session::get('admin.id')]);
        $access = Group::get($group->group_id);
        $menuModel = new Menu();
        $menus = $menuModel->refreshMenus();
        foreach ($menus as $key => $value) {
            if (!in_array($value['id'], explode(',', $access->rules))) {
                unset($menus[$key]);
            }
        }
        $menus = list_to_tree($menus, 'id', 'parent_id');
        $this->menus = $menus;
    }

}