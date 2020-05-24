<?php

namespace app\admin\controller\busines;

use app\common\controller\Backend;
use think\Exception;
use think\Db;

/**
 * 系统配置
 *
 * @icon fa fa-cogs
 * @remark 可以在此增改系统的变量和分组,也可以自定义分组和变量,如果需要删除请从数据库中删除
 */
class Setting extends Backend
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

        if(!empty($GLOBALS['city_id'])){
            $action = strtolower($this->request->action());
            if($action!=='index'){
                $this->error('您的市代理账号, 无法修改系统配置');
            }
        }

    }

    /**
     * 查看
     */
    public function index()
    {
        //已有配置
        $condition = 'eleme_logo,eleme_name,eleme_switch,eleme_key,eleme_secret,eleme_desc,business_recharge,business_poster,business_switch,business_hezuo,business_kk';

        $results = (new \app\admin\model\Setting)
            ->where(['uniacid'=>$GLOBALS['uniacid'],'city_id'=>0])
            ->where('key','in', $condition)
            ->column('key,value');


        $results['business_poster'] = !empty($results['business_poster']) ? @unserialize($results['business_poster']) : array();

        $results['business_hezuo'] = !empty($results['business_hezuo']) ? htmlspecialchars_decode($results['business_hezuo']) : '';
        $results['business_kk'] = !empty($results['business_kk']) ? htmlspecialchars_decode($results['business_kk']) : '';


        $domian = $this->request->domain();

        $results['callback_url'] = $domian."/addons/make_speed/core/public/index.php/admin/eleme/callback?uniacid=".$GLOBALS['uniacid'];
        $results['callapi_url']  = $domian."/addons/make_speed/core/public/index.php/admin/eleme/callapi?uniacid=".$GLOBALS['uniacid'];


        $this->view->assign('result', $results);

        return $this->view->fetch();
    }

    /**
     * 骑手端小程序绑定
     *
     */
    public function add(){
        $data = array();

        $business_poster[0] = !empty($_POST['business_poster1']) ? trim($_POST['business_poster1']) : '';
        $business_poster[1] = !empty($_POST['business_poster2']) ? trim($_POST['business_poster2']) : '';

        $data['business_recharge'] = !empty($_POST['business_recharge']) ? intval($_POST['business_recharge']) : 0;

        $data['business_switch'] = !empty($_POST['business_switch']) ? intval($_POST['business_switch']) : 0;

        $data['business_poster'] = @serialize($business_poster);

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功！');
        }

        $this->error('保存失败！请稍后重试');
    }

    public function addtext(){

        $data = array();
        if(isset($_POST['business_kk']))
            $data['business_kk'] = !empty($_POST['business_kk']) ? htmlspecialchars($_POST['business_kk']) : '';

        if(isset($_POST['business_hezuo']))
            $data['business_hezuo'] = !empty($_POST['business_hezuo']) ? htmlspecialchars($_POST['business_hezuo']) : '';

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功！');
        }

        $this->error('保存失败！请稍后重试');
    }

    public function eleme(){
        $data['eleme_switch'] = !empty($_POST['eleme_switch']) ? intval($_POST['eleme_switch']) : 0;
        $data['eleme_key']    = !empty($_POST['eleme_key']) ? trim($_POST['eleme_key']) : '';
        $data['eleme_secret']    = !empty($_POST['eleme_secret']) ? trim($_POST['eleme_secret']) : '';
        $data['eleme_desc']    = !empty($_POST['eleme_desc']) ? htmlspecialchars($_POST['eleme_desc']) : '';
        $data['eleme_logo']    = !empty($_POST['eleme_logo']) ? trim($_POST['eleme_logo']) : '';
        $data['eleme_name']    = !empty($_POST['eleme_name']) ? trim($_POST['eleme_name']) : '';


        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功！');
        }

        $this->error('保存失败！请稍后重试');
    }
}
