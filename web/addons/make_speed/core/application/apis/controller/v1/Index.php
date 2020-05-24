<?php

namespace app\apis\controller\v1;

use app\common\controller\Apis;
use think\Db;
use think\Request;

/**
 * 首页接口
 */
class Index extends Apis
{
    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功');
    }

    /**
     * 获取附件骑手
     */
    public function getrider(){

        $lat = !empty($_REQUEST['lat']) ? doubleval($_REQUEST['lat']) : 0;
        $lng = !empty($_REQUEST['lng']) ? doubleval($_REQUEST['lng']) : 0;

        $odistance = !empty($_REQUEST['order_distance']) ? floatval($_REQUEST['order_distance']) : 0;

        if(empty($lat) || empty($lng))
            $this->error('订单起点经纬度不能为空！');

        if(empty($odistance)){
            $this->error('订单配送距离不能为空！');
        }

        if($odistance > 40){
            $this->error('订单配送距离超出30公里,无法使用跑腿配送服务');
        }

        $result = get_scope_rider($lat, $lng);

        if(empty($result)){
            $this->error('订单起点附近暂无骑手接单！');
        }

        $riderid = array_column($result, 'rider_id');

        $rider = Db::name('rider')->where('id', 'in', $riderid)->column('id,mobile,real_name');

        if(empty($rider)){
            $this->error('搜索骑手失败！');
        }


        foreach ($rider as $k => $v){
            $result[$k]['mobile'] = $v['mobile'];
            $result[$k]['real_name'] = $v['real_name'];
            if(!empty($result[$k]['rider_id']))
                unset($result[$k]['rider_id']);
        }

        $result = array_merge($result);
        $this->success('ok', $result);
    }

    /**
     * 获取配送费用
     */
    public function getprice(){

        $x  = !empty($_REQUEST['distance']) ? floatval($_REQUEST['distance']): 0;
        $w  = !empty($_REQUEST['weight']) ? floatval($_REQUEST['weight']) : 0;

        //min_weight 最低公斤   min_distance 起步公里    initial_price 起步价格  distance续程
        //所在城市
        $keys = array('initial_price','min_distance','min_weight','distance');

        $results = Db::name('setting')->where(array('uniacid'=>$GLOBALS['uniacid'], 'city_id'=>0))->where('key', 'in', $keys)->column('id,key,value');

        if(empty($results)){
            $datap = array(
                'amount'        => 12,
                'night_price'   => 0,
                'change_price'  => 0,
                'distance_price'=> 0,
            );

            $datas = array(
                'amount'        => 12,
                'amount_detail' => $datap,
            );
            $this->result(0,'', $datas );
        }

        $results = array_column($results,'value','key');

        $results['distance'] = !empty($results['distance']) ? unserialize($results['distance']) : array();

        $results['weight'] = !empty($results['weight']) ? unserialize($results['weight']) : array();


        $money = 12;//默认12块
        if(!empty($results['initial_price']))
            $money = sprintf('%.2f',$results['initial_price']);

        krsort($results['distance']);
        foreach ($results['distance'] as $k=>$v){
            if($x>$k) {
                $money += ($x - $k) * $v;
                $x = $k;
            }
        }

        krsort($results['weight']);
        foreach ($results['weight'] as $wk=>$wv){
            if($w>$wk) {
                $money += ($w - $wk) * $wv;
                $w = $wk;
            }
        }

        //里程费
        $distance_price = $money;

        //溢价
        $money += !empty($results['change_price']) ? $results['change_price'] : 0;

        //夜间时间段
        $results['night_time'] = !empty($results['night_time']) ? unserialize($results['night_time']) : array();

        $fh = !empty($results['night_time'][0]) ? trim($results['night_time'][0]) : 0;
        $lh = !empty($results['night_time'][1]) ? trim($results['night_time'][1]) : 0;

        $c = strtotime(date('Y-m-d H:i'));
        $f = strtotime(date('Y-m-d').' '.$fh);
        $l = strtotime(date('Y-m-d').' '.$lh);

        empty($results['night_price']) && $results['night_price']=0;
        empty($results['change_price']) && $results['change_price']=0;
        //夜间费用时间段内
        $night_price = 0;
        if(($c > $f) || ($c < $l) ){
            $money += $results['night_price'];
            $night_price = $results['night_price'];
        }

        $data = array(
            'amount'        => sprintf('%.2f', $money),
            'night_price'   => $night_price,
            'change_price'  => $results['change_price'],
            'distance_price'=>$distance_price,
        );

        $datas = array(
            'amount'        => sprintf('%.2f', $money),
            'amount_detail' => $data,
        );


        $this->success('ok',$datas);
    }

    /**
     * 添加订单
     */
    public function addorder(){

        $keys = array(
            'goods_name', 'pick_time', 'distance',
            'distance_price', 'pay_price','remark','address'
        );

        $ekey = array_diff($keys, array_keys($_POST));

        if(!empty($ekey)){
            $this->error('缺少参数：'.implode(', ', $ekey));
        }

        $data   = array(
            'goodsname'     => !empty($_POST['goods_name']) ? trim($_POST['goods_name']) : '',
            'get_time'      => !empty($_POST['pick_time']) ? trim($_POST['pick_time']) : '',
            'small_price'   => !empty($_POST['small_price']) ? sprintf('%.2f', floatval($_POST['small_price'])) : 0,
            'distance'      => !empty($_POST['distance']) ? sprintf('%.2f', floatval($_POST['distance'])) : 0.1,
            'weight'        => !empty($_POST['weight']) ? sprintf('%.2f', floatval($_POST['weight'])) : 0,
            'distance_price'=> !empty($_POST['distance_price']) ? sprintf('%.2f', floatval($_POST['distance_price'])) : 0,
            'total_price'   => !empty($_POST['pay_price']) ? sprintf('%.2f', floatval($_POST['pay_price'])) : 0,
            'pay_price'     => !empty($_POST['pay_price']) ? sprintf('%.2f', floatval($_POST['pay_price'])) : 0,
            'description'   => !empty($_POST['remark']) ? trim($_POST['remark']) : '',
        );

        $verify = is_notempty($_POST, array(), array('remark','total_price'));
        if($verify!==true){
            $this->error($verify);
        }

        $a_post = !empty($_POST['address']) ? @json_decode($_POST['address'], true) : array();

        if(empty($a_post)){
            $this->error('订单配送地址信息参数有误');
        }

        $data['order_code'] = generate_order_code(18, 'A', true);
        $data['uniacid']    = $GLOBALS['uniacid'];
        $data['clouds_id']   = $GLOBALS['cloud_id'];

        $oadd = Db::name('order')->insertGetId($data);

        if(empty($oadd)){
            Db::name('order')->where('id', $oadd)->delete();
            $this->error('配送订单生成失败, 请检查参数是否正确');
        }

        //"{"begin_detail":"万达国际B座 1918室","begin_address":"南宁市西乡塘区安吉万达广场","begin_lat":22.870071,"begin_lng":108.2927,"begin_username":"sweetsლ","begin_phone":"15977966704","end_detail":"","end_address":"南宁-东盟企业总部基地二期","end_lat":22.866558,"end_lng":108.280449,"end_username":"星星的亮光","end_phone":"13557432464"}"

        $keys = array(
            'begin_address', 'begin_lat', 'begin_lng', 'begin_username', 'begin_phone',
            'end_address', 'end_lat','end_lng','end_username','end_phone'
        );

        $ekey = array_diff($keys, array_keys($a_post));
        if(!empty($ekey)){
            Db::name('order')->where('id', $oadd)->delete();
            $this->error('配送地址参数缺少：'.implode(', ', $ekey));
        }

        $address_data   = array(
            'order_id'      => $oadd,
            'begin_detail'  => !empty($a_post['begin_detail']) ? trim($a_post['begin_detail']) : '',
            'begin_address' => !empty($a_post['begin_address']) ? trim($a_post['begin_address']) : '',
            'begin_lat'     => !empty($a_post['begin_lat']) ? doubleval($a_post['begin_lat']) : 0,
            'begin_lng'     => !empty($a_post['begin_lng']) ? doubleval($a_post['begin_lng']) : 0,
            'begin_username'=> !empty($a_post['begin_username']) ? trim($a_post['begin_username']) : '',
            'begin_phone'   => !empty($a_post['begin_phone']) ? trim($a_post['begin_phone']) : '',

            'end_detail'  => !empty($a_post['end_detail']) ? trim($a_post['end_detail']) : '',
            'end_address' => !empty($a_post['end_address']) ? trim($a_post['end_address']) : '',
            'end_lat'     => !empty($a_post['end_lat']) ? doubleval($a_post['end_lat']) : 0,
            'end_lng'     => !empty($a_post['end_lng']) ? doubleval($a_post['end_lng']) : 0,
            'end_username'=> !empty($a_post['end_username']) ? trim($a_post['end_username']) : '',
            'end_phone'   => !empty($a_post['end_phone']) ? trim($a_post['end_phone']) : '',
        );

        $add = Db::name('order_address')->insert($address_data);

        if(empty($add)){
            Db::name('order')->where('id', $oadd)->delete();
            $this->error('订单配送地址添加失败, 请检查参数是否正确');
        }

        $this->success('ok',array('order_code'=>$data['order_code']));
    }


    /**
     * 获取订单配送状态
     */
    public function orderstatus(){

        $code = !empty($_REQUEST['order_code']) ? trim($_REQUEST['order_code']) : '';
        $order = Db::name('order')->where('order_code', $code)->field('id,status')->find();

        if(empty($order) || !isset($order['status'])){
            $this->error('暂无此订单信息');
        }

        $status = array('loading','cancel','payed','accepted','geted','gotoed','completed');

        $text = array('待付款', '订单已取消', '待接单', '待取件', '待收件', '待评价', '订单已完成');

        empty($status[$order['status']]) && $status[$order['status']] = $order['status'];

        $this->success('ok', array('status'=>$status[$order['status']],'remark'=>!empty($text[$order['status']]) ? $text[$order['status']] : '未知?'));
    }

    /**
     * 更新订单支付状态
     */
    public function updateorder(){
        $code = !empty($_REQUEST['order_code']) ? trim($_REQUEST['order_code']) : '';
        $status = !empty($_REQUEST['status']) ? trim($_REQUEST['status']) : '';

        if(strrpos($code, 'A')===false){
            $this->error('订单号有误');
        }

        $order = Db::name('order')->where('order_code', $code)->field('id,status')->find();

        if(empty($order)){
            $this->error('暂无此订单信息');
        }

        $text = array('loading','cancel','payed');//'accepted','geted','gotoed','completed'

        $status = array_search($status, $text);
        if(empty($status)){
            $this->error('变更状态参数有误');
        }

        $up = Db::name('order')->where('order_code', $code)->update(['status'=>$status]);

        if(empty($up) && $status!=$order['status']){
            $this->error('状态更新失败');
        }

        if($status==2) {
            sendOrderTpl($order['id']);
        }

        $this->success('订单状态更新成功!', array('status'=>!empty($text[$status]) ? $text[$status] : ''));
    }

    /**
     * 配送订单信息
     */
    public function orderdetail(){

        $code = !empty($_REQUEST['order_code']) ? trim($_REQUEST['order_code']) : '';

        if(strrpos($code, 'A')===false){
            $this->error('订单号有误');
        }

        $where = array();
        $where['o.order_code'] = $code;

        //JOIN
        $join = [
            ['order_address a', 'o.id=a.order_id', 'left'],
            ['order_rider or', 'or.order_id=o.id', 'left'],
            ['rider r', 'r.id=or.rider_id', 'left']
        ];

        //查询字段
        $selectFiled = [
            'o.order_code','o.get_time as oget_time','o.goodsname','o.small_price','o.distance','o.weight','o.distance_price','o.night_price'
            ,'o.change_price','o.pay_price','o.total_price','o.description as remark','o.status','o.add_time','o.id as order_id'
            ,'a.*',
            'or.accept_time','or.accept_time','or.get_time','or.goto_time','or.complete_time','or.rider_id','or.pick_img','or.end_img'
            ,'r.nick_name as rider_name','r.mobile as rider_mobile'
        ];


        $result = (new \app\admin\model\Order)->alias('o')
            ->where($where)
            ->join($join)
            ->field($selectFiled)
            ->find();

        if(empty($result))
            $this->error('暂无此订单信息!');

        $result = $result->toArray();

        empty($result['accept_time']) || $result['accept_time'] = date('Y-m-d H:i',$result['accept_time']);
        empty($result['get_time'])    || $result['get_time'] = date('Y-m-d H:i',$result['get_time']);
        empty($result['goto_time']) || $result['goto_time'] = date('Y-m-d H:i',$result['goto_time']);
        empty($result['complete_time']) || $result['complete_time'] = date('Y-m-d H:i',$result['complete_time']);

        if(!empty($result['pick_img'])){
            $result['pick_img'] = str_replace('/uploads/','/addons/make_speed/core/public/uploads/', $result['pick_img']);
            $result['pick_img'] = explode(',', $result['pick_img']);
        }

        if(!empty($result['end_img'])){
            $result['end_img'] = str_replace('/uploads/','/addons/make_speed/core/public/uploads/', $result['end_img']);
            $result['end_img'] = explode(',', $result['end_img']);
        }

        if(isset($result['get_time_text']))
            unset($result['get_time_text']);
        if(isset($result['add_time_text']))
            unset($result['add_time_text']);
        if(isset($result['update_time_text']))
            unset($result['update_time_text']);

        $status = array('loading','cancel','payed','accepted','geted','gotoed','completed');
        $result['status'] = isset($status[$result['status']]) ? $status[$result['status']] : 'unknown';

        //取件收件码
        $pick = Db::name('order_pickcode')->where('order_id',$result['order_id'])->find();

        $result['pick_code'] = !empty($pick['pick_code']) ? $pick['pick_code'] : '';
        $result['end_code'] = !empty($pick['end_code']) ? $pick['end_code'] : '';

        $this->success('ok', $result);

    }

}
