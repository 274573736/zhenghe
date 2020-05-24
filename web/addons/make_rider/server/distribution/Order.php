<?php
namespace Server\distribution;

class Order{
    //分销完成订单
    public static function complateOrder($order_id){
        $order = pdo_getall('make_speed_distribution_order',[ 'order_id'=>$order_id ,'status <>'=>[0,2,3] ]);

        if(!$order){ return false; }

        //佣金结算  更新订单数据不会超过三条
        foreach ( $order as $k=>$v ){
            pdo_begin();
            $update_dis = pdo_update('make_speed_distribution_distributor',[
                'commission +='       => $v['commission'],
                'count_commission +=' => $v['commission'],
            ],[ 'user_id' => $v['user_id'] ]);

            $update_order =pdo_update('make_speed_distribution_order',['status' => 2],[ 'user_id'=>$v['user_id'],'order_id'=>$v['order_id'],'status <>'=>[0,2,3]  ]);
            if( $update_dis && $update_order ){
                pdo_commit();
            }else{
                pdo_rollback();
            }
        }

        $user_ids = array_column($order,'user_id');
        ( new \Server\distribution\LevelUp())->isLevelUp($user_ids);
    }

    public static function updateOrder($id,$status=1){
        $re = pdo_update('make_speed_distribution_order',[ 'status' => $status ],[ 'order_id' => $id ]);
        if($re){
            return true;
        }
        return false;
    }

}