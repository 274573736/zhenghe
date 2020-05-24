<?php


namespace app\admin\model;
use think\Model;

class CancelOrder extends  Model
{
    public function order(){
        return $this->hasOne('order','id','order_id','','left');
    }

    public function rider(){
        return $this->hasOne('rider','id','rider_id','','left');
    }
}