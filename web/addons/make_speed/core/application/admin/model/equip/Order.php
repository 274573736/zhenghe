<?php

namespace app\admin\model\equip;

use think\Model;

class Order extends Model
{
    // 表名
    protected $name = 'equip_order';
    
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
     * 关联骑手
     */
    public function rider(){
        return $this->belongsTo('\app\admin\model\Rider','rider_id')->setEagerlyType(0)->bind(['ridername'=>'nick_name']);
    }

    /**
     * 关联商品
     */
    public function equip(){
        return$this->belongsTo('\app\admin\model\Equip','equip_id')->setEagerlyType(0)->bind(['equipname'=>'title']);
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
