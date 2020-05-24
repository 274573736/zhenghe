<?php

namespace app\admin\model\freight;

use think\Model;


class VirtualDriver extends Model
{

    

    

    // 表名
    protected $name = 'virtual_driver';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'is_show_text',
        'create_time_text',
        'update_time_text'
    ];
    

    
    public function getIsShowList()
    {
        return ['0' => __('Is_show 0'), '1' => __('Is_show 1')];
    }


    public function getIsShowTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_show']) ? $data['is_show'] : '');
        $list = $this->getIsShowList();
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
