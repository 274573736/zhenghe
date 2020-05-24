<?php

namespace app\admin\controller\carhailing;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class VehicleList extends Backend
{
    
    /**
     * VehicleList模型对象
     * @var \app\admin\model\carhailing\VehicleList
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\carhailing\VehicleList;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("operateStatusList", $this->model->getOperateStatusList());
    }
    

    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
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
                    ->with(['type','brand'])
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
}
