<?php

namespace app\admin\model;

use think\Model;

class Setting extends Model
{
    // 表名
    protected $name = 'setting';
    
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
     * 获取已设置的属性
     */
    public function getExitsKey(){
        return $this->where(array('uniacid'=>$GLOBALS['uniacid'],'city_id'=>$GLOBALS['city_id']))->column('key');
    }


    /**
     * 添加/更新属性值
     * @param string|array	$params 键值数组形式或字符串
     * @return string
     */
    public function saveValue($params){

        if(!empty($GLOBALS['city_id'])){
            $controller = request()->controller();
            if(strtolower($controller)!=='setting.price'){
                return 0;
            }
        }

        is_array($params) || $params = explode(',',$params);

        $exits = $this->getExitsKey();

        $status = 0;
        foreach ($params as $k => $v){
            if(empty($k))
                continue;

            if(!in_array($k, $exits)){

                if(empty($v) && $v!==0){
                    continue;
                }

                $result = $this->insert(['key'=>$k, 'value'=>$v,'city_id'=>$GLOBALS['city_id'], 'uniacid'=>$GLOBALS['uniacid']]);
                !empty($result) && $status += 1;
            }else{

                $result = $this->where(['key'=>$k,'uniacid'=>$GLOBALS['uniacid'],'city_id'=>$GLOBALS['city_id']])->update(['value'=>$v]);
                !empty($result) && $status += 1;
            }
        }

        return $status;
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
