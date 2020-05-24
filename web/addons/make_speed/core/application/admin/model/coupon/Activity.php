<?php

namespace app\admin\model\coupon;

use think\Model;

class Activity extends Model
{
    // 表名
    protected $name = 'coupon_activity';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'begin_time_text',
        'end_time_text',
        'add_time_text'
    ];

    //类型
    public function getTypeList(){
        return [
            0 => __('Type 0'),
            1 => __('Type 1'),
            2 => __('Type 2'),
        ];
    }

    public function getIsDisabledList(){
        return [
            0 => __('Is_disabled 0'),
            1 => __('Is_disabled 1')
        ];
    }

    //关联优惠券
    public function coupon(){
        return $this->belongsTo('\app\admin\model\Coupons', 'coupon_id')->bind(['coupon_name'=>'title','money'=>'money']);
    }

    public function getBeginTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['begin_time']) ? $data['begin_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    public function getEndTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['end_time']) ? $data['end_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    public function getAddTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['add_time']) ? $data['add_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setBeginTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setEndTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setAddTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
