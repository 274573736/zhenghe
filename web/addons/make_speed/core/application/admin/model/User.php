<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    // 表名
    protected $name = 'user';
    
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

    //关联推荐人
    public function recommend(){
        return $this -> belongsTo('user','recommend_id')->bind(['recommend_name'=>'nick_name']);
    }

    //推荐骑手
    public function riders(){
        return $this -> belongsTo('rider', 'recommend_rider')->bind(['recommend_riders'=>'real_name']);
    }

    public function grade(){
        return $this->belongsTo('\app\admin\model\user\Grade','user_grade')->bind(['usergrade'=>'name','gradeicon'=>'icon']);
    }

    public function getSexList(){
        return [0 => __('Sex 0'), 1 => __('Sex 1')];
    }
    
    public function getGradeList(){
        $grade = db('user_grade')->where(['uniacid'=>$GLOBALS['uniacid']])->field('id,name,grow')->column('id,name');
        $grade[0] = '普通用户';
        ksort($grade);
        return $grade;
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
