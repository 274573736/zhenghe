<?php


namespace Validate\app;
use Validate\BaseValidate;

class Login extends BaseValidate
{
    protected $rule = [
        'mobile'    => 'require|isMobile',
        'code'      => 'require|isPositiveInteger|length:4'
    ];

    protected $message = [
        'mobile'      => '手机号不能为空',
        'code'        => '验证码不能为空',
        'code.length' => '请输入四位正整数验证码',
    ];
}