<?php


namespace Mclass;


class SendTpl{

    public  $url     = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=';
    public  $token   = '';


    public  function send($data){
        $url = $this->url.$this->token;

        $data = array(
            'touser'        => $data['open_id'],
            'template_id'   => $data['tpl_id'],
            'page'          => $data['page'],
            'data'          => $data['data'],
        );

        $data = json_encode($data);

        load()->func('communication');
        $re   = ihttp_post($url, $data);

        return json_decode($re['content'],true);
    }

    /**
     * 骑手已接单通知用户
     * @param $order_id
     */
    public function sendUserTemplate($order_id){
        load()->func('logging');

        $template = pdo_getcolumn('make_speed_setting',[ 'key'=>'accepted_template_id', 'uniacid'=>$GLOBALS['uniacid'] ],'value');
        if(empty($template) ){
            logging_run(date('Y-m-d H:i').'[sendTemplate] Error: 未设置骑手接单通知用户模板消息', 'trace', 'makespeedlog');
        }

        $query   = load()->object('query');
        $order   = $query->from('make_speed_order','o')
                    ->select(['o.order_code','ro.accept_time','r.real_name','o.user_id','o.type','o.status'])
                    ->innerjoin('make_speed_order_rider','ro')
                    ->on('o.id','ro.order_id')
                    ->innerjoin('make_speed_rider','r')
                    ->on('ro.rider_id' , 'r.id' )
                    ->where([ 'o.id' => $order_id ])
                    ->get();
        $open_id = pdo_getcolumn('make_speed_user',[ 'id' => $order['user_id'] ] ,'open_id');

        $uni     = pdo_get('account_wxapp',array('uniacid'=>$GLOBALS['uniacid']),array('key','secret'));
        $token   = get_access_token($uni['key'], $uni['secret']);
        $this->token = $token;

        if($order['type'] != 5){
            if(!is_numeric( substr( $order['order_code'],0,1 ) ) ){
                $order['order_code'] = substr( $order['order_code'],1);
            }
        }else{
            $order['order_code'] = date("YmdHis",time()).substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        }


        $data    = [
            'open_id'   => $open_id,
            'tpl_id'    => $template,
            'page'      => 'make_speed/order_pay/order_pay?order_id='.$order_id.'&status='.$order['status'].'&order_type='.$order['type'],
            'data'      => [
                'number1'   => [ 'value'  => $order['order_code'] ],
                'name13'    => [ 'value'  => $order['real_name']  ],
                'time4'     => [ 'value'  => date("Y-m-d H:i:s",$order['accept_time'] ) ],
            ],
        ];

        $re = $this->send($data);
        if($re['errcode'] != 0){
            logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:'.$re['errmsg'], 'trace', 'makespeedlog');
        }
    }

    /**
     * 通知用户订单已完成
     * @param $order_id int 订单id
     * @param $rider_id int
     */
    public  function orderComplete($order_id,$rider_id = 0){
        load()->func('logging');
        !$rider_id && $rider_id = $GLOBALS['CURRENT_RIDER'];

        $template = pdo_getcolumn('make_speed_setting',[ 'key'=>'complete_template_id', 'uniacid'=>$GLOBALS['uniacid'] ],'value');
        if(empty($template) ){
            logging_run(date('Y-m-d H:i').'[sendTemplate] Error: 未设置骑手接单通知用户模板消息', 'trace', 'makespeedlog');
        }
        $order   = pdo_get('make_speed_order',[ 'id'=>$order_id ],['status','user_id','type','order_code']);

        $uni     = pdo_get('account_wxapp',array('uniacid'=>$GLOBALS['uniacid']),array('key','secret'));
        $token   = get_access_token($uni['key'], $uni['secret']);
        $this->token = $token;

        $rider   = pdo_get('make_speed_rider',  array('id' => $rider_id ), array('real_name'));
        $phone   = pdo_get('make_speed_setting', array('key' => 'kefu_phone', 'uniacid' => $GLOBALS['uniacid']), array('value'));
        $open_id = pdo_getcolumn('make_speed_user',[ 'id' => $order['user_id'] ] ,'open_id');

        if($order['type'] != 5){
            if(!is_numeric( substr( $order['order_code'],0,1 ) ) ){
                $order['order_code'] = substr( $order['order_code'],1);
            }
        }else{
            $order['order_code'] = date("YmdHis",time()).substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        }

        $data  = [
            'open_id'   => $open_id,
            'tpl_id'    => $template,
            'page'      => 'make_speed/order_pay/order_pay?order_id='.$order_id.'&status='.$order['status'].'&order_type='.$order['type'],
            'data'      => [
                'number1'   => [ 'value' => $order['order_code']],
                'time6'     => [ 'value' => date("Y-m-d H:i:s",time()) ],
                'name7'     => [ 'value' => $rider['real_name'] ],
                'phone_number8' => [ 'value' => !empty($phone['value']) ? $phone['value'] : '18888888888' ],
                'thing9'    => [ 'value' => '您的订单已完成'],
            ]

        ];
        $re = $this->send($data);
        if($re['errcode'] != 0){
            logging_run(date('Y-m-d H:i').'[sendTemplate Rider] Error:'.$re['errmsg'], 'trace', 'makespeedlog');
        }
    }





















}