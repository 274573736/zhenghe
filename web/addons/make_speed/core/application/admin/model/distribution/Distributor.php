<?php

namespace app\admin\model\distribution;

use think\Model;


class Distributor extends Model
{

    

    

    // 表名
    protected $name = 'distribution_distributor';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text',
        'create_time_text',
        'update_time_text'
    ];

    public function user(){
        return $this->hasOne('app\admin\model\User','id','user_id');
    }
    public function grade(){
        return $this->hasOne('grade','id','gid','','left');
    }

    public function superior(){
        return $this->hasOne('app\admin\model\User','id','pid');
    }

    
    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1'),'2'=>'审核失败'];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
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
