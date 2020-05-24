<?php

namespace app\admin\controller\distribution;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    
    /**
     * Order模型对象
     * @var \app\admin\model\distribution\Order
     */
    protected $model = null;

    public function _initialize(){
        parent::_initialize();
        $this->model = new \app\admin\model\distribution\Order();
        $this->assign([ 'statusList' => $this->model->getStatusList() ]);
    }

    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;
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
                    ->with(['pay_user','distribution'])
                    ->where($where)
                    ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['pay_user','distribution'])
                    ->where($where)
                    ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();


            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

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
                    if($params['status'] == 2){
                        $order_id = $row->order_id;
                        $this->complete($order_id);
                    }

                        $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
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

    public function complete($order_id){
        $order = pdo_getall('make_speed_distribution_order',[ 'order_id'=>$order_id ]);
        if(!$order){ return false; }

        //佣金结算  更新订单数据不会超过三条
        foreach ( $order as $k=>$v ){
            Db::startTrans();
            $update_dis = pdo_update('make_speed_distribution_distributor',[
                'commission +='       => $v['commission'],
                'count_commission +=' => $v['commission'],
            ],[ 'user_id' => $v['user_id'] ]);

            $update_order =pdo_update('make_speed_distribution_order',['status' => 2],[ 'user_id'=>$v['user_id'],'order_id'=>$v['order_id'],'status <>'=>[0,2,3]  ]);
            if( $update_dis && $update_order ){
                Db::commit();
            }else{
                Db::rollback();
            }
        }
    }
}
