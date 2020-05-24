<?php


namespace Server;


class Order
{
    //代驾订单修改
    public function designateDriverUpdate($order){
        //查询是否有进行中订单
        $driverOrder = pdo_get('make_speed_order_rider',['order_id' => $order['id'] ],['goto_time','rider_id']);
        if(!$driverOrder || !isset($driverOrder['goto_time']) ){
            msg('订单未送达,无法支付');
        }
        //修改订单为已完成
        $re = pdo_update('make_speed_order',['status'=>5],[ 'id' => $order['id'] ]);
        if(!$re){
            msg('订单修改失败');
        }
        riderGotoOrder($order['id'],$driverOrder['rider_id']);
    }


}