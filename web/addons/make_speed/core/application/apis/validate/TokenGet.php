<?php


namespace app\apis\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'token' => 'require|isNotEmpty',
        'appid' => 'require|isNotEmpty',
    ];

    protected $message=[
        'token' => 'token不能为空',
        'appid' => 'appid不能为空',
    ];
}