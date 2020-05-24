<?php

namespace app\admin\model\rider;

use think\Model;

class Sanction extends Model
{
    // 表名
    protected $name = 'rider_sanction';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'type_text',
        'begin_time_text',
        'end_time_text',
        'add_time_text'
    ];

    /**
     * 关联骑手
     */
    public function riders(){
        return $this->belongsTo('\app\admin\model\Rider','rider_id')->setEagerlyType(0)->bind(['ridername'=>'real_name','avatar'=>'avatar']);
    }
    
    public function getTypeList()
    {
        return ['0' => __('Type 0'),'1' => __('Type 1')];
    }

    public function getClassList()
    {
        return [
            0 => __('Class 0'),
            1 => __('Class 1'),
            2 => __('Class 2'),
            3 => __('Class 3'),
        ];
    }

    public function getNotifyList(){
        return [
            0 => __('Notify 0'),
            1 => __('Notify 1'),
            2 => __('Notify 2'),
        ];
    }

    public function getStatusList(){
        return [
            0 => __('Status 0'),
            1 => __('Status 1'),
            2 => __('Status 2'),
        ];
    }


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
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
