<?php
namespace app\admin\controller\distribution;

use app\common\controller\Backend;
use think\Db;

class Config extends Backend{

    protected $model = null;

    public function _initialize(){
        parent::_initialize();
        $this->model = new \app\admin\model\Setting();
    }

    public function index(){
        $keys   = ['d_tier','d_iap','d_audit','d_commission_type','d_mini_amount','d_commission_charge','d_grade','d_switch','d_img','d_count_commission_type'];
        $result = Db::name('setting')->where( [ 'key'=>['in',$keys],'uniacid'=>$GLOBALS['uniacid'] ])->column('key,value');
        if(!isset( $result['d_commission_type'] )  ){
            $result['d_commission_type'] = '1,2,3';
        }

        $agreement = Db::name('agreement')->where(['position'=>'distribution','uniacid'=>$GLOBALS['uniacid']])->find();
        $result['d_agreement'] = $agreement['content'];
        return $this->view->fetch('',[
            'result'    => $result,
        ]);
    }

    public function base(){
        if( $this->request->isAjax() ){
            $params = $this->request->param('row/a');
            if( isset($params['d_commission_type']) ){
                $params['d_commission_type'] = implode(',',$params['d_commission_type'] );
            }
            if( isset($params['d_agreement']) ){
                $agreement = Db::name('agreement')->where(['position'=>'distribution','uniacid'=>$GLOBALS['uniacid']])->find();
                if($agreement){
                    $re = Db::name('agreement')->where( ['position'=>'distribution'] )->update([ 'content'=>$params['d_agreement'] ]);
                }else{
                    $data = [
                        'type'      => 0,
                        'position'  => 'distribution',
                        'content'   => $params['d_agreement'],
                        'uniacid'   => $GLOBALS['uniacid'],
                        'add_time'  => time(),
                    ];
                    $re = Db::name('agreement')->insert($data);
                }
            }else{
                $re = $this->model->saveValue($params);
            }
            if($re){
                return $this->success('更新成功');
            }
            return $this->error('更新失败');
        }
    }

}