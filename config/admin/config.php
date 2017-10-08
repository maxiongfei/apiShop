<?php
/**
 * Created by PhpStorm.
 * User: mma
 * Date: 2017/10/6
 * Time: 22:12
 */
return [
    'template'  =>  [
        'layout_on'     =>  true,
        'layout_name'   =>  'layout/layout',
    ],
    'AUTH_CONFIG' => array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'as_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'as_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'as_auth_rule', //权限规则表
        'AUTH_USER' => 'as_user'//用户信息表
    )
];