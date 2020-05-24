<?php


namespace validate;
use Validate\BaseValidate;

class IDMustBePositiveInt extends BaseValidate{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];

    protected $message = [
        'id' => 'id不能为空',
    ];
}