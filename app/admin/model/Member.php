<?php

namespace app\admin\model;

class Member extends Base
{
    protected $table = "as_member";

    /**
     * 保存管理员
     * @param $memberData
     *
     * @return array
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年10月17日23:44:50
     */
    public function saveMember($memberData)
    {
        $salt = $this->salt(8, 0);
        $saveData = [
            'account'  => $memberData['account'],
            'name'     => $memberData['name'],
            'password' => $this->hasPassword($memberData['password'], $salt),
            'salt'     => $salt,
        ];
        /**
         *  添加事务
         */
        $res = $this->allowField(true)->save($saveData);
        if ($res) {
            $groupAccessModel = new GroupAccess();
            $res1 = $groupAccessModel->allowField(true)->save(['uid' => $this->id, 'group_id' => $memberData['group_id']]);
            if($res1){
                return ['status' => '1','msg' => '成功'];
            }else{
                return ['status' => '0','msg' => '权限分配失败'];
            }
        }else{
            return ['status' => '0','msg' => '用户添加失败'];
        }

    }

    /**
     * 生成用户密码
     *
     * @param string $password
     * @param string $salt
     *
     * @return string
     *
     * @author xiongfei.ma@pactera.com
     * @date   2017年10月17日23:21:51
     */
    public function hasPassword($password = '', $salt = '')
    {
        $password = $password ?: 123456;

        return md5(md5($password) . $salt);
    }

}