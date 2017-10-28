<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/7
 * Time: 19:58
 */

namespace app\admin\model;

use app\lib\Str;
use think\Model;

class Base extends Model
{
    protected $path = STATIC_PATH . 'admin/json/navs.json';

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
     * @author mma5694@gmail.com
     * @date   2017年10月8日14:29:59
     */
    public function getOne($where = [])
    {
        return $this::get($where);
    }

    /**
     * 获取所有数据
     *
     * @param array $where
     * @param array $order
     *
     * @return array|false|static[]
     *
     * @author mma5694@gmail.com
     * @date
     */
    public function getAll($where = [], $order = [])
    {
        $data = $this->where($where)->order($order)->select();
        if ($data) {
            $data = collection($data)->toArray();
        }

        return empty($data) ? [] : $data;
    }

    /**
     * 根据条件砂囊少
     *
     * @param array $where
     *
     * @return int
     *
     * @author mma5694@gmail.com
     * @date   2017年10月17日23:15:47
     */
    public function deleteIt($where = [])
    {
        return $this::destroy($where);
    }

    /**
     * 生成一个8位随机字符
     * @param int $len
     * @param int $type
     *
     * @return string
     *
     * @author mma5694@gmail.com
     * @date 2017年10月17日23:18:31
     */
    public function salt($len = 8, $type = 0)
    {
        return Str::randString($len, $type);
    }
}