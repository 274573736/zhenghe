<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'get_time_text',
        'add_time_text',
        'update_time_text'
    ];
    
    //关联用户
    public function user(){
        return $this->belongsTo('user','user_id','id')->setEagerlyType(0)->bind(['username'=>'nick_name'])->field('nick_name');
    }

    //关联物品类型
    public function goods(){
        return $this->belongsTo('goods_type','goods_id')->setEagerlyType(1);
    }

    //关联大客户
    public function business(){
        return $this->belongsTo('business','business_id')->setEagerlyType(0)->field('id,name');
    }

    //关联接口
    public function clouds(){
        return $this->belongsTo('clouds','clouds_id')->setEagerlyType(0)->field('id,name,modules_name');
    }

    //关联订单地址
    public function address(){
        return $this->hasOne('order_address','order_id');
    }

    //关联接单信息
    public function accept(){
        return $this->hasOne('order_rider','order_id');
    }

    //关联骑手
    public function riders(){
        return $this->belongsToMany('rider','order_rider','rider_id','order_id')
                    ->field('nick_name,mobile,avatar');
    }
  //绑定骑手
    public function orider(){
        return $this->belongsTo('order_rider','order_id','id');
    }
    //关联城市
    public function city(){
        return $this->belongsTo('city', 'city_id')->setEagerlyType(0);
    }


    public function orderRider(){
        return $this->belongsTo('OrderRider','id','order_id');
    }


    public function getPaymentList()
    {
        return ['1' => __('Payment 1'), '2' => __('Payment 2')];
    }


    public function getStatusList(){
        return [

            0   =>  __('Status 0'),
            1   =>  __('Status 1'),
            2   =>  __('Status 2'),
            3   =>  __('Status 3'),
            4   =>  __('Status 4'),
            5   =>  __('Status 5'),
            6   =>  __('Status 6')
        ];
    }

    public function getGetTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['get_time']) ? $data['get_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    public function getAddTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['add_time']) ? $data['add_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUpdateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['update_time']) ? $data['update_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setGetTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setAddTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
