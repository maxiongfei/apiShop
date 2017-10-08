<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 19:57
 */

namespace app\admin\model;

class Role extends Base
{
    public function saveRole($roleName = '')
    {
        if($roleName){
            $this->title = $roleName;
        }
    }
}