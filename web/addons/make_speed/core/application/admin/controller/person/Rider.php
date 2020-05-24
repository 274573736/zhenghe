<?php

namespace app\admin\controller\person;

use app\common\controller\Backend;
use think\Db;
use think\Model;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Rider extends Backend
{
    
    /**
     * Rider模型对象
     * @var \app\admin\model\Rider
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Rider;

        $this->view->assign([
            'gradeList'  => $this->model->gradeList(),
            'statusList' => $this->model->statusList(),
        ]);

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
        $this->relationSearch = false;

        $this->searchFields = 'nick_name,real_name,mobile';
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            $wheres = array('uniacid'=>$GLOBALS['uniacid']);
            if(!empty($GLOBALS['city_id'])){
                $wheres['city_id'] = $GLOBALS['city_id'];
            }

            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }


            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                    ->with(['info','recommend','srecommend'])
                    ->where($where)
                    ->where($wheres)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['info','recommend','srecommend'])
                    ->where($where)
                    ->where($wheres)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();



            $list = collection($list)->toArray();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        /**
         *      0奖励       |      1惩罚
         * 奖励增加骑手余额(奖励金额)     禁止接单(限制时间)|冻结账户余额(限制时间)|扣除余额(扣除金额)|通知警告
         * 原因说明内容
         */
        return $this->view->fetch();
    }

    /**
     * 详情
     */
    public function detail($ids=null){
        $where = array();
        $where['r.id'] = intval($ids);
        //JOIN
        $join = [
            ['rider_info i', 'i.rider_id=r.id', 'left'],
            ['rider_bind b', 'b.rider_id=r.id', 'left']
        ];
        //查询字段
        $selectFiled = [
            'r.*',
            'i.*,i.address as jaddress',
            'b.card_code,b.card1_img'
        ];
        $result = $this->model->alias('r')
            ->where($where)
            ->join($join)
            ->field($selectFiled)
            ->find();

        if(empty($result))
            return json(['code' => 1, 'msg' => '暂无此用户！']);

        //下级好友列表
        $recommend = db('rider')->where(array('recommend_id'=>$where['r.id']))->column('id,nick_name,avatar,add_time','id');

        $total = 0;
        $wait = 0;
        if(!empty($recommend)){
            foreach ($recommend as $k=>$v){
                $recommend[$k]['total'] = Db::name('rider_brokerage')->where(['account'=>1,'recommend_id'=>$where['r.id'],'user_id'=>$k,'status'=>3])->sum('amount');
                $recommend[$k]['wait'] = Db::name('rider_brokerage')->where(['account'=>1,'recommend_id'=>$where['r.id'],'user_id'=>$k,'status'=>['<',3]])->sum('amount');
                $total += $recommend[$k]['total'];
                $wait += $recommend[$k]['wait'];
            }
        }

        //下级用户
        //下级好友列表
        $userrecommend = db('user')->where(array('recommend_rider'=>$where['r.id']))->column('id,nick_name,avatar,add_time','id');

        $utotal = 0;
        $uwait = 0;
        if(!empty($userrecommend)){
            foreach ($userrecommend as $k=>$v){
                $userrecommend[$k]['total'] = Db::name('rider_brokerage')->where(['account'=>0,'recommend_id'=>$where['r.id'],'user_id'=>$k,'status'=>3])->sum('amount');
                $userrecommend[$k]['wait'] = Db::name('rider_brokerage')->where(['account'=>0,'recommend_id'=>$where['r.id'],'user_id'=>$k,'status'=>['<',3]])->sum('amount');
                $utotal += $userrecommend[$k]['total'];
                $uwait += $userrecommend[$k]['wait'];
            }
        }



        $this->view->assign('utotal', $utotal);
        $this->view->assign('uwait', $uwait);
        $this->view->assign('userrecommend', $userrecommend);

        $this->view->assign('riderid', intval($ids));
        $this->view->assign('total', $total);
        $this->view->assign('wait', $wait);
        $this->view->assign('recommend', $recommend);
        $this->view->assign('row', $result->toArray());
        return $this->view->fetch();

    }



    /**
     * 结算  骑手端加等级显示，无作用
     */
    public function settle(){
        $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $type = !empty($_REQUEST['type']) ? 0 : 1;

        $rider = Db::name('rider')->where('id',$id)->field('id')->find();
        if(empty($rider))
            $this->error('找不到结算骑手！');

        $up = Db::name('rider_brokerage')->where(array('account'=>$type,'recommend_id'=>$id,'status'=>['<',3]))->update(['status'=>3]);

        if(empty($up))
            $this->error('结算更新失败！请稍后重试');

        $this->success('操作成功！已结算',null,array($id));
    }


    /**
     * 添加
     */
    public function add(){
        return 'Empty error';
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            Db::startTrans();

            $list = $this->model->where($pk, 'in', $ids)
                ->select();

            $count = 0;
            foreach ($list as $k => $v) {
                $count += $v->delete();
            }

            //删除订单关联数据
            Db::name('rider_info')->where('rider_id','in',$ids)->delete();
            Db::name('rider_bind')->where('rider_id','in',$ids)->delete();
            Db::name('rider_cashlog')->where('rider_id','in',$ids)->delete();

            $tableName  = config('database.prefix').'rider_fdriver';
            $exists     = db()->query('SHOW TABLES LIKE '."'".$tableName."'");
            if($exists){
                Db::name('rider_fdriver')->where('rider_id','in',$ids)->delete();
            }

            $tableName  = config('database.prefix').'homemaking_technician';
            $exists     = db()->query('SHOW TABLES LIKE '."'".$tableName."'");
            if($exists){
                Db::name('homemaking_technician')->where('rider_id','in',$ids)->delete();
            }

            if ($count) {
                Db::commit();
                $this->success();
            } else {
                Db::rollback();
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
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {

                        $order_num = isset($_REQUEST['cancel_count']) ? intval($_REQUEST['cancel_count']) : -1;

                        if($order_num > -1){
                            Db::name('rider_info')->where('rider_id', $ids)->update(['cancel_count'=>$order_num]);
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

        $info = Db::name('rider_info')->where('rider_id', $ids)->field('cancel_count,rider_id')->find();

        $this->view->assign("row", $row);
        $this->view->assign("info", $info);
        return $this->view->fetch();
    }

    public function riderorder(){

        $omodel = new \app\admin\model\Order;

        //当前是否为关联查询
        $this->relationSearch = true;

        //搜索字段
        $this->searchFields   = 'order_code';

        $rider_id = $this->request->param('rider_id');

        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {

            $order_id = Db::name('order_rider')->where(['rider_id'=>$rider_id])->column('order_id');
            $order_id = implode(',',$order_id);

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $search = $this->request->param('search');

            $where1 = array();
            if(!empty($search)){
                $where1['order_code'] = ['like','%'.$search.'%'];
            }

            //JOIN
            $join = [
                ['user u', 'o.user_id=u.id'],
                ['order_address a', 'o.id=a.order_id', 'left'],
                ['city c', 'c.id=o.city_id', 'left'],
            ];

            //查询字段
            $selectFiled = [
                'o.*','o.get_time as oget_time', 'u.nick_name as username',
                'c.name as cityname', 'a.*',
            ];

            $total = Db::name('order')->alias('o')
                ->join($join)
                ->where('o.id','in',$order_id)
                ->where($where1)
                ->order('o.id', $order)
                ->count();

            $list = Db::name('order')->alias('o')
                ->join($join)
                ->where('o.id','in',$order_id)
                ->where($where1)
                ->order('o.id', $order)
                ->field($selectFiled)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();

            foreach ($list as $k=>$v){
                $list[$k]['cityname'] = !empty($v['cityname']) ? $v['cityname'] : '无';
                $list[$k]['begin_address'] = !empty($v['begin_address']) ? $v['begin_address'] : '无';
                $list[$k]['goodsname'] = !empty($v['goodsname']) ? $v['goodsname'] : '无';
                $list[$k]['distance'] = !empty($v['distance']) ? $v['distance'] : '无';
            }

            $result = array("total" => $total, "rows" => $list);



            return json($result);
        }

        $this->view->assign('ostatusList',$this->model->getStatusoList());

        $this->view->assign('rider_id',$rider_id);

        return $this->view->fetch();

    }


    public function order_detail($ids){
        $field = ['o.id','o.type','o.status','r.accept_time','r.get_time','r.goto_time','a.begin_address','a.end_address'];
        $list  = Db::name('order_rider')
                ->alias('r')
                ->join('order o','r.order_id = o.id')
                ->join('order_address a','a.order_id = o.id')
                ->where(['r.rider_id'=>$ids,'o.status'=>['in','3,4,5,6'] ])
                ->order('o.id','desc')
                ->field($field)
                ->paginate(10);

        $where    = ['rider_id' => $ids ];

        $today_orderNum = Db::name('order_rider')->where($where)->whereTime('accept_time', 'today')->count();
        $total_orderNum = Db::name('order_rider')->where($where)->count();
        $week_orderNum  = Db::name('order_rider')->where($where)->whereTime('accept_time', 'week')->count();
        $month_orderNum = Db::name('order_rider')->where($where)->whereTime('accept_time', 'month')->count();
        $last_month     = Db::name('order_rider')->where($where)->whereTime('accept_time', 'last month')->count();


        $today_amount = Db::name('order_rider')->where($where)->whereTime('accept_time', 'today')->sum('rider_money');
        $total_amount = Db::name('order_rider')->where($where)->sum('rider_money');
        $week_amount  = Db::name('order_rider')->where($where)->whereTime('accept_time', 'week')->sum('rider_money');
        $month_amount = Db::name('order_rider')->where($where)->whereTime('accept_time', 'month')->sum('rider_money');
        $lastMonthAmount     = Db::name('order_rider')->where($where)->whereTime('accept_time', 'last month')->sum('rider_money');

        return $this->view->fetch('',[
                'list'      => $list,
                'today_orderNum' => $today_orderNum,
                'total_orderNum' => $total_orderNum,
                'week_orderNum'  => $week_orderNum,
                'month_orderNum' => $month_orderNum,
                'last_month'     => $last_month,


                'today_amount' => $today_amount,
                'total_amount' => $total_amount,
                'week_amount'  => $week_amount,
                'month_amount' => $month_amount,
                'lastMonthAmount'  => $lastMonthAmount,
        ]);
    }
}
