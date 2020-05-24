<?php

namespace app\admin\model\train;

use think\Model;

class Rider extends Model
{
    // 表名
    protected $name = 'train_rider';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'time_text'
    ];


    public function riders(){
        return $this->belongsTo('\app\admin\model\Rider','rider_id')->setEagerlyType(0)->bind(['ridername'=>'real_name','ridermobile'=>'mobile']);
    }

    public function train(){
        return $this->belongsTo('point','train_id')->setEagerlyType(0)->bind(['trainname'=>'name','morntime'=>'morn','aftertime'=>'after']);
    }

    public function getStatusList(){
        return [
            0 => __('Status 0'),
            1 => __('Status 1'),
            2 => __('Status 2'),

        ];
    }

    public function getTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['time']) ? $data['time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
