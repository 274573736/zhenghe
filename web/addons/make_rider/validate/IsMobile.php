<?php


namespace Validate;
use Validate\BaseValidate;

class IsMobile extends BaseValidate
{
    protected $rule = [
      'mobile'  => 'require|isMobile',
    ];

    protected $message = [
      'mobile' => '手机号不能为空',
    ];
}