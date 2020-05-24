<?php

namespace app\admin\model;

use think\Model;

class Rider extends Model
{
    // 表名
    protected $name = 'rider';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_time_text',
        'update_time_text',
        'logged_time_text'
    ];

    //等级
    public function gradeList(){
        return [
            0 => __('Grade 0'),
            1 => __('Grade 1'),
            2 => __('Grade 2'),
            3 => __('Grade 3'),
        ];
    }
    public function statusList(){
        return [
            0 =>__('Status 0'),
            1 =>__('Status 1'),
            2 =>__('Status 2'),
        ];
    }
    public function getStatusoList(){
        return [

            0   =>  __('Statuso 0'),
            1   =>  __('Statuso 1'),
            2   =>  __('Statuso 2'),
            3   =>  __('Statuso 3'),
            4   =>  __('Statuso 4'),
            5   =>  __('Statuso 5'),
            6   =>  __('Statuso 6')
        ];
    }

    //关联推荐人
    public function recommend(){
        return $this -> belongsTo('rider','recommend_id')->bind(['recommend_name'=>'real_name']);
    }

    //关联推荐人
    public function srecommend(){
        return $this->hasMany('rider','recommend_id')->field('id,real_name,recommend_id');
    }

    //关联配送信息
    public function info(){
        return $this->hasOne('rider_info', 'rider_id');
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


    public function getLoggedTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['logged_time']) ? $data['logged_time'] : '');
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

    protected function setLoggedTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
