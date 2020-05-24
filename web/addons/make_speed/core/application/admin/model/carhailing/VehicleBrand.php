<?php

namespace app\admin\model\carhailing;

use think\Model;


class VehicleBrand extends Model
{

    protected $name = 'car_vehicle_brand';
    
    protected $autoWriteTimestamp = 'int';

    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

}
