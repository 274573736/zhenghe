<?php

namespace app\admin\model;

use think\Model;

class Business extends Model
{
    // 表名
    protected $name = 'business';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'add_time';
    protected $updateTime = 'update_time';
    
    // 追加属性
    protected $append = [
        'add_time_text',
        'update_time_text'
    ];


    public function getStatusList(){
        return [
            0   =>  __('Status 0'),
            1   =>  __('Status 1'),
            2   =>  __('Status 2'),
        ];
    }

    public function orders(){
        return $this->hasMany('\app\admin\model\Order','business_id');
    }

    public function users(){
        return $this->belongsTo('\app\admin\model\User','user_id')->bind(['user'=>'nick_name']);
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
