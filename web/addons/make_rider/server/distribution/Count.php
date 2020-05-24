<?php


namespace Server\distribution;


class Count{

    //统计下线人数
    public static function referrals($list,$user_id){
        static $count = 0;
        if( $list && is_array( $list) ){
            foreach ($list as $k=>$v){
                if( $v['pid'] == $user_id ){
                    $count ++ ;
                    self::referrals($list,$v['user_id']);
                }
            }
        }
        return $count;
    }

    //统计分销订单总额
    public static function amount($user_id){
        $re = pdo_get('make_speed_distribution_order',[ 'user_id' => $user_id,'status' => 2 ],['SUM(price) as count']);
        return !empty($re['count']) ? sprintf('%.2f',$re['count']) : 0;
    }


    //统计分销订单完成数
    public static function complete($user_id){
        $re = pdo_get('make_speed_distribution_order',[ 'user_id' => $user_id,'status' => 2 ],[ 'COUNT(*) as count' ]);
        return !empty($re['count']) ? $re['count'] : 0;
    }
}