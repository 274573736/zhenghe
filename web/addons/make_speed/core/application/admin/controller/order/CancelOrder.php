<?php


namespace app\admin\controller\order;
use app\common\controller\Backend;

class CancelOrder extends Backend
{


    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\CancelOrder;
    }


    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;

        //搜索字段
        $this->searchFields   = 'id';

        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {

            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                ->with(['order'])
                ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['order','rider'])
                ->where(['uniacid'=>$GLOBALS['uniacid'] ])
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