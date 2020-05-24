<?php

defined('IN_IA') or exit('Access Denied');


function pdodb($reload=false){
    global $_W;
    static $db;
    if(empty($db) || $reload) {

        load()->classs('db');

        include dirname(__FILE__).'/../../../../../../data/config.php';

        if(empty($config)){
            return null;
        }

        $other_database = array(
            'host'      => array_key_exists( 'master',$config['db'] ) ?  $config['db']['master']['host']   : $config['db']['host'],
            'username'  => array_key_exists( 'master',$config['db'] ) ?  $config['db']['master']['username']   : $config['db']['username'], // 数据库连接用户名
            'password'  => array_key_exists( 'master',$config['db'] ) ?  $config['db']['master']['password']   : $config['db']['password'], // 数据库连接密码
            'database'  => array_key_exists( 'master',$config['db'] ) ?  $config['db']['master']['database']   : $config['db']['database'], // 数据库名
            'port'      => array_key_exists( 'master',$config['db'] ) ?  $config['db']['master']['port']       : $config['db']['port'], // 数据库连接端口
            'tablepre'  => $_W['config']['db']['tablepre'], // 表前缀，如果没有前缀留空即可
            'charset'   => 'utf8', // 数据库默认编码
            'pconnect'  => true, // 是否使用长连接
        );

        $db = new DB($other_database);

    }
    return $db;
}

//----------------------------------------------------------------------

/**
 * 获取订单起点范围内 听单的骑手
 * @param int   $order_id 订单ID
 * @param int   $type 1不接实时单|2预约单
 * @return boolean | string
 */
function get_scope_rider($order_id, $type=0){

    $address = pdodb()->get('make_speed_order_address',array('order_id'=>$order_id),array('begin_lat','begin_lng'));

    if(empty($address) || empty($address['begin_lat']) || empty($address['begin_lng']))
        return '';

    $distance = pdodb()->get('make_speed_setting',array('key'=>'rider_distance','uniacid'=>$GLOBALS['uniacid']),array('value'));

    $distance['value'] = !empty($distance['value']) ? intval($distance['value']) : 10;

    $scope = get_radius_distance($address['begin_lng'], $address['begin_lat'], $distance['value']);

    $where = array(
        'lat >=' => $scope['minlat'],
        'lat <=' => $scope['maxlat'],
        'lng >=' => $scope['minlng'],
        'lng <=' => $scope['maxlng']
    );

    //听单状态
    $where['is_accept'] = 1;
    $where['uniacid']   = $GLOBALS['uniacid'];


    //接单类型
    $type && $where['accept_type !='] = $type;

    $rider = pdodb()->getall('make_speed_rider_info',$where,array('rider_id'));

    if(empty($rider))
        return '';

    $rider = implode(',', array_column($rider,'rider_id'));

    return $rider;
}

function get_radius_distance($lng, $lat, $distance = 2, $radius = 6371)
{
    $dlng = 2 * asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng);

    $dlat = $distance / $radius;
    $dlat = rad2deg($dlat);

    return array(
        'minlat' => $lat - $dlat,
        'minlng' => $lng - $dlng,
        'maxlat' => $lat + $dlat,
        'maxlng' => $lng + $dlng,
    );

}

/**
 * 给骑手发送订单模板消息
 * @param $order_id int 订单ID
 * @param $bus  boolean
 * @return int
 */
function r_send_order_tpl($order_id, $token=''){
    global $_W;
    load()->func('logging');

    $order = pdodb()->get('make_speed_order',array('id'=>$order_id),array('type','business_id','order_code','goodsname','get_time','total_price','description','uniacid'));

    if(empty($order))
        return 0;

    $GLOBALS['uniacid'] = $order['uniacid'];

    $t = 1;

    if( is_numeric(substr($order['get_time'], -1)) ){
        $order['get_time'] = $order['get_time'].'取件(预约单)';
        $t = 2;
    }
    //订单地址
    $address = pdodb()->get('make_speed_order_address',array('order_id'=>$order_id),array('begin_address','begin_detail'));

    $business = pdodb()->get('make_speed_business_info', array('business_id'=>$order['business_id']), array('rider_id'));

    $order['address'] = empty($address['begin_address']) ? '点击查看' : $address['begin_address'].' '.$address['begin_detail'];

    $rider_id = get_scope_rider($order_id,$t);

    logging_run(date('Y-m-d H:i').'[sendTemplate Rider] business_rider_id:'.$business['rider_id'].'||'.$rider_id, 'trace', 'makespeedlog');

    $rider_id = implode(',', array_diff(explode(',',$rider_id), explode(',',$business['rider_id'])));


    $riders = explode(',',$rider_id);

    //骑手端appid
    if(empty($token)) {
        logging_run(date('Y-m-d H:i') . '[sendTemplate Rider] Token is empty', 'trace', 'makespeedlog');
        return 0;
    }

    //获取系统设置的模板消息ID
    $template_id = pdodb()->get('make_speed_setting',array('uniacid'=>$GLOBALS['uniacid'],'key'=>'acceptorder_template_id'),array('value'));

    if(empty($template_id['value']))
        return 0;

    foreach ($riders as $v){
        if(!empty($v)) {
            send_rider_template($order, $v, $token, $template_id['value']);
        }
    }
    return 1;
}

/**
 * 指定骑手发送模板消息
 * @param $order array 订单
 * @param $rider_id int 骑手ID
 * @param $token string 令牌
 * @param $template_id string 模板消息ID
 * @return int
 */
function send_rider_template($order, $rider_id, $token="", $template_id){
    $formid = pdodb()->get('make_speed_rider_formid',array('uniacid'=>$GLOBALS['uniacid'],'rider_id'=>$rider_id),array('id','open_id','form_id','expire_time'));

    if(empty($formid))
        return 0;

    $ordertype = array('帮送','帮买','万能服务','代驾');

    $url='https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$token;

    //骑手可得钱
    $moneysetting = pdodb()->get('make_speed_setting',array('key'=>'rider_wages','uniacid'=>$GLOBALS['uniacid']),array('value'));
    $moneyss = (sprintf('%.2f', $moneysetting['value']) > 0) ? sprintf('%.2f', $moneysetting['value']) : 0.8;


    $data = array(
        'touser'        => $formid['open_id'],
        'template_id'   => $template_id,
        'form_id'       => $formid['form_id'],
        'page'          => 'make_rider/index/index?id='.$order['id'],
        'data'  =>  array(
            'keyword1'=>array('value'=>$order['order_code']),
            'keyword2'=>array('value'=>'['.$ordertype[$order['type']].'] '.$order['goodsname']),
            'keyword3'=>array('value'=>$order['get_time']),
            'keyword4'=>array('value'=>sprintf('%.2f', $order['total_price']*$moneyss)),
            'keyword5'=>array('value'=>$order['description']),
            'keyword6'=>array('value'=>$order['address']),
        ),
        'emphasis_keyword' => ''//"keyword6.DATA"
    );

    $data = json_encode($data);

    $lists = ihttp_post($url, $data);

    if(empty($lists) || empty($lists['content']))
        return 0;

    $list = @json_decode($lists['content'], true);

    //使用完删除一条
    pdodb()->delete('make_speed_rider_formid',array('id'=>$formid['id']));

    if($list['errcode']===0){
        return 1;
    }else{
        load()->func('logging');
        logging_run(date('Y-m-d H:i').'[Task sendTemplate] Error: '.$rider_id.'::'.(string)$lists['content'], 'trace', 'makespeedlog');
        send_rider_template($order, $rider_id, $token, $template_id);
    }

    return 1;
}