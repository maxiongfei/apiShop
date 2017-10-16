<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Menu as MenuModel;

class Menu extends Base
{
    protected $model;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new MenuModel();
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        $menus = $this->model->getAll();
        $menus = list_to_tree($menus, 'id', 'parent_id');
        return view('index', ['menus' => $menus]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @param Request $request
     *
     * @return \think\response\View
     *
     * @author xiongfei.ma@pactera.com
     * @date   2017-10-10 22:08:21
     */
    public function create(Request $request)
    {
        return view('create', ['data' => $request->param()]);
    }

    public function action(Request $request)
    {
        $data = $request->param();
        $actions = $this->model->getAll(['parent_id' => $data['id']]);
        return view('action', ['data' => $data, 'actions' => $actions]);
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
        if ($this->request->isPost()) {
            $data = $request->param();
            $res = $this->model->saveMenu($data);
            $res['url'] = url('index');

            return json($res);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function read($id)
    {
        //
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
        $menu = $this->model->getOne(['id' => $id]);

        return view('edit',['menu'=>$menu]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int            $id
     *
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            return json(['status' => 1, 'msg' => '删除成功' ,'url' => url('index')]);
        } else {
            return json(['status' => 0, 'msg' => '删除失败']);
        }
    }
}
