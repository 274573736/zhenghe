<?php

/**
 * 是否能接单
 * @param int $rider_id
 * @return bool
 */
function isAcceptOrder($rider_id = 0){
    !$rider_id && $rider_id = $GLOBALS['CURRENT_RIDER'];
    $designateDriver = pdo_get('make_speed_rider_driver',['rider_id'=> $rider_id ],['tid']);

    if(!$designateDriver || empty($designateDriver['tid'] ) ){
        msg('您的终端ID未生成，请联系管理员生成！');
    }
    $where  = "r.rider_id = :rider_id AND o.status in(3,4) AND o.charg_type = :type";
    $sql    = "SELECT COUNT(*) as count FROM " .tablename('make_speed_order_rider') ." AS r INNER JOIN " .tablename('make_speed_order') ." AS o ON r.order_id = o.id WHERE $where ";
    $params = [
        ':rider_id' => $rider_id,
        ':type'     => 2,
    ];
    $count  = pdo_fetch($sql, $params);
    if($count['count'] > 0){
        msg('实时计费代驾进行中订单不能超过1单');
    }
    return true;
}
/*
 * 计算代驾费用
 */
function countDestDriverPrice($distance){
    $keys = array('drive_min_distance','drive_distance','drive_initial_price','drive_night_price','drive_change_price','drive_night_time');
    $results = pdo_getall('make_speed_setting', array('uniacid' => $GLOBALS['uniacid'], 'key' => $keys, 'city_id' =>0), array('key', 'value'));
    $results = array_column($results,'value','key');
    $money = 20;
    if(!empty($results['drive_initial_price']))
        $money = sprintf('%.2f',$results['drive_initial_price']);
    $orderDistance = $distance;
    if(!$results['drive_distance']){
        $results['drive_distance'] = !empty($results['drive_distance']) ? unserialize($results['drive_distance']) : array();
        krsort($results['drive_distance']);
        foreach ($results['drive_distance'] as $k=>$v){
            if( $distance > $k) {
                $money   += ($distance - $k) * $v;
                $distance = $k;
            }
        }
    }

    //里程费
    $distance_price = $money;


    //阶段夜间费
    $results['drive_night_price'] = isset($results['drive_night_price']) ? unserialize($results['drive_night_price']) : array();
    $nightPrice = 0;
    if( $results['drive_night_price'] && is_array($results['drive_night_price']) ){
        $curTime = date("H:i",time());
        // 当前时间凌晨加上24小时
        if($curTime < 6) {
            $curTime += 24;
        }
        array_multisort(array_column($results['drive_night_price'],'start'),SORT_DESC,$results['drive_night_price']);
        //当前方法只能算整点，不能算分，暂时这样
        foreach ($results['drive_night_price'] as $k => $v){
            if($v['start'] > $v['end']){
                $v['end'] += 24;
            }
            if($curTime >= $v['start'] && $curTime <= $v['end']){
                $nightPrice = floatval($v['price']);
                break;
            }
        }
        $money += $nightPrice;
    }


    empty($results['drive_change_price']) && $results['drive_change_price'] = 0;

    //溢价
    $money += !empty($results['drive_change_price']) ? $results['drive_change_price'] : 0;



    $price = [
        'distance'          => $orderDistance,
        'distance_price'    => $distance_price,
        'night_price'       => $nightPrice,
        'change_price'      => $results['drive_change_price'],
        'total_price'       => $money,
    ];

    return $price;
}
