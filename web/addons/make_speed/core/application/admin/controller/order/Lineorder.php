<?php

namespace app\admin\controller\order;

use app\common\controller\Backend;
use think\Db;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Lineorder extends Backend
{

    /**
     * Order模型对象
     * @var \app\admin\model\Order
     */
    protected $model = null;

    /**
     * 订单类型为帮买订单
     */
    const ORDER_TYPE = 2;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Order;
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;

        //搜索字段
        $this->searchFields   = 'order_code';

        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            $wheres = array(
                'order.uniacid' => $GLOBALS['uniacid'],
                'order.type'    => self::ORDER_TYPE,
            );

            if(!empty($GLOBALS['city_id'])){
                $wheres['order.city_id'] = $GLOBALS['city_id'];
            }

            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                ->with('user,riders,city')
                ->where($where)
                ->where($wheres)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with('user,riders,city')
                ->where($where)
                ->where($wheres)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();



            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }

        $this->view->assign('statusList',$this->model->getStatusList());

        return $this->view->fetch();
    }

    public function add(){
        $this->redirect('order/order');
    }


    /**
     * 订单删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)
                ->select();

            $count = 0;
            foreach ($list as $k => $v) {
                $count += $v->delete();
            }

            //删除订单关联数据
            Db::name('order_rider')->where('order_id','in',$ids)->delete();
            Db::name('order_address')->where('order_id','in',$ids)->delete();
            Db::name('order_pickcode')->where('order_id','in',$ids)->delete();

            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }


    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }

        $order = $row->toArray();

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['uniacid'] = $GLOBALS['uniacid'];

            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }

                    $this->errorTip($params['status'], $order);
                    
                    if($params['status']==5){
                        $this->error('确认送达失败，请骑手自行确认');
                    }
                    
                    //取消待付,需退款
                    if($params['status']<2){
                        //额外的加小费总额
                        $smallcount = Db::name('user_cashlog')->where(['type'=>0, 'status'=>1, 'object_id'=>$order['id'], 'uniacid'=>$GLOBALS['uniacid']])->sum('amount');
                        empty($smallcount) && $smallcount = 0;
                        //微信支付
                        if($order['payment']==2){

                            $refund = weixinRefund($order['order_code'],($order['pay_price']-$smallcount),$order['user_id']);
                            if($refund[0]==1) {
                                $this->error($refund[1] . ',退款失败,订单状态修改失败');
                            }
                            addUserCashLog($order['user_id'],$order['order_code'],($order['pay_price']-$smallcount),2,'订单取消退款至微信',1,$order['id']);

                        }else if($order['payment']==1){
                            $spte = Db::name('user')->where('id',$order['user_id'])->setInc('valid',($order['pay_price']-$smallcount));
                            !empty($spte) && addUserCashLog($order['user_id'],$order['order_code'],($order['pay_price']-$smallcount),2,'订单取消退款',1,$order['id']);
                            empty($spte) && $this->error('退款到用户余额失败！');
                        }
                        //退小费
                        $small = Db::name('user_cashlog')->where(array('object_id'=>$order['id'],'type'=>0,'status'=>1,'uniacid'=>$GLOBALS['uniacid']))->column('id,amount,user_id,order_code');

                        if(!empty($small) && !empty($order['id'])){
                            foreach ($small as $v){
                                $re = weixinRefund($v['order_code'], $v['amount'], $order['user_id']);

                                if(!empty($re[0])){
                                    addUserCashLog($v['user_id'],$v['order_code'],$v['amount'],2,'[小费]余额退款', 1, $order['id']);
                                    Db::name('user')->where(array('id'=>$v['user_id']))->setInc('valid',$v['amount']);
                                }else{
                                    addUserCashLog($v['user_id'],$v['order_code'],$v['amount'],2,'[小费]微信退款', 1, $order['id']);
                                }
                            }
                        }
                    }

                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {

                        if($params['status']==2){
                            Db::name('order_rider')->where('order_id',$order['id'])->delete();
                        }
                        //返回优惠券
                        if(!empty($order['coupon_id']) && $params['status']<=2){
                            Db::name('user_coupons')->where('id', $order['coupon_id'])->update(array('status' => 0));
                        }


                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }

            }
            $this->error(__('Parameter %s can not be empty', ''));
        }


        $getStatusList = [
            1   =>  __('取消订单'),
            2   =>  __('待接单'),
            5   =>  __('已送达'),
            6   =>  __('已完成')
        ];

        empty($getStatusList[$order['status']]) && $getStatusList[$order['status']]=__('Status '.$order['status']);

        ksort($getStatusList);

        $this->view->assign('statusList',$getStatusList);

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 订单状态修改提示
     * @param $status int 修改状态值
     * @param $order  array 订单原数据
     */
    private function errorTip($status, $order){

        //订单取消状态,判断如果用户已退款取消,则无法更新状态
        if($order['status']==1 && intval($status)!==1){
            $exits = Db::name('user_cashlog')
                ->where(array('type'=>2,'status'=>1,'user_id'=>$order['user_id'],'order_code'=>$order['order_code']))
                ->find();

            if(!empty($exits))
                $this->error('修改失败，此订单已取消并退款');
        }




        //设置为待接单状态,判断是否有付款记录,
        if($status>1){
            $exits = Db::name('user_cashlog')
                ->where(array('type'=>0,'status'=>1,'user_id'=>$order['user_id'],'order_code'=>$order['order_code']))
                ->find();

            if(empty($exits))
                $this->error('修改失败，此订单用户尚未付款');
        }


        if($status==0 && !empty($exits))
            $this->error('修改失败，此订单用户已付款');

        //取件完成后不能修改
        if($order['status']>=4 && $status<4)
            $this->error('状态修改失败，订单已取件派送中');

        if($status==6 && $order['status']<5)
            $this->error('状态修改失败，订单尚未送达');

        if($status==5 && $order['status']<4)
            $this->error('状态修改失败，订单尚未取件');

    }


    /**
     * 详情
     */
    public function detail($ids = NULL)
    {
        //当前是否为关联查询
        $this->relationSearch = true;

        $where = array();
        $where['o.id'] = (int)$ids;

        //JOIN
        $join = [
            ['user u', 'o.user_id=u.id'],
            ['goods_type t', 'o.goods_id=t.id','left'],
            ['order_address a', 'o.id=a.order_id', 'left'],
            ['coupons c', 'o.coupon_id=c.id', 'left'],
            ['order_rider or', 'or.order_id=o.id', 'left'],
            ['rider r', 'r.id=or.rider_id', 'left']
        ];

        //查询字段
        $selectFiled = [
            'o.*','o.get_time as oget_time', 'u.nick_name as username',
            't.name as goods_name', 'c.title as coupons_name',
            'c.money as coupons_money', 'a.*',
            'or.*',
            'r.nick_name as rider_name','r.mobile as rider_mobile'
        ];

        $result = $this->model->alias('o')
            ->where($where)
            ->join($join)
            ->field($selectFiled)
            ->find();

        if(empty($result))
            return json(['code' => 1, 'msg' => '暂无此订单！']);

        $result = $result->toArray();

        empty($result['accept_time']) || $result['accept_time'] = date('Y-m-d H:i',$result['accept_time']);
        empty($result['get_time'])    || $result['get_time'] = date('Y-m-d H:i',$result['get_time']);
        empty($result['goto_time']) || $result['goto_time'] = date('Y-m-d H:i',$result['goto_time']);
        empty($result['complete_time']) || $result['complete_time'] = date('Y-m-d H:i',$result['complete_time']);
        empty($result['audio']) || $result['audio'] = '/addons/make_speed/core/public/' . $result['audio'];

        if(!empty($result['pick_img'])){
            $result['pick_img'] = str_replace('/uploads/','/addons/make_speed/core/public/uploads/', $result['pick_img']);
            $result['pick_img'] = explode(',', $result['pick_img']);
        }

        if(!empty($result['end_img'])){
            $result['end_img'] = str_replace('/uploads/','/addons/make_speed/core/public/uploads/', $result['end_img']);
            $result['end_img'] = explode(',', $result['end_img']);
        }

        if(!empty($result['img'])){
            $result['img'] = explode(',', $result['img']);
        }

        //取件收件码
        $pick = Db::name('order_pickcode')->where('order_id',$where['o.id'])->find();

        $result['pick_code'] = !empty($pick['pick_code']) ? $pick['pick_code'] : '暂无';
        $result['end_code'] = !empty($pick['end_code']) ? $pick['end_code'] : '暂无';

        $this->view->assign('row', $result);

        return $this->view->fetch();
    }


    /**
     * 分配骑手
     */
    public function tasking($ids = NULL){
        if ($this->request->isPost()) {
            $oid = !empty($_POST['order_id']) ? intval($_POST['order_id']) : 0;
            $rid = !empty($_POST['rider_id']) ? intval($_POST['rider_id']) : 0;
            $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : '';
            $realname = !empty($_POST['real_name']) ? $_POST['real_name'] : '';


            $order = Db::name('order')->where(array('id'=>$oid))->field('order_code,status')->find();
            if(isset($order['status']) && $order['status']<2)
                $this->error('此订单尚未付款或已取消, 无法派送');


            $exits = Db::name('order_rider')->where(array('order_id'=>$oid))->field('rider_id')->find();
            if(!empty($exits['rider_id']))
                $this->error('此订单已存在骑手配送~');

            //订单起点位置
            $address = Db::name('order_address')->where(array('order_id'=>$oid))->field('begin_lat,begin_lng')->find();

            //骑手位置
            $rider = Db::name('rider_info')->where(array('rider_id'=>$rid))->field('lat,lng')->find();

            $distance = get_point_distance($address['begin_lat'].','.$address['begin_lng'],$rider['lat'].','.$rider['lng']);

            $data = array(
                'rider_id'  => $rid,
                'order_id'  => $oid,
                'accept_time' => time(),
            );

            $data['rider_distance'] = isset($distance[0]['distance']) ? sprintf('%.2f', ($distance[0]['distance']/1000)) : 0.0;

            $add = Db::name('order_rider')->insert($data);
            if(empty($add))
                $this->error('分配失败！请稍后重试');

            Db::name('order')->where(array('id'=>$oid))->update(array('status'=>3));

            //发送短信通知
            $sendsms = send_aliyun_sms($mobile, array('name'=>$realname,'code'=>$order['order_code']), 'ali_temp_task');
            if(empty($sendsms['Code']) || strtolower($sendsms['Code'])!=='ok')
                $this->success('分配成功！通知短信未发送成功'.$sendsms['Message']);

            $this->success('分配成功! 已发送短信通知骑手');
        }

        $id = intval($ids);
        //获取订单范围骑手
        $riderPoint = getScopeRider($id);
        $rider_id = '';
        foreach ($riderPoint as $k=>$v){
            if(isset($v['rider_id'])) {
                $rider_id .= $v['rider_id'].',';
                unset($riderPoint[$k]['rider_id']);
            }
        }
        //骑手信息
        $rider_id = rtrim($rider_id, ',');
        $rider = Db::name('rider')->where('id','in',$rider_id)->column('id,real_name,mobile,avatar');


        foreach ($rider as $k => $v){
            $rider[$k]=array_merge($v,$riderPoint[$k]);
            //正在进行中的订单
            $count = Db::name('order_rider')->where(array('rider_id'=>$v['id'],'accept_time'=>['>',0],'goto_time'=>0))->count();
            $rider[$k]['order_count'] = !empty($count) ? intval($count) : '暂无';

            //惩罚记录
            $sanction = Db::name('rider_sanction')->where(array('rider_id'=>$v['id'],'type'=>0,'status'=>0))->field('class,begin_time,end_time')->find();
            $class = array('扣减余额','通知警告','禁止接单','冻结账号');
            $rider[$k]['sanction'] = !empty($sanction) ? $class[$sanction['class']] : '暂无';
            $rider[$k]['order_id'] = $id;
        }

        //骑手点位
        $riderPoint = array_values($riderPoint);

        //订单起点
        $address = Db::name('order_address')->where(array('order_id'=>$id))->find();

        //腾讯地图key
        $tencenkey = Db::name('setting')->where(array('uniacid'=>$GLOBALS['uniacid'],'key'=>'tencent_key'))->column('value');

        if(empty($tencenkey[0]))
            $this->error('未配置腾讯地图key!');

        $ridericon = '/uploads/program_icon/client/rider.png';


        $this->view->assign('address',$address);
        $this->view->assign('riderPoint',$riderPoint);
        $this->view->assign('tencenkey',$tencenkey[0]);
        $this->view->assign('ridericon',$ridericon);
        $this->view->assign('rider',$rider);

        return $this->view->fetch();
    }

}
