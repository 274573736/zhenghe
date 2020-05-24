<?php
namespace app\apis\model;


class Order extends BaseModel
{
//    protected $validate = [];

    public function getAddTimeAttr($value,$data){
        $date = $this->convertData($value,$data);
        return $date;
    }
    public function getStatusAttr($value,$data){
        $status = array('loading','cancel','payed','accepted','geted','gotoed','completed');
        $text   = array('待付款', '订单已取消', '待接单', '待取件', '待收件', '待评价', '订单已完成');
        empty($status[$value]) && $status[$value] = $value;
        return $status[$value];
    }

    public static function getOrderBynum($order_num){
        $order = self::where(['order_code'=>$order_num])->find();
        return $order;
    }
    public function orderAddress(){
        return $this->hasOne('OrderAddress','order_id','id');
    }
    public function orderRider(){
        return $this->hasOne('OrderRider','order_id','id',[],'LEFTJOIN');
    }

    public static function order_detail($id){
        $visible = [
            'id','order_code','oget_time','goodsname','distance','pay_price','description','status','add_time',
            'order_address',
            'order_rider','order_rider.accept_time','order_rider.get_time','order_rider.goto_time','order_rider.complete_time',
            'order_rider.pick_img','order_rider.end_img','order_rider.accept_time',
            'order_rider.rider'
        ];
        $order = self::with(['orderAddress','orderRider','orderRider.rider'])->find($id);
        $order = $order->visible($visible);
        return $order;
    }
}