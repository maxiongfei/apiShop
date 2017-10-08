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

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        /*$module = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        $auth = new Auth();
        if(!$auth->check($module . '/' . $controller . '/' . $action, session('uid'))){
            $this->error('你没有权限访问');
        }*/
    }
}