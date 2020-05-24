<?php

namespace app\admin\controller\setting;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Couponactivity extends Backend
{
    
    /**
     * Activity模型对象
     * @var \app\admin\model\coupon\Activity
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\coupon\Activity;

        $this->view->assign('typeList', $this->model->getTypeList());
        $this->view->assign('isDisabledList', $this->model->getIsDisabledList());
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
        //优惠券列表
        $coupons = db('coupons')->where(array('uniacid'=>$GLOBALS['uniacid']))->column('id,title,money,day');

        //已设置的新人优惠券
        $newperson_coupon = db('setting')->where(array('uniacid'=>$GLOBALS['uniacid'], 'key'=>'newperson_coupon'))->find();

        $newcoupon = !empty($newperson_coupon['value']) ? unserialize($newperson_coupon['value']) : array('coupon_id'=>0, 'coupon_bg'=>'');

        $this->view->assign('newcoupon', $newcoupon);

        $this->view->assign('coupons', $coupons);
        return $this->view->fetch();
    }

    /**
     * 新人优惠券活动设置
     */
    public function newperson(){

        $coupon_id = !empty($_POST['coupons']) ? intval($_POST['coupons']) : 0;
        $newpersonbg = !empty($_POST['newpersonbg']) ? $_POST['newpersonbg'] : '';

        $coupon = db('coupons')->where(array('id'=>$coupon_id))->column('money');

        !empty($coupon_id) && empty($coupon) && $this->error('操作失败！选择优惠券不存在');

        $data['newperson_coupon'] = serialize(array('coupon_id'=>$coupon_id,'coupon_bg'=>$newpersonbg));

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

}
