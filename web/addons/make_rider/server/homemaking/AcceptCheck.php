<?php


namespace Server\homemaking;


class AcceptCheck{

    public static function homemaking($category_id,$rider_id = 0)
    {
        empty($rider_id) && $rider_id = $GLOBALS['CURRENT_RIDER'];

        $technician = pdo_get('make_speed_homemaking_technician',[ 'rider_id' => $rider_id  ],['status','category_id']);
        if(!$technician){
            msg('接单失败！您尚未认证家政技师!');
        }
        if( $technician['status'] != 2){
            msg('接单失败，认证技师审核未通过！');
        }

        $technician = explode(',',$technician['category_id']);
        if( !in_array( $category_id,$technician) ){
           msg('用户下单服务类目与您认证类目不匹配！');
        }
    }

    public static function freight($order,$rider_id = 0)
    {
        empty($rider_id) && $rider_id = $GLOBALS['CURRENT_RIDER'];

        $where  = [ 'rider_id' =>  $rider_id ];
        $filed  = ['status','car_id'];
        $driver = pdo_get('make_speed_rider_fdriver',$where,$filed);

        if(!$driver || (int)$driver['status'] !== 1){
             msg('接单失败！您尚未认证完成货运司机');
        }

        $cars = explode(',',$driver['car_id']);
        if( !in_array( $order['car_id'],$cars) ){
            msg('用户下单车型与您车型不匹配!');
        }

        //现金支付订单
        if($order['payment'] == 3){
            //计算骑手所扣除的佣金
            $riderCommission = pdo_get('make_speed_setting',array( 'key'=>'rider_wages','uniacid'=>$GLOBALS['uniacid'] ),array('value'));
            $commission = (sprintf('%.2f', $riderCommission['value']) > 0) ? sprintf('%.2f', $riderCommission['value']) : 0.8;
            $price      =  sprintf('%.2f', $order['total_price'] * $commission);

            $commission = $order['total_price'] - $price;

            //查看骑手余额是否有足够余额进行扣款
            $freightDriver = pdo_get('make_speed_rider',[ 'id' => $rider_id ],['valid_money']);

            if($freightDriver['valid_money'] < $commission){
                msg('没有足够余额进行扣款,无法接现金支付单！');
            }
        }
    }
}