<?php
if( PHP_SAPI != 'cli'){
    die;
}
ini_set('default_socket_timeout', -1);  //不超时
require_once 'MyRedis.php';

//加载微擎引导文件
require_once dirname(__FILE__).'/../../../../../framework/bootstrap.inc.php';

require_once dirname(__FILE__).'/extend/core.func.php';

$redis_db = '12';
$redis = new \MyRedis('127.0.0.1','6379','',$redis_db);
// 解决Redis客户端订阅时候超时情况
$redis->setOption();

$redis->psubscribe(array('__keyevent@'.$redis_db.'__:expired'), 'keyCallback');

function keyCallback($redis, $pattern, $channel, $msg){
    $isOrderKey = strpos($msg,'ex_order_id');
    if( $isOrderKey === 0){
        $order_id = substr($msg,11);
        $order = pdo_get('make_speed_order',['id'=>$order_id],['id','type','business_id','user_id','small_price','status','order_code','pay_price','payment','coupon_id','uniacid']);

        if($order){
            include dirname(__FILE__).'/../../common.func.php';
            if($order['status'] == 0){
                pdo_update('make_speed_order',[ 'status'=> 1],[ 'id'=>$order['id'] ]);
            }elseif ( $order['status'] == 2 ) {
                RedisRefund($order);
            }
        }
    }
}

function RedisRefund($result){
    require dirname(__FILE__).'/../../../../../framework/bootstrap.inc.php';
    require dirname(__FILE__).'/../../common.func.php';

    $order = pdo_get('make_speed_order',['id'=>$result['id']],['id','type','business_id','user_id','small_price','status','order_code','pay_price','payment','coupon_id','uniacid']);
    //之前封装的函数需要用到$GLOBALS['uniacid']
    $GLOBALS['uniacid'] = $result['uniacid'];
    //在回调调用微擎封装函数8能获取uniacid，在这声明
    global $_W;
    $_W['uniacid'] = $result['uniacid'];

    load()->func('logging');

    $id = $result['id'];
    $up = pdo_update('make_speed_order',array('status'=>1),['id'=>$id]);
    if(!$up){
        logging_run(date('Y-m-d H:i').'[atuoReufnd] error:修改订单失败!', 'trace', 'makeRedisRefund');
        return false;
    }

    //返回优惠券
    if(!empty($result['coupon_id'])) {
        pdo_update('make_speed_user_coupons', array('status' => 0), array('id' => $result['coupon_id']));
    }

    if($result['payment']==3){
        return false;
    }

    //判断是否有支付过
    $cash = pdo_get('make_speed_user_cashlog',array('user_id'=>$result['user_id'],'order_code'=>$result['order_code'],'status'=>1,'type <'=>2),array('amount','business_id'));

    if(!empty($cash['amount'])){

        //商户订单退款
        if(!empty($cash['business_id'])){
            $business = business_refund($cash['business_id'], $result);
            if(is_error($business)){
                logging_run(date('Y-m-d H:i').'[atuoReufnd] Error: '.!empty($refund['message']) ? $refund['message'] : '退款失败', 'trace', 'makeRedisRefund');
            }
            logging_run(date('Y-m-d H:i').'[atuoReufnd] Success:大客户退款成功!', 'trace', 'makespeedlog');
            return true;
        }

        $smallcount = pdo_get('make_speed_user_cashlog', array('type'=>0, 'status'=>1, 'object_id'=>$id, 'user_id'=>$result['user_id']),array('SUM(amount) as amount'));

        empty($smallcount['amount']) && $smallcount['amount'] = 0;
        if($result['payment']==2){
            $cashid = addCashLog($result['user_id'],$result['order_code'],($result['pay_price']-$smallcount['amount']), 2, '微信退款', 0, 0);
            $module = $result['type'] == 5 ? 'make_speed_plugin_freight' : 'make_speed';
            $refund = weixinRefund($result['order_code'], ($result['pay_price']-$smallcount['amount']),$module);//$result['pay_price']
            if(is_error($refund))
                logging_run(date('Y-m-d H:i').'[atuoReufnd] Error: '.!empty($refund['message']) ? $refund['message'] : '退款失败', 'trace', 'makeRedisRefund');

            pdo_update('make_speed_user_cashlog',array('status'=>1),array('id'=>$cashid));
        }
        else{
            updateUserMoney($result['user_id'],($result['pay_price']-$smallcount['amount']),1);
            addCashLog($result['user_id'],$result['order_code'],($result['pay_price']-$smallcount['amount']),2,'退款到余额', $id);
        }


        //退小费
        $small = pdo_getall('make_speed_user_cashlog',array('object_id'=>$id,'type'=>0,'status'=>1,'uniacid'=>$result['uniacid']),array('id','amount','user_id','order_code'));
        if(!empty($small)){
            foreach ($small as $v){
                $re = weixinRefund($v['order_code'], $v['amount']);
                if(is_error($re)){
                    addCashLog($v['user_id'],$v['order_code'],$v['amount'],2,'[小费]余额退款',$id, 1);
                    pdo_update('make_speed_user',array('valid +='=>$v['amount']),array('id'=>$v['user_id']));
                }else{
                    addCashLog($v['user_id'],$v['order_code'],$v['amount'],2,'[小费]微信退款',$id, 1);
                }
            }
        }
    }
}

