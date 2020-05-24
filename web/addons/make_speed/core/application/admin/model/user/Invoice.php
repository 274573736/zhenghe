<?php

namespace app\admin\model\user;

use think\Model;

class Invoice extends Model
{
    // 表名
    protected $name = 'user_invoice';
    
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
    

    public function users(){
        return $this->belongsTo('\app\admin\model\User', 'user_id')->field('id,nick_name')->setEagerlyType(0);
    }


    public function getStatusList(){
        return array(
            0   => __('Status 0'),
            1   => __('Status 1'),
            2   => __('Status 2'),
        );
    }

    public function getTypeList(){
        return array(
            0   => __('Type 0'),
            1   => __('Type 1'),
        );
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
