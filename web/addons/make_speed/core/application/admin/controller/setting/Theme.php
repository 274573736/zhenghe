<?php

namespace app\admin\controller\setting;

use app\common\controller\Backend;

use think\Db;

/**
 * 价格配置
 *
 * @icon fa fa-cogs
 * @remark 可以在此增改系统的变量和分组,也可以自定义分组和变量,如果需要删除请从数据库中删除
 */
class Theme extends Backend
{

    /**
     * @var \app\common\model\Config
     */
    protected $model = null;
    protected $noNeedRight = ['check'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Config');
    }

    /**
     * 查看
     */
    public function index()
    {


        $results = (new \app\admin\model\Setting)->where(['uniacid'=>$GLOBALS['uniacid'], 'key'=>'theme_index'])->column('key,value');

        $this->view->assign('theme_index', !empty($results['theme_index']) ? intval($results['theme_index']) : 0);

        return $this->view->fetch();
    }


    /**
     * 保存
     */
    public function save(){

        $data['theme_index'] = !empty($_POST['themeid']) ? intval($_POST['themeid']) : 0;

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

}
