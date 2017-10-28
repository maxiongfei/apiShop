<?php

namespace app\admin\model;

use think\Exception;

class Member extends Base
{
    protected $table = "as_member";

    public function login($data)
    {
        try {
            if (empty($data['account']) || empty($data['password'])) {
                throw new Exception('用户名或密码不能为空');
            }
            $memberInfo = $this->getOne(['account' => $data['account']]);
            if (empty($memberInfo)) {
                throw new Exception('用户不存在');
            }

            if ($this->hasPassword($data['password'], $memberInfo['salt']) != $memberInfo['password']) {
                throw new Exception('用户名或密码错误');
            }

            return (['status' => 1, 'msg' => '登陆成功', 'data' => $memberInfo->toArray()]);
        } catch (Exception $e) {
            return ['status' => 0, 'msg' => $e->getMessage()];
        }
    }


    /**
     * 保存管理员
     *
     * @param $memberData
     *
     * @return array
     *
     * @author mma5694@gmail.com
     * @date   2017年10月17日23:44:50
     */
    public function saveMember($memberData)
    {
        $isUpdate = false;
        $salt = $this->salt(8, 0);
        $saveData = [
            'name'     => $memberData['name'],
            'password' => $this->hasPassword($memberData['password'], $salt),
            'salt'     => $salt,
        ];
        if (isset($memberData['id']) && !empty($memberData['id'])) {
            $saveData['id'] = $memberData['id'];
            $isUpdate = true;
        } else {
            $saveData['account'] = $memberData['account'];
        }
        /**
         *  添加事务
         */
        try {
            $this->startTrans();
            $res = $this->allowField(true)->isUpdate($isUpdate)->save($saveData);
            if ($isUpdate == false) {
                if (!$res) {
                    throw new Exception('用户添加失败');
                }
            } else {
                if ($res === false) {
                    throw new Exception('修改用户信息失败');
                }
            }

            $groupAccessModel = new GroupAccess();
            $res1 = $groupAccessModel
                ->allowField(true)
                ->isUpdate($isUpdate)
                ->save(['uid' => $this->id, 'group_id' => $memberData['group_id']]);
            if ($isUpdate == false) {
                if (!$res1) {
                    throw new Exception('权限分配失败');
                }
            } else {
                if ($res1 === false) {
                    throw new Exception('权限分配失败');
                }
            }
            $this->commit();

            return ['status' => '1', 'msg' => '成功'];

        } catch (Exception $e) {
            $this->rollback();

            return ['status' => 0, 'msg' => $e->getMessage()];
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
     * @author mma5694@gmail.com
     * @date   2017年10月17日23:21:51
     */
    public function hasPassword($password = '', $salt = '')
    {
        $password = $password ?: 123456;

        return md5(md5($password) . $salt);
    }

    /**
     * 删除用户及角色信息
     *
     * @param $uid
     *
     * @return array
     *
     * @author mma5694@gmail.com
     * @date   2017年10月19日22:43:05
     */
    public function deleteMember($uid)
    {
        try {
            $this->startTrans();
            $res = $this::destroy($uid);
            if ($res === false) {
                throw new Exception('删除失败');
            }
            $group = GroupAccess::get(['uid' => $uid]);
            $res2 = $group->delete();
            if (!$res2) {
                throw new Exception('删除角色信息失败');
            }
            $this->commit();

            return ['status' => 1, 'msg' => '用户删除成功'];
        } catch (Exception $e) {
            $this->rollback();

            return ['status' => 0, 'msg' => $e->getMessage()];
        }

    }

}