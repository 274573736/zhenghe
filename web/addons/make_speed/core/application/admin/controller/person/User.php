<?php

namespace app\admin\controller\person;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-user
 */
class User extends Backend
{
    
    /**
     * User模型对象
     * @var \app\admin\model\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\User;

        $this->view->assign('sexList', $this->model->getSexList());
        $this->view->assign('gradeList', $this->model->getGradeList());
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

        //搜索字段
        $this->searchFields   = 'nick_name,mobile';

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
                    ->where(['uniacid' => $GLOBALS['uniacid']])
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with('grade,recommend,riders')
                    ->where($where)
                    ->where(['uniacid' => $GLOBALS['uniacid']])
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['id','nick_name','real_name','mobile','sex','avatar','user_grade','valid','grow','gral','recommend_name','recommend_riders','usergrade','gradeicon']);
            }

            $list = collection($list)->toArray();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function del($ids = "")
    {
        $this->error(0.0);
    }

    /**
     * 详情
     */
    public function detail($ids = NULL)
    {
        //当前是否为关联查询
        $id = (int)$ids;

        $result = db('user')->where(array('recommend_id'=>$id))->column('id,nick_name,avatar,add_time');
        $result = array_merge($result);
        $this->view->assign('row', $result);

        return $this->view->fetch();
    }

    public function coupon($ids){
        if(request()->isAjax()) {
            $params = $this->request->post("row/a");

            $coupon = db('coupons')->where('id','in',$params['coupon_id'])->column('*');

            if(empty($coupon))
                $this->error('优惠券不存在');

            $data = array();

            foreach ($coupon as $k=>$v){
                $data[$k]['order_type'] = $v['type'];
                $data[$k]['user_id']    = intval($ids);
                $data[$k]['type']       = 'admin';
                $data[$k]['tips']       = $v['title'];
                $data[$k]['amount']     = $v['money'];
                $data[$k]['coupon_id']  = $v['id'];
                $data[$k]['begin_time'] = time();
                $data[$k]['full_amount']= $v['satisfy_money'];
                $data[$k]['limit_distance'] = $v['distance'];
                $data[$k]['expire_time'] = strtotime('+'.$v['day'].' day');
                $data[$k]['add_time'] = $data[$k]['begin_time'];
                $data[$k]['uniacid'] = $GLOBALS['uniacid'];
            }

            $add = db('user_coupons')->insertAll($data);
            if(!empty($add))
                $this->success('操作成功！优惠券已发放');

            $this->success('操作失败');
        }

        return $this->view->fetch();
    }
}
