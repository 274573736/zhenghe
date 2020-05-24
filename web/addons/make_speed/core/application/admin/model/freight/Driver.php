<?php

namespace app\admin\model\freight;

use think\Model;


class Driver extends Model
{



    

    // 表名
    protected $name = 'rider_fdriver';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'create_time_text',
        'update_time_text'
    ];




    public function getStatusList(){
        return [
            0   =>  '待审核',
            1   =>  '审核通过',
            2   =>  '审核失败',
        ];
    }

    //关联骑手
    public function rider(){
        return $this->belongsTo('app\admin\model\Rider','rider_id')->field('real_name')->setEagerlyType(0);
    }

    //关联车型
    public function vehicle(){
        return $this->belongsTo('vehicle','car_id');
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
