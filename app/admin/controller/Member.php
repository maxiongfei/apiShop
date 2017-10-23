<?php

namespace app\admin\controller;

use app\admin\model\GroupAccess;
use think\Request;
use app\admin\model\Group;
use app\admin\model\Member as MemberModel;

class Member extends Base
{

    protected $model;
    protected $groupModel;
    protected $groupAccessModel;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new MemberModel();
        $this->groupModel = new Group();
        $this->groupAccessModel = new GroupAccess();
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $members = $this->model->getAll(['is_del' => 0]);
        $memberIds = array_column($members, 'id');
        if (!empty($memberIds)) {
            $groupAccessData = $this->groupAccessModel->getAll(['uid' => ['in', $memberIds]]);
            array_walk($members, function (&$value) use ($groupAccessData) {
                foreach ($groupAccessData as $k => $v) {
                    if ($value['id'] == $v['uid']) {
                        $value['group_id'] = $v['group_id'];
                    }
                }
            });
            $groupIds = array_column($groupAccessData, 'group_id');
            if (!empty($groupIds)) {
                $groupData = $this->groupModel->getAll(['id' => ['in', $groupIds]]);
                array_walk($members, function (&$value) use ($groupData) {
                    foreach ($groupData as $k => $v) {
                        if ($value['group_id'] == $v['id']) {
                            $value['group_name'] = $v['title'];
                        }
                    }
                });
            }
        }


        return view('index', ['members' => $members]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $groups = $this->groupModel->getAll();

        return view('create', ['groups' => $groups]);
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
        $result = $this->model->saveMember($request->post());
        $result['url'] = url('index');

        return json($result);
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
        $groups = $this->groupModel->getAll();
        $member = $this->model->getOne(['id' => $id]);
        $groupInfo = $this->groupAccessModel->getOne(['uid' => $member['id']]);
        $member['group_id'] = $groupInfo['group_id'];

        return view('edit', ['member' => $member, 'groups' => $groups]);
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
        $res = $this->model->saveMember($request->post());

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
        $res = $this->model->deleteMember($id);

        return json($res);
    }
}
