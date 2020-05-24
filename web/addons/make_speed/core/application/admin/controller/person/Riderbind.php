<?php

namespace app\admin\controller\person;

use app\common\controller\Backend;
use think\Db;
/**
 * 骑手认证
 *
 * @icon fa fa-circle-o
 */
class Riderbind extends Backend
{
    
    /**
     * Bind模型对象
     * @var \app\admin\model\rider\Bind
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\rider\Bind;
        $this->RiderModel = new \app\admin\model\Rider;


        $this->view->assign('statusList',$this->model->getStatusList());
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
        $this->searchFields = 'real_name,card_code';
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['rider'=>function($query){
                        if(!empty($GLOBALS['city_id'])){
                            $query->where(['city_id'=>$GLOBALS['city_id']]);
                        }
                    }])
                    ->where($where)
                    ->where(['rider.uniacid' => $GLOBALS['uniacid']])
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['rider'=>function($query){
                        if(!empty($GLOBALS['city_id'])){
                            $query->where(['city_id'=>$GLOBALS['city_id']]);
                        }
                    }])
                    ->where($where)
                    ->where(['rider.uniacid' => $GLOBALS['uniacid']])
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['id','ridername','real_name','card_code','card1_img','card2_img','card3_img','card4_img','status','add_time']);
            }
            $list = collection($list)->toArray();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
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

                        //更新骑手状态
                        $riderid = $row->toArray();
                        $up = db('rider')->where('id',$riderid['rider_id'])->update(['status'=>$params['status']]);

                        if(!empty($up) && $params['status'] != 0){
                            import('lib.SendWchatTpl', EXTEND_PATH);
                            $sendTpl  = new \SendWchatTpl();
                            $data    = [
                                'id'       => $row->rider_id,
                                'data'  => [
                                    'time5'     =>array('value' => date('Y-m-d H:i:s',$row->add_time) ),
                                    'thing2'    =>array('value' => $params['status'] == 2 ? '审核通过' : '审核失败'),
                                    'thing6'    =>array('value' => $params['status'] == 2 ? '无'       : $params['remark'] ),
                                    'date3'     =>array('value' => date('Y-m-d H:i:s',time()) ),
                                ]
                            ];
                            $sendTpl->sendRiderTemplate($data);
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


        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function del($ids = ""){
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
                $count = $v->delete();
                //删除订单关联数据
                Db::name('rider_info')->where('rider_id',$v['rider_id'])->delete();
                Db::name('rider')->where('id',$v['rider_id'])->delete();
                Db::name('rider_cashlog')->where('rider_id',$v['rider_id'])->delete();

                $tableName  = config('database.prefix').'rider_fdriver';
                $exists     = db()->query('SHOW TABLES LIKE '."'".$tableName."'");
                if($exists){
                    Db::name('rider_fdriver')->where('rider_id',$v['rider_id'])->delete();
                }

                $tableName  = config('database.prefix').'homemaking_technician';
                $exists     = db()->query('SHOW TABLES LIKE '."'".$tableName."'");
                if($exists){
                    Db::name('homemaking_technician')->where('rider_id',$v['rider_id'])->delete();
                }
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



}
