<?php

namespace app\admin\model\user;

use think\Model;

class Cashlog extends Model
{
    // 表名
    protected $name = 'user_cashlog';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_time_text'
    ];
    
    //关联用户
    public function users(){
        return $this->belongsTo('\app\admin\model\User', 'user_id')->bind(['username'=>'nick_name']);
    }

    public function business(){
        return $this->belongsTo('\app\admin\model\Business', 'business_id')->setEagerlyType(0);
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
