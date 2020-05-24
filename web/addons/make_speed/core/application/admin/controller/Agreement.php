<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-02-14
 * Time: 20:07
 */

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 规则协议
 *
 * @icon fa fa-circle-o
 */
class Agreement extends Backend
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Agreement;

    }

    public function index(){

        //已有协议
        $results = db('agreement')->where(array('type'=>0,'uniacid'=>$GLOBALS['uniacid']))->column('position,content');

        foreach ($results as $k=>$v){
            if($k=='user_helper')
                $results[$k] = !empty($v) ? unserialize($v) : array();

        }

        $this->view->assign('results', $results);
        return $this->view->fetch();
    }

    //用户协议
    public function user(){
        $content = !empty($_POST['user_content']) ? $_POST['user_content'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_agreement",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'user_agreement', !empty($exist) ? false : true);

    }

    //价格说明
    public function redbao(){
        $content = !empty($_POST['redbao_content']) ? $_POST['redbao_content'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_redbao",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'user_redbao', !empty($exist) ? false : true);

    }


    //价格说明
    public function price(){
        $content = !empty($_POST['price_content']) ? $_POST['price_content'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_price",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'user_price', !empty($exist) ? false : true);
    }

    //取消订单
    public function cancel(){
        $content = !empty($_POST['cancel_content']) ? $_POST['cancel_content'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_cancel",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'user_cancel', !empty($exist) ? false : true);
    }

    //帮助
    public function helper(){
        $phone  = !empty($_POST['phone']) ? $_POST['phone'] : '';
        $time   = !empty($_POST['time']) ? $_POST['time'] : '';

        $question_title = !empty($_POST['question_title']) ? $_POST['question_title'] : array();
        $question = !empty($_POST['question']) ? $_POST['question'] : array();

        $data = array(
            'phone' => $phone,
            'time'  => $time,
        );

        foreach ($question_title as $k=>$v){
            if(empty($v) || empty($question[$k]))
                continue;

            $data['question'][$k]['title'] = $v;
            $data['question'][$k]['content'] = $question[$k];
        }


        if(empty($data) || !is_array($data))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_helper",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement(serialize($data), 'user_helper', !empty($exist) ? false : true);
    }

    //充值协议
    public function recharge(){
        $content = !empty($_POST['user_recharge']) ? $_POST['user_recharge'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_recharge",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'user_recharge', !empty($exist) ? false : true);
    }

    //用户端邀请奖励发放说明
    public function invitetxt(){
        $content = !empty($_POST['user_invite_txt']) ? $_POST['user_invite_txt'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>0, 'position'=>"user_invite_txt",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'user_invite_txt', !empty($exist) ? false : true);
    }

    private function saveAgreement($content='', $position, $type=true){

        $data = array(
            'type'      => 0,
            'position'  => $position,
            'content'   => $content,
            'uniacid'   => $GLOBALS['uniacid']
        );
        $add = 0;
        if($type){
            $data['add_time'] = time();
            $add = db('agreement')->insert($data);
        }
        else{
            $add = db('agreement')->where(['type'=>0, 'position'=>$position,'uniacid'=>$GLOBALS['uniacid']])->update(['content'=>$content]);
        }

        if($add)
            $this->success('保存成功');

        $this->error('保存失败！请稍后重试');
    }
}