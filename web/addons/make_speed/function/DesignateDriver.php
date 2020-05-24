<?php


//function complateOrder($rider_id,$order_id){
    require '../../../framework/bootstrap.inc.php';

    $rider = pdo_get('make_speed_rider_driver');

    var_dump($rider);die;
    $riderID  = $rider_id;

    //获取坐标
    $redis = new \Redis();
    $redis->connect(self::$host, self::$port);
    $coord = $redis->lRange('d'.$rider_id,0,-1);

    if(!$coord){
        return '未获取到坐标';
    }

    array_walk($coord,function(&$value){
        $value = json_decode($value,true);
    });
    $coord = json_encode($coord);


    //上传经纬度
    $rider = pdo_get('make_speed_rider_driver',['rider_id' => $riderID ],['rider_id','tid','uniacid']);
    $trid  = pdo_get('make_speed_order_rider',['rider_id'  => $riderID ,'order_id' => $order_id],['trid','get_msec_time']);

    if(!$trid){ return '未查询到进行中订单！'; }
    $uniacid = $rider['uniacid'];

    $keys = ['amap_driver_key','amap_service_id'];
    $setting   = pdo_get('make_speed_setting',['key'=>$keys,'uniacid'=>$uniacid],['value']);
    $setting   = @array_column($setting,'value','key');
    if( !isset( $setting['amap_driver_key'] ) || !isset( $setting['amap_service_id'] ) ){
        return '高德地图key未配置或服务ID未生成！';
    }

    $postData = [
        'key'    => $setting['amap_driver_key'],
        'sid'    => $setting['amap_service_id'],
        'tid'    => $rider['tid'],
        'trid'   => $trid['trid'],
        'points' => $coord,
    ];

    $lieying  = new LieYing();
    $lieying->upload_point($postData);

    $redis = GetRedis::instance();
    $redis->del('d'.$riderID);
    return true;



//}