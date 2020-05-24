<?php


namespace validate;
use Validate\BaseValidate;

class Test extends BaseValidate{
    protected $rule = [
        'id' => 'require|isMobile',
    ];

    protected $message = [
        'id'            => 'id不能为空',
        'id.isMobile'   => '手机号不正确',
    ];

}