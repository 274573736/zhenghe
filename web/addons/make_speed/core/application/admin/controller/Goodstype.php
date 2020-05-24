<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 物品类型
 *
 * @icon fa fa-circle-o
 */
class Goodstype extends Backend
{
    
    /**
     * Type模型对象
     * @var \app\admin\model\GoodsType
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\GoodsType;

        $this->view->assign('typeList',$this->model->getTypeList());
    }

    /********************************************************************/

    /**
     * 列表
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;

        //搜索字段
        $this->searchFields   = 'name';

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
                ->where(['uniacid'=>$GLOBALS['uniacid']])
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->where(['uniacid'=>$GLOBALS['uniacid']])
                ->order(['weight'=>'desc','id'=>'desc'])
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id','order_type','icon','iconed','name','weight','add_time']);
            }

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }

        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            $params['uniacid'] = $GLOBALS['uniacid'];
            $params['add_time'] = time();
            if ($params) {
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
        return $this->view->fetch();
    }

}
