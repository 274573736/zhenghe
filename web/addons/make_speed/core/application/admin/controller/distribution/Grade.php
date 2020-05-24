<?php

namespace app\admin\controller\distribution;

use app\common\controller\Backend;
use think\Db;

class Grade extends Backend
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\distribution\Grade;
        $this->view->assign("autoLevelList", $this->model->getAutoLevelList());
    }

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
                    
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['uniacid'] = $GLOBALS['uniacid'];

            if ($params) {
                $exist = Db::name('distribution_grade')->where('rank',$params['rank'])->field('id')->find();
                if($exist){
                    return $this->error('等级列表里已有该等级，请重新选择等级！');
                }
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        //0=分销订单总额,1=分销订单总数,2=下线分销商人数
        $levelUpCondition = Db::name('setting')->where(['key'=>'d_grade','uniacid'=>$GLOBALS['uniacid'] ])->value('value');
        $levelUpCondition = $levelUpCondition ? $levelUpCondition : 0;
        $level            = range(0,50);

        return $this->view->fetch('',[
            'level' =>$level,
            'level_condition' => $levelUpCondition,
        ]);
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
                $exist = Db::name('distribution_grade')->where(['rank'=>$params['rank'],'id' => ['neq',$row->id]])->field('id')->find();
                if($exist){
                    return $this->error('等级列表里已有该等级，请重新选择等级！');
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
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

        //0=分销订单总额,1=分销订单总数,2=下线分销商人数
        $levelUpCondition = Db::name('setting')->where(['key'=>'d_grade','uniacid'=>$GLOBALS['uniacid'] ])->value('value');
        $levelUpCondition = $levelUpCondition ? $levelUpCondition : 0;
        $level            = range(0,50);

        return $this->view->fetch('',[
            'row'   => $row,
            'level' => $level,
            'level_condition' => $levelUpCondition,
        ]);

    }
}
