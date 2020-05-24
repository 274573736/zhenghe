<?php

namespace app\admin\controller\freight;

use app\admin\controller\freight\Fbase;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Order extends Fbase
{
    
    /**
     * Order模型对象
     * @var \app\admin\model\freight\Order
     */
    protected $model = null;

    public function _initialize()
    {
        $table      = 'virtual_driver';
        $this->checkPlug($table);
        parent::_initialize();
        $this->model = new \app\admin\model\freight\Order;
        $this->view->assign("statusList", $this->model->getStatusList());

    }

    public function index()
    {
        $this->relationSearch = true;
        $this->searchFields   = 'order_code';

        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit,$rider_id) = $this->buildparams();
            $map = [
                'order.type'     => 5,
                'order.uniacid'  => $GLOBALS['uniacid'],
            ];
            $total = $this->model
                ->with(['user'])
                ->where($where)
                ->where($map)
                ->order($sort, $order)
                ->count();
            if($rider_id){
                $list = $this->model
                    ->with(['user','address','vehicle','orderRider'=>function($query)use($rider_id){
                            $query->where(['orderRider.rider_id' => $rider_id]);
                    }])
//                    ->where($where)
//                    ->where($map)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            }else{
                $list = $this->model
                    ->with(['user','address','vehicle','orderRiderLeft'])
                    ->where($where)
                    ->where($map)
//                    ->join('order_rider ro','ro.order_id = order.id','LEFT')
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
                foreach($list as $k=>$v){
                    $list[$k]['order_rider'] = $v['order_rider_left'];
                    unset($list[$k]['order_rider_left']);
                }
            }

            $list = collection($list)->toArray();

            foreach ($list as $k=>$v){
                if(!empty($v['order_rider']['id'])){
                    $name = DB::name('rider')
                        ->where(['id'=>$v['order_rider']['rider_id']])
                        ->value('real_name');
                    $list[$k]['order_rider']['rider_name'] = $name ? $name : '无';
                }else{
                    $list[$k]['order_rider']['rider_name'] = '无';
                }
            }

            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }

        return $this->view->fetch();
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


                    if($params['status'] == 1 && $order['status'] == 0){
                        $result = $row->allowField(true)->save($params);
                        if ($result !== false) {
                            return $this->success('取消成功');
                        }
                        return $this->error($row->getError());
                    }



                    //取消待付,需退款
                    if($params['status']<2){
                        //额外的加小费总额
                        $smallcount = Db::name('user_cashlog')->where(['type'=>0, 'status'=>1, 'object_id'=>$order['id'], 'uniacid'=>$GLOBALS['uniacid']])->sum('amount');
                        empty($smallcount) && $smallcount = 0;
                        //微信支付
                        if($order['payment']==2){
                            $refund = weixinRefund($order['order_code'],($order['pay_price']-$smallcount),$order['user_id'],'make_speed_plugin_freight');
                            if($refund[0]==1) {
                                $this->error($refund[1]);
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
                                $re = weixinRefund($v['order_code'], $v['amount'], $order['user_id'],'make_speed_plugin_freight');

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


    public function cancelOrder($status,$order){
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
            ['order_address a', 'o.id=a.order_id', 'left'],
            ['user_coupons c', 'o.coupon_id=c.id', 'left'],
            ['order_rider or', 'or.order_id=o.id', 'left'],
            ['rider r', 'r.id=or.rider_id', 'left']
        ];

        //查询字段
        $selectFiled = [
            'o.*','o.get_time as oget_time', 'u.nick_name as username',
            'c.tips as coupons_name',
            'c.amount as coupons_money', 'a.*',
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

        empty($result['accept_time'])   || $result['accept_time']   = date('Y-m-d H:i',$result['accept_time']);
        empty($result['get_time'])      || $result['get_time']      = date('Y-m-d H:i',$result['get_time']);
        empty($result['goto_time'])     || $result['goto_time']     = date('Y-m-d H:i',$result['goto_time']);
        empty($result['complete_time']) || $result['complete_time'] = date('Y-m-d H:i',$result['complete_time']);

        if(!empty($result['pick_img'])){
            $result['pick_img'] = str_replace('/uploads/','/addons/make_speed/core/public/uploads/', $result['pick_img']);
            $result['pick_img'] = explode(',', $result['pick_img']);
        }

        if(!empty($result['end_img'])){
            $result['end_img'] = str_replace('/uploads/','/addons/make_speed/core/public/uploads/', $result['end_img']);
            $result['end_img'] = explode(',', $result['end_img']);
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
    public function assignDriver($ids = NULL){

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
                $this->error('此订单正在配送~');

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

            $this->success('分配成功! 已发送短信通知');
        }



        $id = intval($ids);
        //获取订单范围骑手
        $riderPoint = $this->getScopeDriver($id);
        $rider_id = '';
        foreach ($riderPoint as $k=>$v){
            if(isset($v['rider_id'])) {
                $rider_id .= $v['rider_id'].',';
                unset($riderPoint[$k]['rider_id']);
            }
        }


        //骑手信息
        $rider_id = rtrim($rider_id, ',');
        $rider = Db::name('rider')
            ->alias('r')
            ->where('r.id','in',$rider_id)
            ->join('rider_fdriver f','r.id = f.rider_id')
            ->column('r.id,r.real_name,r.mobile,r.avatar,f.car_id');
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
            if($v['car_id']){
                $vehicle = Db::name('vehicle')->where(['id'=>['in',$v['car_id'] ] ])->column('title');
                $rider[$k]['car_id'] = implode(',',$vehicle);
            }
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


    public function getScopeDriver($order_id, $type=0){

        $address = Db::name('order_address')->where(array('order_id'=>$order_id))->find();

        if(empty($address))
            return array();

        $distance = Db::name('setting')->where(array('key'=>'driver_scope','uniacid'=>$GLOBALS['uniacid']))->find();

        $distance['value'] = !empty($distance['value']) ? intval($distance['value']) : 20;

        $scope = getPointDistance($address['begin_lng'], $address['begin_lat'], $distance['value']);

        //听单状态
        $where['i.is_accept'] = 1;
        $where['i.uniacid']   = $GLOBALS['uniacid'];
        //接单类型
        //$type && $where['accept_type !='] = $type;

        $rider = Db::name('rider_info')
            ->alias('i')
            ->join('rider_fdriver d','i.rider_id = d.rider_id')
            ->where($where)
            ->where('i.lat',['>=',$scope['minlat']],['<=',$scope['maxlat']],'and')
            ->where('i.lng',['>=',$scope['minlng']],['<=',$scope['maxlng']],'and')
            ->column('i.rider_id,i.lat,i.lng');

        if(empty($rider))
            return array();

        return $rider;
    }

    public function buildparams($searchfields = null, $relationSearch = null)
    {
        $searchfields = is_null($searchfields) ? $this->searchFields : $searchfields;
        $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;
        $search = $this->request->get("search", '');
        $filter = $this->request->get("filter", '');
        $op = $this->request->get("op", '', 'trim');
        $sort = $this->request->get("sort", "id");
        $order = $this->request->get("order", "DESC");
        $offset = $this->request->get("offset", 0);
        $limit = $this->request->get("limit", 0);
        $filter = (array)json_decode($filter, TRUE);
        $op = (array)json_decode($op, TRUE);
        $filter = $filter ? $filter : [];
        $where = [];
        $tableName = '';
        $rider_id = [];
        if(array_key_exists('order_rider',$filter)){
            $rider_id = $filter['order_rider'];
            unset($filter['order_rider']);
        }
        if ($relationSearch) {
            if (!empty($this->model)) {
                $name = \think\Loader::parseName(basename(str_replace('\\', '/', get_class($this->model))));
                $tableName = $name . '.';
            }
            $sortArr = explode(',', $sort);
            foreach ($sortArr as $index => & $item) {
                $item = stripos($item, ".") === false ? $tableName . trim($item) : $item;
            }
            unset($item);
            $sort = implode(',', $sortArr);
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            $where[] = [$tableName . $this->dataLimitField, 'in', $adminIds];
        }

        if ($search) {
            $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);
            foreach ($searcharr as $k => &$v) {
                $v = stripos($v, ".") === false ? $tableName . $v : $v;
            }
            unset($v);
            $where[] = [implode("|", $searcharr), "LIKE", "%{$search}%"];
        }

        foreach ($filter as $k => $v) {
            $sym = isset($op[$k]) ? $op[$k] : '=';

            if (stripos($k, ".") === false) {
                $k = $tableName . $k;
            }

            $v = !is_array($v) ? trim($v) : $v;
            $sym = strtoupper(isset($op[$k]) ? $op[$k] : $sym);

            switch ($sym) {
                case '=':
                case '!=':
                    $where[] = [$k, $sym, (string)$v];
                    break;
                case 'LIKE':
                case 'NOT LIKE':
                case 'LIKE %...%':
                case 'NOT LIKE %...%':
                    $where[] = [$k, trim(str_replace('%...%', '', $sym)), "%{$v}%"];
                    break;
                case '>':
                case '>=':
                case '<':
                case '<=':
                    $where[] = [$k, $sym, intval($v)];
                    break;
                case 'FINDIN':
                case 'FINDINSET':
                case 'FIND_IN_SET':
                    $where[] = "FIND_IN_SET('{$v}', " . ($relationSearch ? $k : '`' . str_replace('.', '`.`', $k) . '`') . ")";
                    break;
                case 'IN':
                case 'IN(...)':
                case 'NOT IN':
                case 'NOT IN(...)':
                    $where[] = [$k, str_replace('(...)', '', $sym), is_array($v) ? $v : explode(',', $v)];
                    break;
                case 'BETWEEN':
                case 'NOT BETWEEN':
                    $arr = array_slice(explode(',', $v), 0, 2);
                    if (stripos($v, ',') === false || !array_filter($arr))
                        continue;
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '') {
                        $sym = $sym == 'BETWEEN' ? '<=' : '>';
                        $arr = $arr[1];
                    } else if ($arr[1] === '') {
                        $sym = $sym == 'BETWEEN' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, $sym, $arr];
                    break;
                case 'RANGE':
                case 'NOT RANGE':
                    $v = str_replace(' - ', ',', $v);
                    $arr = array_slice(explode(',', $v), 0, 2);
                    if (stripos($v, ',') === false || !array_filter($arr))
                        continue;
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '') {
                        $sym = $sym == 'RANGE' ? '<=' : '>';
                        $arr = $arr[1];
                    } else if ($arr[1] === '') {
                        $sym = $sym == 'RANGE' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, str_replace('RANGE', 'BETWEEN', $sym) . ' time', $arr];
                    break;
                case 'LIKE':
                case 'LIKE %...%':
                    $where[] = [$k, 'LIKE', "%{$v}%"];
                    break;
                case 'NULL':
                case 'IS NULL':
                case 'NOT NULL':
                case 'IS NOT NULL':
                    $where[] = [$k, strtolower(str_replace('IS ', '', $sym))];
                    break;
                default:
                    break;
            }
        }
        $where = function ($query) use ($where) {
            foreach ($where as $k => $v) {
                if (is_array($v)) {
                    call_user_func_array([$query, 'where'], $v);
                } else {
                    $query->where($v);
                }
            }
        };

        return [$where, $sort, $order, $offset, $limit,$rider_id];
    }


}