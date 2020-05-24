<?php

namespace app\admin\model\distribution;

use think\Model;


class Grade extends Model
{
    // 表名
    protected $name = 'distribution_grade';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'auto_level_text',
        'create_time_text',
        'update_time_text'
    ];
    

    
    public function getAutoLevelList()
    {
        return ['0' => __('Auto_level 0'), '1' => __('Auto_level 1')];
    }


    public function getAutoLevelTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['auto_level']) ? $data['auto_level'] : '');
        $list = $this->getAutoLevelList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUpdateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['update_time']) ? $data['update_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
