<?php
namespace app\admin\controller;

use think\Exception;
use think\Request;
use app\admin\model\Member;
use think\captcha\Captcha;
class Login
{
    protected $model;
    public function __construct()
    {
        $this->model = new Member();
    }

    public function index()
    {
        return view('index');
    }
    public function login(Request $request)
    {
        $postData = $request->param();
        try{
            $captcha = new Captcha();
            if(!$captcha->check($postData['code'])){
                throw new Exception('验证码错误');
            };
            unset($postData['code']);
            $loginResult = $this->model->login($postData);
            if($loginResult['status'] != 1) {
                throw new Exception($loginResult['msg']);
            }
            session('admin', $loginResult['data']);
            unset($loginResult['data']);
            $loginResult['url'] = url('Index/index');
            return json($loginResult);
        }catch (Exception $e){
            return json(['status' => 0 ,'msg' => $e->getMessage()]);
        }
    }
}