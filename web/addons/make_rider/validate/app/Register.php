<?php


namespace Validate\app;
use Validate\BaseValidate;

class Register extends BaseValidate
{
    protected $rule = [
        'username'  => 'require|chs|length:2,4',
        'mobile'    => 'require|isMobile',
        'smscode'   => 'require|isPositiveInteger|length:4'
    ];

    protected $message = [
        'mobile'         => '手机号不能为空',
        'mobile.isMobile'=> '手机号码格式不正确',
        'smscode'        => '验证码不能为空',
        'username'       => '用户名不能为空',
        'username.chs'   => '用户名只能输入中文',
        'username.length'=> '用户名只能输入2到4位汉字！',
        'smscode.length' => '请输入四位正整数验证码',
    ];
}