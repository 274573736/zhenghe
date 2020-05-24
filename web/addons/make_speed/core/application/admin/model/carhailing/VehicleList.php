<?php

namespace app\admin\model\carhailing;

use think\Model;


class VehicleList extends Model
{

    

    

    // 表名
    protected $name = 'car_vehicle_detail';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text',
        'operate_status_text',
        'register_time_text',
        'online_time_text',
        'off_line_time_text'
    ];
    
    public function type(){
        return $this->hasOne('VehicleType','id','car_type_id');
    }

    public function brand(){
        return $this->hasOne('VehicleBrand','id','vehicle_brand_id');
    }
    
    public function getStatusList()
    {
        return ['1' => __('Status 1'), '0' => __('Status 0')];
    }

    public function getOperateStatusList()
    {
        return ['0' => __('Operate_status 0'), '1' => __('Operate_status 1'), '2' => __('Operate_status 2'), '3' => __('Operate_status 3')];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getOperateStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['operate_status']) ? $data['operate_status'] : '');
        $list = $this->getOperateStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getRegisterTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['register_time']) ? $data['register_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getOnlineTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['online_time']) ? $data['online_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getOffLineTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['off_line_time']) ? $data['off_line_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setRegisterTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setOnlineTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setOffLineTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
