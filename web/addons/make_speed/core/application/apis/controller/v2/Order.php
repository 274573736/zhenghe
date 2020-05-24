<?php


namespace app\apis\controller\v2;


use app\apis\validate\Coord;
use app\apis\server\Order as OrderServer;
use app\apis\validate\GetOrderStatus;
use app\apis\validate\OrderPlace;
use app\apis\validate\UpdateOrderStatus;


class Order extends BaseController
{
    /*
     *获取订单详情
     */
    public function getOrderDetail(){
        (new GetOrderStatus())->goCheck();
        $order  = new OrderServer();
        $num    = $this->request->post('order_num');
        $mid    = \app\apis\server\Token::getCurrentTokenVar('id');
        $detail = $order->getOrderDetail($num,$mid);
        return msg($detail);
    }
    /**
     * 更新订单状态
     */
    public function updateOrderStatus(){
        (new UpdateOrderStatus())->goCheck();
        $order  = new OrderServer();
        $params = input('post.');
        $mid    = \app\apis\server\Token::getCurrentTokenVar('id');
        $status = $order->updateOrder($params,$mid);
        return msg(['status'=>$status],0,'订单状态更新成功');
    }
    /*
     * 获取订单状态
     */
    public function getOrderStatus(){
        (new GetOrderStatus())->goCheck();
        $order  = new OrderServer();
        $num    = $this->request->post('order_num');
        $mid    = \app\apis\server\Token::getCurrentTokenVar('id');
        $status = $order->getOrderStatus($num,$mid);
        return msg($status);
    }

    /*
     * 创建订单
     */
    public function createOrder(){
        (new OrderPlace())->goCheck();
        $mid        = \app\apis\server\Token::getCurrentTokenVar('id');
        $order      = new OrderServer();
        $params     = $this->request->post();
        $orderNum   = $order->create($mid,$params);
        return msg(['order_number'=>$orderNum]);
    }

    /*
     * 获取配送价格
     */
    public function getDeliveryPrice(){
        (new Coord())->goCheck();
        $orderServer = new OrderServer();
        $mid         = \app\apis\server\Token::getCurrentTokenVar('id');
        $data        = $orderServer->price($mid);
        return msg($data);
    }

    /*
     * 获取附近骑手
     */
    public function getNearRider(){

    }


}