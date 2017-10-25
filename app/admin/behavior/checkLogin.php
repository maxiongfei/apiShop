<?php

namespace app\admin\behavior;

use think\Session;
use traits\controller\Jump;

class checkLogin
{
    use Jump;
    public function run()
    {
       if(!Session::has('admin')){
            $this->error('请先登录',url('Login/index'));
       }
    }
}