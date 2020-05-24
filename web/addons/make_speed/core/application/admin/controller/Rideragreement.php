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
class Rideragreement extends Backend
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){

        //已有协议
        $results = db('agreement')->where(array('type'=>1,'uniacid'=>$GLOBALS['uniacid']))->column('position,content');

        foreach ($results as $k=>$v){
            if($k=='rider_service')
                $results[$k] = unserialize($v);
        }


        $this->view->assign('results', $results);

        return $this->view->fetch();
    }

    //客服帮助
    public function service(){
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

        $exist = db('agreement')->where(['type'=>1, 'position'=>"rider_service",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement(serialize($data), 'rider_service',!empty($exist) ? false : true);

    }

    //账户说明
    public function account(){
        $content = !empty($_POST['rider_account']) ? $_POST['rider_account'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>1, 'position'=>"rider_account",'uniacid'=>$GLOBALS['uniacid']])->column('id');

        $this->saveAgreement($content, 'rider_account',!empty($exist) ? false : true);
    }

    //码豆说明
    public function bean(){
        $content = !empty($_POST['rider_bean']) ? $_POST['rider_bean'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>1, 'position'=>"rider_bean",'uniacid'=>$GLOBALS['uniacid']])->column('id');
        $this->saveAgreement($content,  'rider_bean', !empty($exist) ? false : true);
    }

    //合作协议
    public function cooperate(){
        $content = !empty($_POST['rider_cooperate']) ? $_POST['rider_cooperate'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>1, 'position'=>"rider_cooperate",'uniacid'=>$GLOBALS['uniacid']])->column('id');
        $this->saveAgreement($content,  'rider_cooperate', !empty($exist) ? false : true);
    }

    //分享活动说明
    public function activity(){
        $content = !empty($_POST['rider_activity']) ? $_POST['rider_activity'] : '';

        if(empty($content))
            $this->error('内容不能为空！');

        $exist = db('agreement')->where(['type'=>1, 'position'=>"rider_activity",'uniacid'=>$GLOBALS['uniacid']])->column('id');
        $this->saveAgreement($content,  'rider_activity', !empty($exist) ? false : true);
    }

    private function saveAgreement($content='', $position, $type=true){

        $data = array(
            'type'      => 1,
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
            $add = db('agreement')->where(['type'=>1, 'position'=>$position,'uniacid'=>$GLOBALS['uniacid']])->update(['content'=>$content]);
        }

        if($add)
            $this->success('保存成功');

        $this->error('保存失败！请稍后重试');
    }
}