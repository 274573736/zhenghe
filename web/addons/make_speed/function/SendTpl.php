<?php

use Mclass\GetRedis;


/**
 * 给骑手发送订单模板消息
 * @param $order_id int 订单ID
 * @return int
 */
function sendToRiderOrderTpl($order_id){
    global $_W;
    load()->func('logging');

    $order = pdo_get('make_speed_order',array('id'=>$order_id),array('id','add_time','type','business_id','order_code','goodsname','get_time','total_price','description','uniacid'));

    if(empty($order))
        return 0;

    $GLOBALS['uniacid'] = $order['uniacid'];

    $t = 2;

    if( is_numeric(substr($order['get_time'], -1)) ){
        $order['get_time'] = $order['get_time'].'取件(预约单)';
        $t = 1;
    }
    //订单地址
    $address = pdo_get('make_speed_order_address',array('order_id'=>$order_id),array('begin_address','begin_detail','end_address','begin_detail'));

    if(pdo_tableexists('make_speed_business_info')){
        $business = pdo_get('make_speed_business_info', array('business_id'=>$order['business_id']), array('rider_id'));
    }else{
        $business = array();
    }

    $order['address'] = empty($address['begin_address']) ? '点击查看' : $address['begin_address'].' '.$address['begin_detail'];

//    if( !isset($business['rider_id']) ){
    if($order['type'] != 6){
        $open_id = getScopeRiderOpenid($order_id,$t,$order['type']);
    }else{
        $open_id = getScopeTechnicianOpenid($order_id,$t,$order['type']);
    }
//    }else{
//        $ids     = explode(',',$business['rider_id'] );
//        $rider   = pdo_getall('make_speed_rider',['id'=>$ids],['open_id']);
//        $open_id = @array_column($rider,'open_id');
//    }

    logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error: business_rider_id:'.$business['rider_id'].':::'.getScopeRiderOpenid($order_id,$t), 'trace', 'makespeedlog');


    //获取骑手小程序token
    $result = pdo_get('make_speed_setting',array('key'=>'rider_uniacid','uniacid'=>$order['uniacid']),array('value'));
    if(empty($result['value']))
        return false;

    //骑手端appid
    $uni = pdo_get('account_wxapp',array('uniacid'=>$result['value']),array('key','secret'));
    $token = get_access_token($uni['key'],$uni['secret']);

    if(empty($token)){
        logging_run(date('Y-m-d H:i') . '[Task sendTemplate Rider] Token is empty', 'trace', 'makespeedlog');
        return false;
    }

    if(!empty($business['rider_id'])){
        logging_run(date('Y-m-d H:i').'[sendTemplate Rider] setting task: '.$open_id, 'trace', 'makespeedlog');
        setRedisTask($order_id, 89, $token);
    }

    //获取系统设置的模板消息ID
    $template_id = pdo_get('make_speed_setting',array('uniacid'=>$GLOBALS['uniacid'],'key'=>'acceptorder_template_id'),array('value'));

    if(empty($template_id['value'])){
        logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:抢单模板消息未配置', 'trace', 'makespeedlog');
        return false;
    }


    $tpl  = new \Server\wechat\SendTemplate($token);
    $redis = @GetRedis::instance();
    if(!is_numeric( substr($order['order_code'],0,1) ) ){
        $order['order_code'] = substr($order['order_code'],1);
    }

    foreach ($open_id as $v){
        $data = [
            'open_id' => $v,
            'tpl_id'  => $template_id['value'],
            'page'    => 'make_rider/index/index?id='.$order['id'],
            'data'    => [
                'number4'   => [ 'value' => $order['order_code'] ],
                'thing2'    => [ 'value' => $address['begin_address'] ? $address['begin_address'].$address['begin_detail'] : '无' ],
                'thing3'    => [ 'value' => $address['end_address'] ? $address['end_address'].$address['end_detail'] : '无' ],
                'time6'     => [ 'value' => date("Y-m-d H:i:s",$order['add_time']) ],
            ]
        ];
        $re = $tpl->send($data);
        //用户拒绝接收 记录消息次数清零
        if($re['errcode'] == '43101'){
            $redis->set('notify'.$GLOBALS['uniacid'].$v,0);
        }

        if($re['errcode'] != 0){
            logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:'.$re['errmsg'], 'trace', 'makespeedlog');
        }

        $re = $redis->get('notify'.$GLOBALS['uniacid'].$v);
        if($re){
            $redis->decrBy('notify'.$GLOBALS['uniacid'].$v,1);
        }

        unset($v);

    }
    return true;
}

/*
 * 用户支付成功订单模板消息
 * @param $oder_id int 订单ID
 */
function UserPayOrder($order_id){
    load()->func('logging');
    $order   = pdo_get('make_speed_order',array('id'=>$order_id),array('id','user_id','status','add_time','type','order_code','total_price','category_id') );
    if(!$order){ return false; }

    $tpl_id  = pdo_getcolumn('make_speed_setting',['uniacid'=>$GLOBALS['uniacid'],'key'=>'template_id'],'value');
    $open_id = pdo_getcolumn('make_speed_user',[ 'id' => $order['user_id'] ] ,'open_id');
    $type    = array('帮送','帮买','万能服务','代驾','','货运','家政');
    $status  = array('未付款','订单已取消','等待接单中','已接单,等待取件','取件成功,待收件','已送达,待评价','订单已完成');

    if($order['type'] == 6){
        $type = pdo_getcolumn('make_speed_homemaking_category',[ 'id'=>$order['category_id'] ],'title');
    }else{
        $type = $type[ $order['type'] ];
    }

    $token   = get_access_token();
    $tpl     = new \Server\wechat\SendTemplate($token);

    if(!is_numeric( substr( $order['order_code'],0,1 ) ) ){
        $order['order_code'] = substr( $order['order_code'],1);
    }
    $data = [
        'open_id' => $open_id,
        'tpl_id'  => $tpl_id,
        'page'    => 'make_speed/order_pay/order_pay?status=2&order_id='.$order_id.'&order_type='.$order['type'],
        'data'    => [
            'thing8'            => [ 'value' => $type  ],
            'character_string1' => [ 'value' => $order['order_code']  ],
            'amount9'           => [ 'value' => $order['total_price'] ],
            'phrase10'          => [ 'value' => $status[$order['status'] ] ],
            'time2'             => [ 'value' => date("Y-m-d H:i:s",$order['add_time']) ],
        ]
    ];
    $re = $tpl->send($data);
    if($re['errcode'] != 0){
        logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:'.$re['errmsg'], 'trace', 'makespeedlog');
    }
}

function userCancelOrder($order){
    global $_W;
    load()->func('logging');
    $tpl_id  = pdo_getcolumn('make_speed_setting',['uniacid'=>$GLOBALS['uniacid'],'key'=>'cancel_template_id'],'value');
    if(!$order && !$tpl_id){
        logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:取消模板未配置', 'trace', 'makespeedlog');
        return false;
    }
    $data = [
        'open_id' => $_W['openid'],
        'tpl_id'  => $tpl_id,
        'page'    => 'make_speed/order_pay/order_pay?status=2&order_id='.$order['id'].'&order_type='.$order['type'],
        'data'    => [
            'character_string2' => [ 'value' => $order['order_code']  ],
            'amount9'           => [ 'value' => $order['pay_price'] ],
            'phrase11'          => [ 'value' => '已取消' ],
            'time12'            => [ 'value' => date("Y-m-d H:i:s",time() ) ],
            'thing5'            => [ 'value' => '订单取消成功' ],
        ]
    ];
    $token   = get_access_token();
    $tpl     = new \Server\wechat\SendTemplate($token);
    $re = $tpl->send($data);
    if($re['errcode'] != 0){
        logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:'.$re['errmsg'], 'trace', 'makespeedlog');
    }
}


//----------------------------------------------------------------------
/**
 * 获取订单起点范围内 听单的骑手opeid
 * @param int   $order_id 订单ID
 * @param int   $type 1不接实时单|2预约单
 * @return boolean | string
 */
function getScopeRiderOpenid($order_id, $type=0,$orderType=0){
    if( in_array($orderType,[1,2]) ){
        $orderType = 0;
    }
    $address = pdo_get('make_speed_order_address',array('order_id'=>$order_id),array('begin_lat','begin_lng'));

    if(empty($address) || empty($address['begin_lat']) || empty($address['begin_lng']))
        return '';

    $distance = pdo_get('make_speed_setting',array('key'=>'rider_distance','uniacid'=>$GLOBALS['uniacid']),array('value'));

    $distance['value'] = !empty($distance['value']) ? intval($distance['value']) : 10;

    $scope = getPointDistance($address['begin_lng'], $address['begin_lat'], $distance['value']);

//    $type && $where .= 'i.accept_type <> :acc_type';

    $field  = 'r.open_id';
    $where  = "i.lat >=:minlat AND i.lat <=:maxlat AND i.lng >=:minlng AND i.lng <=:maxlng AND ";
    $where .= "FIND_IN_SET(:type,i.order_type) AND r.uniacid = :uniacid AND i.is_accept = :is_accept AND r.status = :status";

    $sql    = "SELECT $field FROM ".tablename('make_speed_rider_info')." AS i INNER JOIN ".tablename('make_speed_rider')." AS r ON i.rider_id = r.id WHERE $where";
    $params = [
        ':status' => 2,
        ':type'     => $orderType,
        ':uniacid'  => $GLOBALS['uniacid'],
        ':is_accept'=> 1,
        ':minlat'   => $scope['minlat'],
        ':maxlat'   => $scope['maxlat'],
        ':minlng'   => $scope['minlng'],
        ':maxlng'   => $scope['maxlng'],
    ];

    $rider = pdo_fetchall($sql,$params);

    if(empty($rider))
        return '';

    $rider = array_filter(array_column($rider,'open_id'));

    return $rider;
}



//----------------------------------------------------------------------
/**
 * 获取订单起点范围内 听单的骑手opeid
 * @param int   $order_id 订单ID
 * @param int   $type 1不接实时单|2预约单
 * @return boolean | string
 */
function getScopeTechnicianOpenid($order_id, $type=0,$orderType = 6){

    $address = pdo_get('make_speed_order_address',array('order_id'=>$order_id),array('begin_lat','begin_lng'));

    if(empty($address) || empty($address['begin_lat']) || empty($address['begin_lng']))
        return '';

    $distance = pdo_get('make_speed_setting',array('key'=>'rider_distance','uniacid'=>$GLOBALS['uniacid']),array('value'));

    $distance['value'] = !empty($distance['value']) ? intval($distance['value']) : 20;

    $scope = getPointDistance($address['begin_lng'], $address['begin_lat'], $distance['value']);


    $categoryId = pdo_getcolumn('make_speed_order',['id'=>$order_id],'category_id');

    $field  = 'r.open_id';
    $where  = "i.lat >=:minlat AND i.lat <=:maxlat AND i.lng >=:minlng AND i.lng <=:maxlng AND ";
    $where .= "FIND_IN_SET(:type,i.order_type) AND ";
    $where .= "FIND_IN_SET(:category_id,t.category_id) AND i.uniacid = :uniacid AND i.is_accept = :is_accept AND t.status = :status";
    $sql    = "SELECT $field FROM ".tablename('make_speed_rider_info')." AS i  INNER JOIN ".tablename('make_speed_rider')."  AS r ON i.rider_id = r.id  INNER JOIN  ".tablename('make_speed_homemaking_technician')." AS t ON i.rider_id = t.rider_id WHERE $where";
    $params = [
        ':category_id' => $categoryId,
        ':uniacid'  => $GLOBALS['uniacid'],
        ':is_accept'=> 1,
        ':status'   => 2,
        ':type'     => $orderType,
        ':minlat'   => $scope['minlat'],
        ':maxlat'   => $scope['maxlat'],
        ':minlng'   => $scope['minlng'],
        ':maxlng'   => $scope['maxlng'],
    ];

    $technician  = pdo_fetchall($sql, $params);

    if(empty($technician))
        return [];

    $openid = array_column($technician,'open_id');

    return $openid;

}