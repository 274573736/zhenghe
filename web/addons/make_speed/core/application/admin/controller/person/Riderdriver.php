<?php

namespace app\admin\controller\person;

use app\common\controller\Backend;
use think\Db;
use lib\Amap;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Riderdriver extends Backend
{
    
    /**
     * Driver模型对象
     * @var \app\admin\model\rider\Driver
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\rider\Driver;

        $this->view->assign('statusList',$this->model->getStatusList());
    }

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        $this->searchFields = 'rider.real_name,card_type';
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
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
                ->where(['rider.uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['rider'=>function($query){
                    if(!empty($GLOBALS['city_id'])){
                        $query->where(['city_id'=>$GLOBALS['city_id']]);
                    }
                }])
                ->where($where)
                ->where(['rider.uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id','card_img1','card_img2','card_num','card_type','card_type','card_time','uniacid','ridername','status','rider.real_name']);
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
                    //生成终端ID
                    if(!$row->tid){
                        if($params['status'] == 2){
                            $tid = $this->createTID($row->rider_id);
                            $params['tid'] = $tid;
                        }
                    }

                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
                        if($params['status'] != 0){
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
        $rows = $row->toArray();

        $rider = Db::name('rider')->where(['id'=>$rows['rider_id']])->field('real_name,mobile')->find();

        $this->view->assign("rider", $rider);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function createTID($id){
        $key =  Db::name('setting')->where(['key'=>'amap_driver_key','uniacid'=>$GLOBALS['uniacid'] ])->value('value');
        if(!$key){
            $this->error('请在价格配置->代驾价格配置输入高德地图key');
        }
        $sid =  Db::name('setting')->where(['key'=>'amap_service_id','uniacid'=>$GLOBALS['uniacid'] ])->value('value');
        if(!$sid){
            $this->error('服务ID异常，请在代驾配置输入高德地图key提交尝试');
        }

        $data = [
            'key'   => $key,
            'sid'   => $sid,
            'name'  => (string)$id,
        ];
        $re = Amap::addTerminal($data);
        if($re['errcode'] != 10000){
            $this->error(isset($re['errdetail']) ? $re['errdetail'] : $re['errmsg']);
        }
        return $re['data']['tid'];
    }

}
