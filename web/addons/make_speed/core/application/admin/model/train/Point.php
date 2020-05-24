<?php

namespace app\admin\model\train;

use think\Model;

class Point extends Model
{
    // 表名
    protected $name = 'train_point';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_time_text'
    ];

    /**
     * 星期列表
     */
    public function getWeekList(){

        return array(
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
            0 => '星期天',
        );

    }

    /**
     * 关联城市
     */
    public function city(){
        return $this->belongsTo('\app\admin\model\City','city_id')->bind(['city_name'=>'name']);
    }

    public function getAddTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['add_time']) ? $data['add_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAddTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
