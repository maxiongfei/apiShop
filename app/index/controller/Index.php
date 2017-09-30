<?php
namespace app\index\controller;

use think\Env;

class Index
{
    public function index()
    {
        dump($_ENV);
        dump(Env::get('database.username'));
    }
}
