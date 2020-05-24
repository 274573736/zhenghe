<?php

namespace app\admin\controller\setting;

use app\common\controller\Backend;

use think\Db;
use lib\Amap;

/**
 * 价格配置
 *
 * @icon fa fa-cogs
 * @remark 可以在此增改系统的变量和分组,也可以自定义分组和变量,如果需要删除请从数据库中删除
 */
class Price extends Backend
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

        //已有配置
        $results = (new \app\admin\model\Setting)->where(['uniacid'=>$GLOBALS['uniacid'],'city_id'=>$GLOBALS['city_id']])->column('key,value');

        if(empty($results)){
            $results = (new \app\admin\model\Setting)->where(['uniacid'=>$GLOBALS['uniacid']])->column('key,value');
        }

        ////////////////////////////////////////////////////////////////
        //跑腿
        if( !empty($results['distance']) ){
            $results['distance'] = @unserialize($results['distance']);
        }

        if(!empty($results['weight'])){
            $results['weight'] = @unserialize($results['weight']);
        }

        if( isset($results['night_price']) && !empty($results['night_price'])) {
            $results['night_price'] = @unserialize($results['night_price']);
        }

        ////////////////////////////////////////////////////////////////
        //帮买
        if( !empty($results['buy_distance']) ){
            $results['buy_distance'] = @unserialize($results['buy_distance']);
        }

        if(!empty($results['buy_weight'])){
            $results['buy_weight'] = @unserialize($results['buy_weight']);
        }

        if( isset($results['buy_night_price']) && !empty($results['buy_night_price']) ) {
            $results['buy_night_price'] = @unserialize($results['buy_night_price']);
        }


        ////////////////////////////////////////////////////////////////
        //代驾
        if( !empty($results['drive_distance']) ){
            $results['drive_distance'] = @unserialize($results['drive_distance']);
        }

        if(!empty($results['drive_weight'])){
            $results['drive_weight'] = @unserialize($results['drive_weight']);
        }


        if(isset($results['drive_night_price']) && !empty($results['drive_night_price'])) {
            $results['drive_night_price'] = @unserialize($results['drive_night_price']);
        }

        if(!empty($results['buy_floor_price'])){
            $results['buy_floor_price'] = @unserialize($results['buy_floor_price']);
        }
        if(!isset($results['dcharge_type'])){
            $results['dcharge_type'] = 1;
        }


        $this->view->assign('result', $results);

        return $this->view->fetch();
    }

    /**
     * 跑腿
     */
    public function add(){
        $price = !empty($_POST['price']) ? $_POST['price'] : array();
        is_array($price) || $price = array($price);

        $data = array();

        $data['min_distance']  = !empty($price['min_distance']) ? toint($price['min_distance']) : '';
        $data['min_weight']  = !empty($price['min_weight']) ? toint($price['min_weight']) : '';
        $data['initial_price'] = !empty($price['initial_price']) ? toint($price['initial_price']) : 0;
        $data['change_price']  = !empty($price['change_price']) ? toint($price['change_price']) : 0;

        //续程
        $distance = array_combine($price['distance'],$price['distance_price']);
        foreach ($distance as $k=>$v){
            if(empty($k) || empty($v)){
                unset($distance[$k]);
                continue;
            }
            if($k<$data['min_distance'])
                $this->error('续程公里必须≥起步公里');

            $distance[$k] = toint($v);
        }

        //续重
        $weight  = array_combine($price['weight'],$price['weight_price']);
        foreach ($weight as $k=>$v){
            if(empty($k) || empty($v)){
                unset($weight[$k]);
                continue;
            }
            if($k<$data['min_weight'])
                $this->error('续重公斤数必须≥起步公斤');

            $weight[$k] = toint($v);
        }

        if(!empty($distance))
            $data['distance'] = serialize($distance);

        if(!empty($weight))
            $data['weight'] = serialize($weight);


        //夜间费
        $nightPrice = $this->request->param('night/a');
        if($nightPrice){
            if( count($nightPrice['start']) != count($nightPrice['end']) || count($nightPrice['start']) != count($nightPrice['price']) ){
                $this->error('夜间阶段费填写有误');
            }
            $nightPrice = $this->nightPrice($nightPrice);
        }

        //夜间费
        $data['night_price']  = !empty($nightPrice) ? serialize($nightPrice): '' ;



        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');

    }

    /**
     * 帮买
     */
    public function buy(){
        $price = !empty($_POST['price']) ? $_POST['price'] : array();
        is_array($price) || $price = array($price);

        $data = array();

        $data['buy_min_distance']  = !empty($price['buy_min_distance']) ? toint($price['buy_min_distance']) : '';
        $data['buy_min_weight']  = !empty($price['buy_min_weight']) ? toint($price['buy_min_weight']) : '';
        $data['buy_initial_price'] = !empty($price['buy_initial_price']) ? toint($price['buy_initial_price']) : 0;
        $data['buy_change_price']  = !empty($price['buy_change_price']) ? toint($price['buy_change_price']) : 0;

        $buy_floor_price  = (!empty($price['buy_floor_price']) && is_array($price['buy_floor_price'])) ? @serialize($price['buy_floor_price']) : false;

        $data['buy_floor_price'] = !empty($buy_floor_price) ? $buy_floor_price : '';
        //续程
        $distance = array_combine($price['buy_distance'],$price['buy_distance_price']);
        foreach ($distance as $k=>$v){
            if(empty($k) || empty($v)){
                unset($distance[$k]);
                continue;
            }
            if($k<$data['buy_min_distance'])
                $this->error('续程公里必须≥起步公里');

            $distance[$k] = toint($v);
        }

        //续重
        $weight  = array_combine($price['buy_weight'],$price['buy_weight_price']);
        foreach ($weight as $k=>$v){
            if(empty($k) || empty($v)){
                unset($weight[$k]);
                continue;
            }
            if($k<$data['buy_min_weight'])
                $this->error('续重公斤数必须≥起步公斤');

            $weight[$k] = toint($v);
        }

        if(!empty($distance))
            $data['buy_distance'] = serialize($distance);

        if(!empty($weight))
            $data['buy_weight'] = serialize($weight);

        //夜间费
        $nightPrice = $this->request->param('night/a');
        if($nightPrice){
            if( count($nightPrice['start']) != count($nightPrice['end']) || count($nightPrice['start']) != count($nightPrice['price']) ){
                $this->error('夜间阶段费填写有误');
            }
            $nightPrice = $this->nightPrice($nightPrice);
        }

        //夜间费
        $data['buy_night_price']  = !empty($nightPrice) ? serialize($nightPrice): '' ;



        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 万能
     */
    public function line(){

        $price = !empty($_POST['price']) ? $_POST['price'] : array();
        $data = array();

        $data['line_initial_price']  = !empty($price['line_initial_price']) ? toint($price['line_initial_price']) : '';

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 代驾
     */
    public function drive(){
        $price = !empty($_POST['price']) ? $_POST['price'] : array();
        is_array($price) || $price = array($price);
        $data = array();
        $data['drive_min_distance']  = !empty($price['drive_min_distance']) ? toint($price['drive_min_distance']) : '';
        $data['drive_initial_price'] = !empty($price['drive_initial_price']) ? toint($price['drive_initial_price']) : '';
        $data['drive_change_price']  = !empty($price['drive_change_price']) ? toint($price['drive_change_price']) : 0;
        $data['dcharge_type']        = $price['dcharge_type'];
        $data['amap_driver_key']     = $price['amap_driver_key'];

        //续程
        $distance = array_combine($price['drive_distance'],$price['drive_distance_price']);
        foreach ($distance as $k=>$v){
            if(empty($k) || empty($v)){
                unset($distance[$k]);
                continue;
            }
            if($k<$data['drive_min_distance'])
                $this->error('续程公里必须≥起步公里');

            $distance[$k] = toint($v);
        }


        if(!empty($distance))
            $data['drive_distance'] = serialize($distance);

        //夜间费
        $nightPrice = $this->request->param('night/a');
        if($nightPrice){
            if( count($nightPrice['start']) != count($nightPrice['end']) || count($nightPrice['start']) != count($nightPrice['price']) ){
                $this->error('夜间阶段费填写有误');
            }
            $nightPrice = $this->nightPrice($nightPrice);
        }
        $data['drive_night_price']  = !empty($nightPrice) ? serialize($nightPrice): '' ;

        //生成serverID
        if($data['amap_driver_key']){
            $setting = Db::name('setting')->where(['uniacid'=>$GLOBALS['uniacid'],'key'=>['in',['amap_service_id','amap_driver_key'] ] ])->select();
            $setting = array_column($setting,'value','key');
            if(!isset($setting['amap_service_id']) && !isset($setting['amap_driver_key']) || $setting['amap_driver_key'] != $data['amap_driver_key']){
                $serverID = $this->createServerID($data['amap_driver_key']);
                $data['amap_service_id'] = $serverID;
            }
        }

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    public function createServerID($key){
        if(!$key){
            $this->error('开启实时计费需要填写高德地图key');
        }

        $re = Amap::addServiceID(['key'=>$key,'name'=>'代驾司机']);
        if($re['errcode'] != 10000){
            $this->error(isset($re['errdetail']) ? $re['errdetail'] : $re['errmsg']);
        }
        $serverID = $re['data']['sid'];
        return $serverID;
    }


    public function nightPrice($price)
    {
        $arr = [];
        foreach ($price as $k => $v) {
            foreach ($v as $k1 => $v1) {
                if(!$v1){
                    $this->error('阶段夜间费参数请填写完整！');
                }
                if ($k == 'start') {
                    $arr[$k1]['start'] = $v1;
                    unset($v[$k1]);
                } elseif ($k == 'end') {
                    $arr[$k1]['end'] = $v1;
                    unset($v[$k1]);
                } elseif ($k == 'price') {
                    $arr[$k1]['price'] = $v1;
                    unset($v[$k1]);
                }
            }
        }
        return $arr;
    }
}
