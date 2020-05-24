<?php

namespace app\admin\model\rider;

use think\Model;

class Message extends Model
{
    // 表名
    protected $name = 'rider_message';
    
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
     * 管理骑手
     */
    public function riders(){
        return $this->belongsTo('\app\admin\model\Rider','rider_id')->bind(['ridermobile'=>'mobile','ridername'=>'real_name']);
    }

    /**
     * 通知类型
     * @return array
     */
    public function getTypeList(){
        return [
            0 => __('Type 0'),
            1 => __('Type 1'),
            2 => __('Type 2'),
        ];
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
