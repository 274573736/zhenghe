<?php
namespace Validate\order;
use Validate\BaseValidate;

class AddTips extends  BaseValidate{
    protected $rule = [
        'id'        => 'require|isPositiveInteger',
        'tip_money' => 'require|isPositiveInteger',
        'pay_method'=> 'require|isPositiveInteger',
    ];

    protected $message = [
        'id'        => 'id不能为空',
        'tip_money' => '小费金额不能为空',
        'pay_method'=> '请选择支付方式',
    ];
}