<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;
use think\Db;
use think\Log;


/**
 * 后台首页
 * @internal
 */
class Crontab extends Backend
{

    protected $noNeedLogin = ['day'];
    protected $noNeedRight = ['day'];
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 每天执行任务
     */
    public function day()
    {
        $uniacid = !empty($_REQUEST['uniacid']) ? intval($_REQUEST['uniacid']) : 0;

        $dayed = strtotime('-1 day');

        $where = array(
            'o.status'    => 5,
            'o.add_time'  => ['<', $dayed],
            'o.uniacid'   => $uniacid,
        );

        //JOIN
        $join = [
            ['user u', 'o.user_id=u.id'],
            ['order_rider or', 'or.order_id=o.id', 'left'],
        ];

        //查询字段
        $selectFiled = [
            'o.id as order_id','o.user_id','or.rider_id'
        ];

        $orders = Db::name('order')
            ->alias('o')
            ->where($where)
            ->join($join)
            ->field($selectFiled)
            ->select();

        //积分成长值
        $gralgrows = Db::name('setting')->where('uniacid',$uniacid)->where('key','in','user_gral,user_grow')->column('key,value');

        $gralgrows['user_gral'] = !empty($gralgrows['user_gral']) ? $gralgrows['user_gral'] : 1;
        $gralgrows['user_grow'] = !empty($gralgrows['user_grow']) ? $gralgrows['user_grow'] : 1;

        $updata['complete_time'] = time();
        $updata['score'] = 100;
        $updata['tag']   = '速度快|服装整齐|取件快|着装正规';
        $n = 0;

        foreach ($orders as $k=>$v){
            //更新骑手评分
            Db::name('order_rider')->where(array('order_id'=>intval($v['order_id'])))->update($updata);

            $result = Db::name('order')->where(array('id'=>$v['order_id']))->field('status,total_price')->find();

            //更新成长值积分
            $userdata = array(
                'gral'  => ceil($gralgrows['user_gral'] * $result['total_price']),
                'grow'  => ceil($gralgrows['user_grow'] * $result['total_price']),
            );
            Db::name('user')->where(array('id'=>$v['user_id']))->setInc('gral', $userdata['gral']);
            Db::name('user')->where(array('id'=>$v['user_id']))->setInc('grow', $userdata['grow']);

            //按成长值升级用户等级
            $user = Db::name('user')->where(array('id'=>$v['user_id']))->field('grow,user_grade')->find();
            $grade = Db::name('user_grade')->where(array('uniacid'=>$uniacid))->column('id,grow');
            if(!empty($grade) && is_array($grade)){
                arsort($grade);
                foreach ($grade as $k1=>$v1){
                    if(($user['grow']+$userdata['grow']) >= $v1 && (!empty($grade[$user['user_grade']]) && $v1 >= $grade[$user['user_grade']])){
                        Db::name('user')->where(array('id'=>$v['user_id']))->update(array('user_grade'=>$k1));
                        break;
                    }
                }
            }

            //更新订单状态
            $up = Db::name('order')->where(array('id'=>$v['order_id']))->update(array('status'=>6));
            !empty($up) && $n++;
        }

        Log::record(date('Y-m-d H:i:s').'[Crontab Order Complete]: '.$n,'error');

    }

}
