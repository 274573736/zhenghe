<?php


namespace app\admin\model\distribution;
use think\Model;

class Order extends Model
{
    protected $name = 'distribution_order';

    public function getStatusList(){
        return [
            0 => '待付款',1=>'待分佣',2=>'已分佣',3=>'已取消',
        ];
    }
    public function payUser(){
        return $this->hasOne('app\admin\model\User','id','pay_user_id');
    }

    public function distribution(){
        return $this->hasOne('app\admin\model\User','id','user_id');
    }
}