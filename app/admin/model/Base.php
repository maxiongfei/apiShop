<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 19:58
 */

namespace app\admin\model;

use think\Model;

class Base extends Model
{
    protected $path = STATIC_PATH .'admin/json/navs.json';

    //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    /**
     * 获取一条记录
     *
     * @param $where
     *
     * @return null|static
     *
     * @author xiongfei.ma@pactera.com
     * @date   2017年10月8日14:29:59
     */
    public function getOne($where = [])
    {
        return $this::get($where);
    }

    /**
     *
     * @param array $where
     *
     * @return array|false|static[]
     *
     * @author xiongfei.ma@pactera.com
     * @date
     */
    public function getAll($where = [],$order = [])
    {
        $data = $this->where($where)->order($order)->select();
        if($data) {
            $data = collection($data)->toArray();
        }
        return empty($data) ? [] : $data;
    }

    public function deleteIt($where = [])
    {
        return $this::destroy($where);
    }
}