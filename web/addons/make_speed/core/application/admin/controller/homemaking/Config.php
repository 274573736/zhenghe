<?php


namespace app\admin\controller\homemaking;

use app\common\controller\Backend;
use think\Db;

class Config extends Backend {
    protected $model = null;


    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\freight\Fconfig();

    }


    /**
     * 查看
     */
    public function index()
    {

        $res    = Db::name('setting')
            ->where([
                'uniacid' => $GLOBALS['uniacid'],
                'key'     => ['in',['technician_icon','happly_cates','hupload_img_switch']],
            ])
            ->select();

        $config  = null;
        if($res){
            $config = array_column($res,'value','key');
        }


        return $this->view->fetch('',[
            'setting'   => $config,
        ]);
    }

    /**
     * 基础设置
     */
    public function base(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');

            $field  = ['technician_icon','happly_cates','hupload_img_switch'];
            $re     = $this->model->editConfig($params,$field);


            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }

        }
    }

}