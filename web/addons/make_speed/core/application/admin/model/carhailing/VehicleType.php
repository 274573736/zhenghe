<?php

namespace app\admin\model\carhailing;

use think\Model;


class VehicleType extends Model
{

    

    

    // 表名
    protected $name = 'car_vehicle_type';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







}
