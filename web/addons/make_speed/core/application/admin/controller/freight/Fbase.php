<?php
/**
 * Created by PhpStorm.
 * User: HelloWord
 * Date: 2019/9/6
 * Time: 18:05
 */

namespace app\admin\controller\freight;
use think\Controller;
use app\common\controller\Backend;


class Fbase extends Backend
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function checkPlug($table){
        $tableName  = config('database.prefix').$table;
        $isTable    = db()->query('SHOW TABLES LIKE '."'".$tableName."'");
        if(!$isTable) {
            return $this->error('该插件尚未购买','','',0);
        }

    }

    public function wxPath(){
        return [

            '服务网点'      => 'service_web/service_web',
            '操作指南'      => 'question/question',
            '优惠券页'      => 'coupon/coupon',
            '关于我们'      => 'we/we',
            '问题反馈'      => 'feedback/feedback',
            '个人中心'      => 'info/info',
            '司机注册页'    => 'driver/register/register'
        ];
    }
}