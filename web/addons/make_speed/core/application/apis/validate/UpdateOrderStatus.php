<?php


namespace app\apis\validate;


class UpdateOrderStatus extends BaseValidate
{
    protected $rule = [
        'order_num' => 'require|verifyOrderNum',
        'status'     => 'require|verifyOrderStatus',
    ];

    protected $message = [
        'order_num' => '订单号不能为空',
        'status'     => '更新状态不能为空'
    ];

    protected function verifyOrderStatus($value){
        $text = array('loading','cancel','payed');//（'loading':等待付款(添加订单时默认状态)；'cancel':订单取消；'payed':订单已付款；'completed':完成订单)
        $status = array_search($value, $text);
        if(!isset($status)){
            return '订单状态值有误';
        }
        return true;
    }
}