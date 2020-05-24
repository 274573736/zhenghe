<?php

namespace app\admin\controller\freight;

use app\admin\controller\freight\Fbase;
use think\Db;

/**
 * 轮播图管理
 *
 * @icon fa fa-circle-o
 */
class Fconfig extends Fbase
{

    /**
     * Banner模型对象
     * @var \app\admin\model\Banner
     */
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
                'key'     => ['in',['switch_cash','icon_path','driver_scope','load_bearing','freight_weight','freight_cube']],
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

            $field  = ['icon_path','driver_scope','switch_cash','load_bearing','freight_weight','freight_cube'];
            $re     = $this->model->editConfig($params,$field);


            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }

        }
    }

}
