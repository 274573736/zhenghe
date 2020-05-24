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
class Userinvite extends Backend
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){

        //已有协议
        $results = db('setting')->where(array('key'=>'users_invite','uniacid'=>$GLOBALS['uniacid']))->column('key,value');

        !empty($results['users_invite']) && $results['users_invite'] = unserialize($results['users_invite']);

        $this->view->assign('results', $results);

        return $this->view->fetch();
    }

    //设置分享邀请奖励
    public function saveinvite(){

        $data = array();

        $data['share']  = !empty($_POST['share']) ? toint($_POST['share']) : 0;
        $data['share_full']  = !empty($_POST['share_full']) ? toint($_POST['share_full']) : 0;
        $data['share_limit'] = !empty($_POST['share_limit']) ? intval($_POST['share_limit']) : 0;
        $data['share_day']   = !empty($_POST['share_day']) ? intval($_POST['share_day']) : 0;

        $data['person_num'] = !empty($_POST['person_num']) ? intval($_POST['person_num']) : 0;
        $data['person_full'] = !empty($_POST['person_full']) ? toint($_POST['person_full']) : 0;
        $data['person_price'] = !empty($_POST['person_price']) ? toint($_POST['person_price']) : 0;
        $data['person_limit'] = !empty($_POST['person_limit']) ? intval($_POST['person_limit']) : 0;
        $data['person_day'] = !empty($_POST['person_day']) ? intval($_POST['person_day']) : 0;

        $data['first'] = !empty($_POST['first']) ? toint($_POST['first']) : 0;
        $data['first_full'] = !empty($_POST['first_full']) ? toint($_POST['first_full']) : 0;
        $data['first_limit'] = !empty($_POST['first_limit']) ? intval($_POST['first_limit']) : 0;
        $data['first_day'] = !empty($_POST['first_day']) ? intval($_POST['first_day']) : 0;

        $exits = db('setting')->where(array('key'=>'users_invite','uniacid'=>$GLOBALS['uniacid']))->column('id');
        if(empty($exits)){
            $add = db('setting')->insert(array('key'=>'users_invite','uniacid'=>$GLOBALS['uniacid'], 'value'=>serialize($data)));
        }
        else{
            $add = db('setting')->where(array('key'=>'users_invite','uniacid'=>$GLOBALS['uniacid']))->update(array('value'=>serialize($data)));
        }

        if(!empty($add))
            $this->success('保存成功');

        $this->error('保存失败！请稍后重试');
    }
}