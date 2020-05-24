<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;
use think\Db;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {

        $where = array('uniacid'=>$GLOBALS['uniacid']);

        //用户统计 统计数量
        $totaluser = Db::name('user')->where($where)->count();

        //骑手已提现金额
        $rideramount = Db::name('rider_withdraw')->where($where)->where(array('status'=>2))->sum('money');

        //是否代理城市
        !empty($GLOBALS['city_id']) && $where['city_id'] = $GLOBALS['city_id'];

        //骑手总人数
        $ridernum = Db::name('rider')->where($where)->count();

        //支付成功过的总金额
        $totalorderamount = Db::name('order')->where($where)->where(['status'=>['>=',2]])->sum('pay_price');

        //订单统计
        $totalorder= Db::name('order')->where($where)->count();

        $totalorderwait = Db::name('order')->where(array_merge($where,array('status'=>2)))->count();

        //订单数据
        $paylist = $createlist = [];
        $n = 20;
        for ($i = 0; $i <= 20; $i++)
        {
            $day = date("m月d",strtotime('-'.($n-$i).' day'));
            $days = date("Y-m-d",strtotime('-'.($n-$i).' day'));

            $daymin = strtotime($days);
            $daymax = strtotime('+1 day',$daymin);

            //订单总数
            $createlist[$day] = Db::name('order')
                                ->where($where)
                                ->where('add_time','between time',[$daymin,$daymax])
                                ->count();

            //付款订单数
            $paylist[$day] = Db::name('order')
                                ->where(array_merge($where,array('status'=>['>',1])))
                                ->where('add_time','between time',[$daymin,$daymax])
                                ->count();
        }

        $today_time = strtotime(date('Y-m-d'));
        $today_time2= strtotime('+1 day', $today_time);

        //今日完成订单数
        $today_order = Db::name('order')
            ->where(array_merge($where,array('status'=>['>=',2])))
            ->where('add_time','between time',[$today_time,$today_time2])
            ->count();

        //今日收入
        $today_income = Db::name('order')
            ->where(array_merge($where,array('status'=>['>=',2])))
            ->where('add_time','between time',[$today_time,$today_time2])
            ->sum('pay_price');

        $cweek = date('w');
        $toweek_time = strtotime(date('Y-m-d', strtotime('-'.($cweek ? ($cweek-1) : 6).' day')));
        $toweek_time2= strtotime(date('Y-m-d', strtotime('+7 day', $toweek_time)));
        //本周订单数
        $toweek_order = Db::name('order')
            ->where(array_merge($where,array('status'=>['>=',2])))
            ->where('add_time','between time',[$toweek_time,$toweek_time2])
            ->count();

        //本周收入
        $toweek_income = Db::name('order')
            ->where(array_merge($where,array('status'=>['>=',2])))
            ->where('add_time','between time',[$toweek_time,$toweek_time2])
            ->sum('pay_price');

        //今日新用户
        $today_user = Db::name('user')
            ->where(['uniacid'=>$GLOBALS['uniacid']])
            ->where('add_time','between time',[$today_time,$today_time2])
            ->count();

        //今日提现
        $today_tixian = Db::name('rider_withdraw')
            ->where(['uniacid'=>$GLOBALS['uniacid'], 'status'=>2])
            ->where('add_time','between time',[$today_time,$today_time2])
            ->count();

        $this->view->assign([
            'rideramount'      => $rideramount,
            'ridernum'         => $ridernum,
            'totaluser'        => $totaluser,
            'totalorderwait'   => $totalorderwait,
            'totalorder'       => $totalorder,
            'totalorderamount' => $totalorderamount,
            'paylist'          => $paylist,
            'createlist'       => $createlist,

            'today_user'       => $today_user,
            'today_order'      => $today_order,
            'today_income'     => $today_income,

            'week_order'       => $toweek_order,
            'week_income'      => $toweek_income,
            'today_tixian'     => $today_tixian,
        ]);

        return $this->view->fetch();
    }


}
