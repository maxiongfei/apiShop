<?php

use \think\Session;
use \app\admin\model\Menu;
/**
 *
 * @param $url
 * @param $vars
 * @param $params
 *
 * $params = [
 *      'size'=>['600px', '50%'] 默认  宽 高
 *      'haveBtn'=>['好的','不好'] || '' 自定义btn
 *      'name'=>'添加用户'  按钮名称
 *      'class' => 按钮样式类
 *      'type' => 'void'  传入void  页面是否跳转
 *      'jump' => 'true'  直接跳转页面  不展示弹框  和  type 共存 可用于删除询问功能
 *      'closeLayer' => 'true'  自定义按钮后 关闭弹窗  用户 信息提示页面
 * ]
 *
 *
 * @return string
 *
 * @author 马雄飞 <mma5694@gmail.com>
 * @date
 */
function BAC($url, $vars, $params)
{
    $uid = Session::get('admin.id');
    $name = $params['name'];
    $status = false;
    $data = '';
    $urlArr = $tmp = explode('/', $url);
    $count = count($urlArr);
    switch ($count) {
        case 1:
            $urlArr[0] = request()->module();
            $urlArr[1] = request()->controller();
            $urlArr[2] = $url;
            break;
        case 2:
            $urlArr[0] = request()->module();
            $urlArr[1] = $tmp[0];
            $urlArr[2] = $tmp[1];
            break;
    }
    $url = implode('/', $urlArr);

    $auth = new \app\extend\auth\Auth();
    $groups = $auth->getGroups($uid);
    if (($groups[0]['uid'] == 1 && $groups[0]['title'] == 'supermen')) {
        $menuIds = [];
        foreach ($groups as $g) {
            $menuIds = array_merge($menuIds, explode(',', trim($g['rules'], ',')));
        }
        $menuModel = new Menu();
        $menu = $menuModel->getAll(['id'=>['in',$menuIds]]);
        foreach ($menu as $k => $v) {
            if (strtolower($v['name']) == strtolower($url)) {
                $status = true;
            }
        }
       /* //无需权限校验部分
        $allowName = array_map(function (&$val) {
            return strtolower($val);
        }, ('NOT_CHECK_URL'));
        if (in_array(strtolower($url), $allowName)) {
            $status = true;
        }*/
    } else {
        $status = true;
    }
    if ($status == false) {
        $url = 'javascript:void(0);';
        $name = '未授权';
    } else {
        $data = json_encode($params);
        $data = htmlentities($data, ENT_QUOTES, 'UTF-8');
        $url = url($url, $vars);
    }
    if (isset($params['type']) && $params['type'] == 'void') {
        return '<a href="' . 'javascript:void(0);' . '"url = ' . $url . ' class="' . $params['class'] . '" data-json="' . $data . '">' . $name . '</a>';
    } else {
        return '<a href="' . $url . '" bac="bac" class="' . $params['class'] . '" data-json="' . $data . '">' . $name . '</a>';
    }
}

function dd($arr, $break = 1)
{
    echo '<pre>';
    print_r($arr);
    echo "</pre>";
    if ($break) {
        exit();
    }
}

/**
 * 把返回的数据集转换成Tree
 *
 * @access public
 *
 * @param array  $list  要转换的数据集
 * @param string $pid   parent标记字段
 * @param string $level level标记字段
 *
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }

    return $tree;
}
