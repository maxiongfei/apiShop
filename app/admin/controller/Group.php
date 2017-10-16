<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Group as GroupModel;
use app\admin\model\Menu as MenuModel;


class Group extends Controller
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new GroupModel();
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $groups = $this->model->getAll();

        return $this->fetch('index', ['groups' => $groups]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     *
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->post('title');
        $res = $this->model->saveGroup($data);
        $res['url'] = url('index');

        return json($res);
    }

    /**
     * 角色授权
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function read($id)
    {
        $menuModel = new MenuModel();
        $allMenus = $menuModel->getAll();
        $rules = $this->model->getOne(['id' => $id]);
        if (!empty($rules['rules'])) {
            $menusIds = explode(',', $rules['rules']);
            array_walk($allMenus, function (&$value) use ($menusIds) {
                if (in_array($value['id'], $menusIds)) {
                    $value['checked'] = "checked";
                }
            });
        }
        return view('read',['allMenus' => list_to_tree($allMenus, 'id', 'parent_id'),'id' =>$id]);

    }

    /**
     * 保存权限
     * @param Request $request
     *
     * @return \think\response\Json
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年10月16日23:16:13
     */
    public function saveAuthorize(Request $request)
    {
        $postData = $request->post();
        if (!empty($postData['node'])) {
            $ruleIds = implode(',', array_unique(explode(',', implode(',', $postData['node']))));
            if ($this->model->allowField(true)->save(['rules' => $ruleIds],['id' => $postData['id']]) !== false) {
                return json(['status' => 1, 'msg' => '成功', 'url' => url('index')]);
            } else {
                return json(['status' => 0, 'msg' => '失败']);
            }
        }else{
            return json(['status' => 0, 'msg' => '请勾选权限节点']);
        }

    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function edit($id)
    {
        $group = $this->model->getOne(['id' => $id]);

        return view('edit', ['group' => $group]);
    }

    /**
     * 更新资源
     *
     * @author xiongfei.ma@pactera.com
     * @date   2017年10月8日14:56:56
     */
    public function update()
    {
        $postData = $this->request->param();
        $res = $this->model->updateRecord($postData);
        $res['url'] = url('index');

        return json($res);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function delete($id)
    {
        $res = $this->model->deleteIt(['id' => $id]);
        if ($res !== false) {
            return json(['status' => 1, 'msg' => '删除成功', 'url' => url('index')]);
        } else {
            return json(['status' => 0, 'msg' => '删除失败']);
        }
    }
}
