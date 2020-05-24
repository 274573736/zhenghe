<?php

namespace app\admin\controller\freight;

use app\admin\controller\freight\Fbase;

use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Driver extends Fbase
{

    protected $model = null;

    public function _initialize()
    {
        $table      = 'rider_fdriver';
        $this->checkPlug($table);
        parent::_initialize();
        $this->model = new \app\admin\model\freight\Driver;
        $this->view->assign("statusList", $this->model->getStatusList());

    }

    public function index()
    {
        $this->relationSearch = true;

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
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['rider'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            foreach($list as $k=>$v){
                $ids  = explode(',',$v['car_id']);
                $cars = Db::name('vehicle')->where('id','in',$ids)->field('title')->select();
                $list[$k]['car'] = implode(',',array_column($cars,'title'));
            }

            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }

        return $this->view->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            if ($params) {

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {

                $result = false;

                Db::startTrans();

                try {
                    if( (int)$params['status'] == 1 ){
                        Db::name('rider')->where(['id'=>$row->rider_id])->update(['status'=>2]);
                        Db::name('rider_bind')->where(['rider_id'=>$row->rider_id])->update(['status'=>2]);
                    }elseif( (int)$params['status'] == 2){
                        Db::name('rider')->where(['id'=>$row->rider_id])->update(['status'=>1]);
                        Db::name('rider_bind')->where(['rider_id'=>$row->rider_id])->update(['status'=>1]);
                    }

                    $result = $row->allowField(true)->save($params);

                    //更新骑手状态
                    $rider = $row->toArray();
                    if($params['status'] != 0){
                        import('lib.SendWchatTpl', EXTEND_PATH);
                        $sendTpl  = new \SendWchatTpl();
                        $data    = [
                            'id'       => $row->rider_id,
                            'data'  => [
                                'time5'     =>array('value' => date('Y-m-d H:i:s',$row->create_time) ),
                                'thing2'    =>array('value' => $params['status'] == 1 ? '审核通过' : '审核失败'),
                                'thing6'    =>array('value' => $params['status'] == 1 ? '无'       : $params['remark'] ),
                                'date3'     =>array('value' => date('Y-m-d H:i:s',time()) ),
                            ]
                        ];
                        $sendTpl->sendRiderTemplate($data);
                    }
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        $this->assign('row',$row);
        return $this->view->fetch();
    }



}
