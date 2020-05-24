<?php

namespace app\admin\model\carhailing;

use think\Model;


class Line extends Model
{

    

    

    // 表名
    protected $name = 'car_line';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;


    public function city(){
        return $this->hasOne('app\admin\model\City','id','starting');
    }

    public function endCity(){
        return $this->hasOne('app\admin\model\City','id','destination');
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1')];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getDepartureTimeAttr($value){
        return $value ? explode(',',$value) : '';
    }
    public function getTodayDepartureTimeAttr($value){
        return $value ? explode(',',$value) : '';
    }


    protected function setAppointmentTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setOpenTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCloseTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


    protected function setDepartTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
