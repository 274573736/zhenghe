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
class Riderinvite extends Backend
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){

        //已有协议
        $results = db('setting')->where('key','IN','rider_invite,user_invite')->where('uniacid',$GLOBALS['uniacid'])->column('key,value');
        if(!empty($results)) {
            foreach ($results as $k => $v) {
                $results[$k] = @unserialize($v);
            }
        }


        $this->view->assign('results', $results);

        return $this->view->fetch();
    }

    //推荐骑手奖励
    public function inviterider(){

        $data = array();

        $data['reg']  = !empty($_POST['reg']) ? sprintf('%.1f', $_POST['reg']) : 0;
        $data['reg_limit'] = !empty($_POST['reg_limit']) ? intval($_POST['reg_limit']) : 0;

        $data['train'] = !empty($_POST['train']) ? sprintf('%.1f',$_POST['train']) : 0;
        $data['train_limit'] = !empty($_POST['train_limit']) ? intval($_POST['train_limit']) : 0;

        $data['buy_total'] = !empty($_POST['buy_total']) ? $_POST['buy_total'] : array();
        $data['buy_reward'] = !empty($_POST['buy_reward']) ? $_POST['buy_reward'] : array();


        foreach ($data['buy_total'] as $k=>$v){
            if(empty($v) || empty($data['buy_reward'][$k])){
                unset($data['buy_total'][$k]);
                unset($data['buy_reward'][$k]);
            }else{
                $data['buy_total'][$k] = intval($v);
                $data['buy_reward'][$k] = sprintf('%.1f',$data['buy_reward'][$k]);
            }

        }

        $set = (new \app\admin\model\Setting)->saveValue(array('rider_invite'=>serialize($data)));
        
        if(!empty($set))
            $this->success('保存成功');

        $this->error('保存失败！请稍后重试');
    }


    //推荐用户奖励
    public function userinvite(){

        $data = array();

        $data['reg']  = !empty($_POST['user']) ? toint($_POST['user']) : 0;
        $data['reg_limit'] = !empty($_POST['user_limit']) ? intval($_POST['user_limit']) : 0;

        $data['userone'] = !empty($_POST['userone']) ? toint($_POST['userone']) : 0;
        $data['userone_limit'] = !empty($_POST['userone_limit']) ? intval($_POST['userone_limit']) : 0;

        $data['buy_total'] = !empty($_POST['buy_total']) ? $_POST['buy_total'] : array();
        $data['buy_reward'] = !empty($_POST['buy_reward']) ? $_POST['buy_reward'] : array();


        foreach ($data['buy_total'] as $k=>$v){
            if(empty($v) || empty($data['buy_reward'][$k])){
                unset($data['buy_total'][$k]);
                unset($data['buy_reward'][$k]);
            }else{
                $data['buy_total'][$k] = intval($v);
                $data['buy_reward'][$k] = sprintf('%.1f',$data['buy_reward'][$k]);
            }

        }

        $set = (new \app\admin\model\Setting)->saveValue(array('user_invite'=>serialize($data)));

        if(!empty($set))
            $this->success('保存成功');

        $this->error('保存失败！请稍后重试');
    }
}