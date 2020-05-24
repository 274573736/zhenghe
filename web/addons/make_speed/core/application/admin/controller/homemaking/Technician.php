<?php

namespace app\admin\controller\homemaking;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Technician extends Backend
{
    
    /**
     * Technician模型对象
     * @var \app\admin\model\homemaking\Technician
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\homemaking\Technician;
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {

            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                ->with(['rider'])
                ->where($where)
                ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['rider'])
                ->where($where)
                ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $k=>&$v){
                $cateids = explode(',',$v['category_id']);
                $cates   = Db::name('homemaking_category')->where(['id'=>['in',$cateids] ])->column('title');
                $title   = implode(',',$cates);
                $v['title'] = $title;
            }

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }

        $this->view->assign('statusList',$this->model->getStatusList());

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
                    Db::startTrans();
                    $updateRider = Db::name('rider')->where([ 'id' => $row->rider_id ])->update([ 'status' => $params['status'] ]);
                    $updateBind  = Db::name('rider_bind')->where([ 'rider_id' => $row->rider_id ])->update([ 'status' => $params['status'] ]);


                    $result = $row->allowField(true)->save($params);
                    if ($result !== false || $updateBind || $updateRider) {
                        if($params['status'] != 0){
                            import('lib.SendWchatTpl', EXTEND_PATH);
                            $sendTpl  = new \SendWchatTpl();
                            $data    = [
                                'id'    => $row->rider_id,
                                'data'  => [
                                    'time5'     =>array('value' => date('Y-m-d H:i:s',$row->create_time) ),
                                    'thing2'    =>array('value' => $params['status'] == 2 ? '审核通过' : '审核失败'),
                                    'thing6'    =>array('value' => $params['status'] == 2 ? '无'       : $params['remark'] ),
                                    'date3'     =>array('value' => date('Y-m-d H:i:s',time()) ),
                                ]
                            ];
                            $sendTpl->sendRiderTemplate($data);
                        }
                        Db::commit();
                        $this->success();
                    } else {
                        Db::rollback();
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


}
