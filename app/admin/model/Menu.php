<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/8
 * Time: 20:08
 */

namespace app\admin\model;


use think\Session;

class Menu extends Base
{
    protected $table = "as_auth_rule";
    protected $pk = 'id';

    public function saveMenu($data)
    {
        $res = false;
        //子菜单或者节点添加
        if(isset($data['parent_id']) && !empty($data['parent_id'])){
            if(isset($data['mark']) && !empty($data['mark']) && $data['mark'] == 'menu'){
                //添加子菜单
                unset($data['mark']);
                $res = $this->saveMenuOnly($data);
            }elseif(isset($data['mark']) && !empty($data['mark']) && $data['mark'] == 'node'){
                //添加子节点
                unset($data['mark']);
                if (!empty($data['old'])) {
                    $saveMenu = [];
                    array_walk($data['old'], function ($val, $k) use (&$saveMenu, $data) {
                        $saveMenu[$k]['id'] = $val['id'];
                        $saveMenu[$k]['parent_id'] = $data['parent_id'];
                        $saveMenu[$k]['title'] = htmlspecialchars($val['title'], ENT_QUOTES, 'UTF-8');
                        $saveMenu[$k]['name'] = htmlspecialchars($val['name'], ENT_QUOTES, 'UTF-8');
                        $saveMenu[$k]['sort'] = (int)$val['sort'];
                        $saveMenu[$k]['is_show'] = (int)$val['is_show'];
                    });
                    $res1 = $this->saveAll(array_values($saveMenu));
                    if($res1 === false){
                        return ['status' => 0, 'msg' => '原节点菜单添加失败'];
                    }
                }
                if (!empty($data['new'])) {
                    $addMenu = [];
                    array_walk($data['new'], function ($val, $k) use (&$addMenu, $data) {
                        $addMenu[$k]['parent_id'] = $data['parent_id'];
                        $addMenu[$k]['title'] = htmlspecialchars($val['title'], ENT_QUOTES, 'UTF-8');
                        $addMenu[$k]['name'] = htmlspecialchars($val['name'], ENT_QUOTES, 'UTF-8');
                        $addMenu[$k]['sort'] = (int)$val['sort'];
                        $addMenu[$k]['is_show'] = (int)$val['is_show'];
                    });
                    $res2 = $this->saveAll(array_values($addMenu));
                    if($res2 === false){
                        return ['status' => 0, 'msg' => '添加节点菜单失败'];
                    }
                }
                return ['status' => 1, 'msg' => '添加成功'];
            }

        }else{
            //主菜单添加
            $res = $this->saveMenuOnly($data);
        }
        if ($res !== false) {
            $this->refreshMenus();
            return ['status' => 1, 'msg' => '成功'];
        } else {
            return ['status' => 0, 'msg' => '失败'];
        }
    }
    public function saveMenuOnly($data)
    {
        $isUpdate = false;
        if(isset($data['id']) && !empty($data['id'])){
            $isUpdate = true;
        }
        return $this->isUpdate($isUpdate)->allowField(true)->save($data);
    }

    /**
     * 更新menu
     *
     * @author mma5694@gmail.com
     * @date 2017年10月15日14:16:12
     */
    public function refreshMenus()
    {
        $menus = $this->getAll(['type' => 1,'is_show' => 1],['sort'=>'asc']);
        /*array_walk($menus,function(&$val){
            if(!empty($val['name'])){
                $val['name'] = url($val['name']);
            }
        });*/
        return $menus;
    }
}