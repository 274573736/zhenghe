<?php


namespace app\apis\validate;


class GetOrderStatus extends BaseValidate
{
    protected $rule = [
        'order_num' => 'require|verifyOrderNum'
    ];

    protected $message = [
        'order_num' => '订单号有误'
    ];
}