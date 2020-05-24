<?php

namespace app\admin\model\rider;

use think\Model;

class Bind extends Model
{
    // 表名
    protected $name = 'rider_bind';
    
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


    /**
     * 状态列表
     */
    public function getStatusList(){
        return array(
            0   => __('Status 0'),
            1   => __('Status 1'),
            2   => __('Status 2'),

        );
    }

    /**
     * 关联骑手
     */
    public function rider(){
        return $this->belongsTo('\app\admin\model\Rider','rider_id')->setEagerlyType(0)->bind(['ridername'=>'nick_name']);
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
