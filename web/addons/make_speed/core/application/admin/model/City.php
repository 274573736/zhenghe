<?php

namespace app\admin\model;

use think\Model;

class City extends Model
{
    // 表名
    protected $name = 'city';
    
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
     * 是否热门列表
     * @return array
     */
    public function getHotStatusList(){
        return ['0' => __('Is_hot 0'),'1' => __('Is_hot 1')];
    }

    /**
     * 是否禁用列表
     * @return array
     */
    public function getDisabledStatusList(){
        return ['0' => __('Is_disabled 0'), '1' => __('Is_disabled 1')];
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
