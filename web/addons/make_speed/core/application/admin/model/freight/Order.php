<?php

namespace app\admin\model\freight;

use think\Model;


class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'get_time_text',
        'order_time_text',
        'distance_time_text',
        'expect_time_text',
        'add_time_text',
        'update_time_text'
    ];


    //关联用户
    public function user(){
        return $this->belongsTo('app\admin\model\User','user_id')->setEagerlyType(0)->bind(["username"=>"nick_name"])->field('nick_name');
    }

    //关联车型
    public function vehicle(){
        return $this->hasOne('vehicle','id','car_id');
    }


    //关联订单地址
    public function address(){
        return $this->hasOne('app\admin\model\OrderAddress','order_id');
    }

    public function orderRider(){
        return $this->belongsTo('app\admin\model\OrderRider','id','order_id')->setEagerlyType(0);
    }

    public function orderRiderLeft(){
        return $this->belongsTo('app\admin\model\OrderRider','id','order_id','order_rider','LEFT')->setEagerlyType(0);
    }


    public function getGetTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['get_time']) ? $data['get_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getOrderTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['order_time']) ? $data['order_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getDistanceTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['distance_time']) ? $data['distance_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getExpectTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['expect_time']) ? $data['expect_time'] : '');
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

    public function getStatusList(){
        return [
            0   =>  __('Status 0'),
            1   =>  __('Status 1'),
            2   =>  __('Status 2'),
            3   =>  __('Status 3'),
            4   =>  __('Status 4'),
            5   =>  __('Status 5'),
        ];
    }
    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setGetTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setOrderTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setDistanceTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setExpectTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setAddTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
