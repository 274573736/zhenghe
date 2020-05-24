<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use Psr\Log\Test\DummyTest;
use think\Config;
use think\Db;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Eleme extends Backend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';


    public function callback(){

        $GLOBALS['uniacid'] = !empty($_REQUEST['uniacid']) ? intval($_REQUEST['uniacid']) : 0;

        $code  = !empty($_GET['code']) ? $_GET['code'] : null;
        $error = isset($_GET['error']) ? $_GET['error'] : null;

        $error_msg = !empty($_GET['error_description']) ? $_GET['error_description'] : '';

        //获取系统设置
        $ele = Db::name('setting')
            ->where('key','in','eleme_switch,eleme_desc,eleme_logo,eleme_name,eleme_key,eleme_secret')
            ->where(['uniacid'=>$GLOBALS['uniacid']])
            ->select();
        empty($ele) && $ele=array();

        $ele = @array_column($ele,'value','key');

        $ele['eleme_desc'] = !empty($ele['eleme_desc']) ? htmlspecialchars_decode($ele['eleme_desc']) : '<p>对此应用授权...</p>';

        $this->view->assign('ele', $ele);

        if($code===null && $error!==null){
            $error_msg = !empty($error_msg) ? '授权失败:'.$error_msg : '授权失败！请联系平台或重试!';
            $this->view->assign('error_msg', $error_msg);
            return $this->view->fetch();
        }

        if(!empty($code)) {
            vendor('eleme.Config');
            vendor('eleme.Eleme');
            $domian = $this->request->domain();

            $params = array(
                'key' => $ele['eleme_key'],
                'secret' => $ele['eleme_secret'],
                'sandbox' => true,
                'callback_url' => urlencode($domian."/addons/make_speed/core/public/index.php/admin/eleme/callback"),
            );

            if(!empty($ele['eleme_switch'])){
                $params['sandbox'] = false;
            }

            $config = new \Config($params['key'], $params['secret'], $params['sandbox']);

            $ele = new \Eleme($config);

            try {
                $token = $ele->get_oauth_token($code, $params['callback_url']);
            } catch (\Exception $e) {
                $error_msg = '授权失败：' . $e->getMessage();
                \think\Log::record($error_msg, 'error');
            }

            if(!empty($token)){

                $shopid = isset($_GET['shopid']) ? $_GET['shopid'] : '';

                if(!empty($token['access_token']) && !empty($token['refresh_token']) && isset($token['expires_in'])){
                    $redata['token'] = $token['access_token'];
                    $redata['refresh_token'] = $token['refresh_token'];
                    $redata['token_expire'] = time() + intval($token['expires_in'])  -  300;

                    $up = Db::name('business')->where(['shop_id'=>$shopid])->update($redata);
                    if(empty($up)){
                        $error_msg = 'Token更新失败, '.$shopid.'店铺ID未接入本平台';
                    }
                }else{
                    $error_msg = '授权异常, 未获取到Token';
                }
            }else{
               empty($error_msg) && $error_msg = '授权异常, Token为空';
            }

            $this->view->assign('error_msg', $error_msg);
            return $this->view->fetch();

        }

        $this->view->assign('error_msg', $error_msg);
        $this->view->assign('info', true);
        return $this->view->fetch();
    }

    public function callapi(){

        $GLOBALS['uniacid'] = !empty($_REQUEST['uniacid']) ? intval($_REQUEST['uniacid']) : 0;

        //获取系统设置
        $ele = Db::name('setting')
            ->where('key','in','eleme_key,eleme_secret')
            ->where(['uniacid'=>$GLOBALS['uniacid']])
            ->select();
        empty($ele) && $ele=array();
        $ele = @array_column($ele,'value','key');

        $secret = $ele['eleme_secret'];

        if (strtolower($_SERVER['REQUEST_METHOD']) == 'get')
        {
            echo '{"message":"ok"}';
            exit();
        }

        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post')
        {
            $postStr = file_get_contents('php://input');
            $postStr = json_decode($postStr, true);
            if (!($this->checkSign($postStr, $secret)))
            {
                \think\Log::record('Check Sign Fail.'.json_encode($postStr), 'error');
                exit('Check Sign Fail.');
            }

            $postStr['message'] = @json_decode($postStr['message'], true);

            $this->responseApi($postStr);
        }
    }

    private function responseApi($data){

        $type = $data['type'];
        $eorder = $data['message'];
        Db::name('setting')->insert(['key'=>'eleme-'.date('m-d H:i:s'), 'value'=>@json_encode($data)]);

        //订单生效
        if($type==10){
            $shop = Db::name('business')->where('shop_id', $eorder['shopId'])->field('id,user_id,phone,uniacid')->find();

            $shopi = Db::name('business_info')->where('business_id', $shop['id'])->find();

            $latlng = explode(',', $eorder['deliveryGeo']);

            $distance = get_point_distance($latlng[1].','.$latlng[0], $shopi['lat'].','.$shopi['lng']);

            $distance['distance'] = !empty($distance['distance']) ? $distance['distance']/1000 : 0;

            $results = pdo_get('make_speed_business_info', array('business_id' => $shop['id']), array('init_price','init_distance','price'));
            if(empty($results))
                $this->result(0,'',array('money'=>12));
            $results['price'] = !empty($results['price']) ? unserialize($results['price']) : array();

            $money = 12;//默认12块
            if($results['init_price']>0)
                $money = sprintf('%.1f',$results['init_price']);

            $x = $distance['distance'];
            krsort($results['price']);
            foreach ($results['price'] as $k=>$v){
                if($x>$k) {
                    $money += ($x - $k) * $v;
                    $x = $k;
                }
            }


            $order = array(
                'order_code'        =>  'B'.$eorder['orderId'],
                'get_time'          =>  '立即取餐',
                'user_id'           =>  $shop['user_id'],
                'description'       =>  '饿了么订单'.$eorder['daySn'] . '号 | ' . $eorder['description'],
                'phone'             =>  $eorder['phoneList'][0],
                'business_id'       =>  !empty($shop['id']) ? $shop['id'] : 0,
                'total_price'       =>  sprintf('%.1f', $money),
                'pay_price'         =>  sprintf('%.1f', $money),
                'status'            =>  0,
                'add_time'          =>  time(),
                'uniacid'           =>  $shop['uniacid'],
                'role'              => 'eleme'
            );
            $exits = Db::name('order')->where('order_code','B'.$eorder['orderId'])->find();

            if(!empty($exits)){
                echo '{"message":"ok"}';
                exit();
            }

            $add = Db::name('order')->insert($order);
            if(empty($add)) {
                \think\Log::record('饿了么订单添加至跑腿失败：'.json_encode($eorder), 'error');
                echo '{"message":"ok"}';
                exit();
            }

            $oid = Db::name('order')->getLastInsID();

            if(!empty($shop['id'])){
                $shopphone = $shop['phone'];

                $address = array(
                    'order_id'      => $oid,
                    'begin_lat'     => $shopi['lat'],
                    'begin_lng'     => $shopi['lng'],
                    'begin_address' => $shopi['address'],
                    'begin_username'=> $eorder['shopName'],
                    'begin_phone'   => $shopphone,

                    'end_lat'       => $latlng[1],
                    'end_lng'       => $latlng[0],
                    'end_address'   => $eorder['deliveryPoiAddress'],
                    'end_username'  => $eorder['consignee'],
                    'end_phone'     => $eorder['phoneList'][0],
                );

                Db::name('order_address')->insert($address);
            }
        }

        //商家接单
        if($type == 12){

            $order = Db::name('order')->where('order_code','B'.$eorder['orderId'])->field('id,user_id,order_code,status,business_id,pay_price')->find();

            if(empty($order)){
                \think\Log::record('下单无效：'.json_encode($eorder), 'error');
                echo '{"message":"ok"}';
                exit();
            }

            $oid = $order['id'];

            //扣钱
            if(!update_business_money($order['business_id'], $order['pay_price'])){
                \think\Log::record('大客户余额不足,无法下单推送：'.json_encode($order), 'error');

                addUserCashLog($order['user_id'],$order['order_code'],$order['pay_price'],0,'饿了么订单自动支付失败', 0, $oid, $order['business_id']);

                echo '{"message":"ok"}';
                exit();
            }

            addUserCashLog($order['user_id'],$order['order_code'],$order['pay_price'],0,'饿了么订单自动支付', 1, $oid, $order['business_id']);

            Db::name('order')->where('id',$oid)->update(['status'=>2]);

            try{
                require ROOT_PATH . "../wokerman/vendor/autoload.php";
                \GatewayWorker\Lib\Gateway::$registerAddress = '127.0.0.1:1238';
                \GatewayWorker\Lib\Gateway::sendToUid('uniacid'.$GLOBALS['uniacid'],$oid);

                $rids = getScopeRider($oid);
                $rids = array_keys($rids);
                foreach ($rids as $v) {
                    $online = \GatewayWorker\Lib\Gateway::isUidOnline(intval($v));
                    if (!empty($online)) {
                        \GatewayWorker\Lib\Gateway::sendToUid(intval($v), json_encode(['order_id' => $oid]));
                    }
                }

            }catch (\Exception  $e){
                \think\Log::record('饿了么下单消息推送骑手端失败：'.$e->getMessage(), 'error');
            }

        }

        //商家取消订单
        if($type==23){
            //加钱
            if(!update_business_money($order['business_id'], $order['pay_price'],1 )){
                \think\Log::record('大客户余额不足,无法下单推送：'.json_encode($order), 'error');
                addUserCashLog($order['user_id'],$order['order_code'],$order['pay_price'],2,'饿了么商家取消订单', 0, $oid, $order['business_id']);
                Db::name('order')->where(['order_code' => 'B'.$eorder['orderId']])->update(['status'=>1]);
            }
        }
        //订单接单前被取消
        if($type==14){
            Db::name('order')->where(['order_code' => 'B'.$eorder['orderId']])->update(['status'=>1]);
        }

        //订单送达
        if($type==18){
            Db::name('order')->where(['order_code' => 'B'.$eorder['orderId']])->update(['status'=>5]);
        }

        echo '{"message":"ok"}';
        exit();
    }

    private function buildSign($param, $secret)
    {
        unset($param['signature']);
        ksort($param);
        $string = '';
        foreach ($param as $key => $value )
        {
            $string .= $key . '=' . $value;
        }
        $splice = $string . $secret;
        $md5 = strtoupper(md5($splice));
        return $md5;
    }

    private function checkSign($param, $secret)
    {
        $signature = $param['signature'];
        unset($param['signature']);
        if ($signature != $this->buildSign($param, $secret))
        {
            return false;
        }
        return true;
    }

}