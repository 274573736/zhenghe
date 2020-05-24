<?php

namespace app\admin\model\carhailing;

use think\Model;


class Driver extends Model
{


    // 表名
    protected $name = 'car_driver';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'add_time';
    protected $updateTime = 'update_time';

    // 追加属性
    protected $append = [
        'work_status_text',
        'status_text',
    ];

    public function rider(){
        return $this->hasOne('app\admin\model\Rider','id','rider_id');
    }

    public function getWorkStatusList()
    {
        return ['1' => __('Work_status 1'), '2' => __('Work_status 2'), '3' => __('Work_status 3')];
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1'), '2' => __('Status 2')];
    }


    public function getDriverExpTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['driver_exp_time']) ? $data['driver_exp_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getWorkStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['work_status']) ? $data['work_status'] : '');
        $list = $this->getWorkStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function setDriverExpTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

}

