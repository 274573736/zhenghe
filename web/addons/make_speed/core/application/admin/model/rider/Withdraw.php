<?php

namespace app\admin\model\rider;

use think\Model;

class Withdraw extends Model
{
    // 表名
    protected $name = 'rider_withdraw';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_time_text',
        'update_time_text',
        'received_time_text'
    ];

    public function getStatusList(){
        return [
            0 => __('Status 0'),
            1 => __('Status 1'),
            2 => __('Status 2'),
        ];
    }

    //关联骑手
    public function rider(){
        return $this->belongsTo('\app\admin\model\Rider','rider_id')->setEagerlyType(0)->bind(['ridermobile'=>'mobile','ridername'=>'real_name']);
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


    public function getReceivedTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['received_time']) ? $data['received_time'] : '');
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

    protected function setReceivedTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
