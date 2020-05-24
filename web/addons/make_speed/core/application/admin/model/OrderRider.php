<?php
/**
 * Created by PhpStorm.
 * User: sweets
 * Date: 2019/9/30
 * Time: 10:42
 */

namespace app\admin\model;
use think\Model;

class OrderRider extends Model
{
// 表名
    protected $name = 'order_rider';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'add_time_text',
        'update_time_text'
    ];
    public function order(){
        return $this->hasOne('order','id','order_id','','INNER JOIN');
    }


    public function orders(){
        return $this->hasOne('order','order_id');
    }

    public function rider(){
        return $this->hasOne('rider','id','rider_id');
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

    protected function setAddTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}