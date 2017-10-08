<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/8
 * Time: 20:08
 */

namespace app\admin\model;


class Menu extends Base
{
    protected $table = "as_auth_rule";
    protected $pk = 'id';

    public function saveMenu($data)
    {
        $res = $this->allowField(true)->save($data);
        if ($res) {
            return ['status' => 1, 'msg' => '添加成功'];
        } else {
            return ['status' => 0, 'msg' => '添加失败'];
        }
    }
}