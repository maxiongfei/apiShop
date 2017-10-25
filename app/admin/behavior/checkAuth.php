<?php

namespace app\admin\behavior;

use app\extend\auth\Auth;
use think\Request;
use think\Session;
use traits\controller\Jump;

class checkAuth
{
    use Jump;
    public function run()
    {
        $request = Request::instance();
        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        $name = $module . '/' . $controller . '/' . $action;
        if(!in_array(strtolower($name),['admin/index/index'])){
            $auth = new Auth();
            if(!$auth->check($name, Session::get('admin.id'))){
                exit('没有权限');
            }
        }

    }
}