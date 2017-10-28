<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 19:57
 */

namespace app\admin\model;

class Group extends Base
{
    protected $table = "as_auth_group";


    /**
     * 保存
     *
     * @param string $roleName
     *
     * @return array
     *
     * @author mma5694@gmail.com
     * @date   2017-10-8 14:28:43
     */
    public function saveGroup($roleName = '')
    {
        if ($roleName) {
            $record = $this::get(['title' => $roleName]);
            if (empty($record)) {
                $this->title = $roleName;
                $res = $this->save();
                if($res){
                    return ['status' => 1, 'msg' => '添加成功'];
                }else{
                    return ['status' => 0, 'msg' => '添加失败'];
                }
            } else {
                return ['status' => 0, 'msg' => '角色名已存在'];
            }
        }else{
            return ['status' => 0, 'msg' => '角色名不能为空'];
        }
    }

    /**
     * 更新
     *
     * @param $data
     *
     * @return array
     *
     * @author mma5694@gmail.com
     * @date   2017年10月8日15:27:52
     */
    public function updateRecord($data)
    {
        if (empty($data['id'])) {
            return false;
        }
        $record = $this::get(['title' => $data['title']]);
        if(!empty($record)){
            if($record['id'] == $data['id']){
                $stop = false;
            }else{
                $stop = true;
            }
        }else{
            $stop = false;
        }
        if(!$stop){
            $res = $this->allowField(true)->save($data, ['id' => $data['id']]);
            if($res !== false){
                return ['status' => 1,'msg' => '修改成功'];
            }else{
                return ['status' => 0,'msg' => '修改失败'];
            }
        }else{
            return ['status' => 0,'msg' => '角色名称已存在'];
        }
    }


}