<?php


namespace app\api\validate;


class Mobile extends BaseValidate
{
    protected $rule = [
        'mobile'    => 'require|isMobile',
    ];

    protected $message = [
        'mobile.isMobile' => '手机号格式不正确',
    ];

}