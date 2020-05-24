<?php


namespace app\apis\server;


use app\apis\exception\OrderException;
use app\apis\exception\ParamException;
use think\Request;
use app\apis\server\Map;
use app\apis\model\Clouds;
use app\apis\model\Order as OrderMode;
use think\Exception;
use think\Db;

class Order
{

    /*
     * 获取订单详情
     * @param string $orderNum  订单号
     * @param int    $id        当前模块ID
     * @throws OrderException
     */
    public function getOrderDetail($orderNum,$id){
        $order = Db::name('order')->where(['order_code'=>$orderNum,'clouds_id'=>$id])->field(['id'])->find();
        if(!$order){
            throw new OrderException(['msg'=>'订单不存在！']);
        }
        $order = OrderMode::order_detail($order['id']);
        if(!$order){
            throw new OrderException(['msg'=>'订单不存在！']);
        }
        $order = $order->toArray();
        unset($order['order_address']['id'],$order['order_address']['end_floor']);
        if( isset( $order['order_rider']['rider'] ) ){
            $order['order_rider']['real_name'] = $order['order_rider']['rider']['real_name'];
            $order['order_rider']['mobile'] = $order['order_rider']['rider']['mobile'];
            unset($order['order_rider']['rider']);
        }
        return $order;
    }

    /*
     * 获取订单状态
     * @param string $orderNum  订单号
     * @param int    $id        当前模块ID
     * @return array
     */
    public function getOrderStatus($orderNum,$id){
        $order = Db::name('order')->where(['order_code'=>$orderNum,'clouds_id'=>$id])->field(['order_code','status'])->find();
        if(!$order){
            throw new OrderException(['msg'=>'订单不存在！']);
        }
        $status = array('loading','cancel','payed','accepted','geted','gotoed','completed');
        $text = array('待付款', '订单已取消', '待接单', '待取件', '待收件', '待评价', '订单已完成');
        empty($status[$order['status']]) && $status[$order['status']] = $order['status'];
        return array('status'=>$status[$order['status']],'remark'=>!empty($text[$order['status']]) ? $text[$order['status']] : '未知?');
    }



    /**
     * 修改订单状态
     * @param $data   post数据
     * @param $id     模块ID
     * @return string
     * @throws Exception
     * @throws OrderException
     */
    public function updateOrder($data,$id){
        $order = OrderMode::getOrderBynum($data['order_num']);
        if(!$order){
            throw new OrderException(['msg'=>'订单不存在！']);
        }
        $text   = array('loading','cancel','payed');//（'loading':等待付款(添加订单时默认状态)；'cancel':订单取消；'payed':订单已付款；'completed':完成订单)
        $status = array_search($data['status'], $text);
        $re     = Db::name('order')->where(['order_code'=>$data['order_num'],'clouds_id'=>$id])->update(['status'=>$status]);
        if(!$re){
            throw new OrderException(['msg'=>'订单状态更新失败']);
        }
        if($status==2) {
            sendOrderTpl($order->id);
            require ROOT_PATH . "../wokerman/vendor/autoload.php";
            @\GatewayWorker\Lib\Gateway::$registerAddress = '127.0.0.1:1238';
            @\GatewayWorker\Lib\Gateway::sendToUid('uniacid'.$GLOBALS['uniacid'],$order->id);
        }
        return $text[$status];
    }



    /*
     * 新增订单
     */
    public function create($mid,$params){
        $params['address'] = json_decode($params['address'],true);
        $module   = Clouds::getModuleByID($mid);
        $charging = unserialize($module['charging']);
        $from     = $params['address']['begin_lat'].','. $params['address']['begin_lng'];
        $to       = $params['address']['end_lat'].','.$params['address']['end_lng'];

        $params['distance']    = (new Map)->getDistance($from,$to);
        $params['total_price'] = $this->countPrice($params['distance'],$charging);
        $params['clouds_id']   = $mid;
        $orderNum = $this->saveOrder($params);
        return $orderNum;
    }



    /*
     * 保存订单
     */
    public function saveOrder($params){
        $params['goodsname']   = $params['goods_name'];
        $params['get_time']    = $params['pick_time'];
        $params['description'] = $params['remark'] ? $params['remark'] : '';
        $params['order_code']  = generate_order_code(18, 'A', true);
        $params['uniacid']     = $GLOBALS['uniacid'];
        $params['add_time']    = time();
        $orderModel = new OrderMode();
        Db::startTrans();
        try {
            $orderModel->allowField(true)->save($params);
            $orderModel->orderAddress()->save($params['address']);
            Db::commit();
            return $orderModel->order_code;
        } catch (Exception $ex) {
            Db::rollback();
            throw new OrderException(['msg'=>'订单插入失败！']);
        }
    }



    /*
     * 返回配送价格
     */
    public function price($mid){
        $coord     = Request::instance()->param();
        $distance  = (new Map)->getDistance($coord['fromcoord'],$coord['tocoord']);
        $charging  =  Clouds::getModuleByID($mid);
        if(!$charging){
             throw new ParamException(['msg'=>'该对接模块计费价格未添加！']);
        }
        $charging  = unserialize($charging->charging);
        $price     = $this->countPrice($distance,$charging);
        return ['distance'=>$distance,'price'=>$price];
    }


    /*
     * 计算价格
     */
    public function countPrice($distance,$charging){
        if($distance <= $charging['init_distance']){
            return $charging['init_price'];
        }
        $price = $charging['init_price'];

        krsort($charging['onward_journey']);

        foreach($charging['onward_journey'] as $km=>$money){
            if($distance > $km){
                $price += ($distance  - $km) * $money;
                $distance = $km;
            }
        }
        return sprintf('%.2f',$price);
    }
}