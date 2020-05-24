<?php

namespace app\admin\model;

use think\Model;

class Banner extends Model
{
    // 表名
    protected $name = 'banner';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_time_text'
    ];

    public function getPageUrl(){
        $url = array(
            ''      => '无',
            '/make_speed/big_customer/info/info'  => '大客户中心',
            '/make_speed/activity/activity'  => '活动分享',
            '/make_speed/store/store'  => '积分兑换商城',
            '/make_speed/index/index'  => '帮送',
            '/make_speed/help_buy/help_buy'  => '帮买',
            '/make_speed/all_powerful/all_powerful'    => '万能服务',
            '/make_speed/replace_driver/replace_driver'  => '代驾',
        );

        return $url;
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
