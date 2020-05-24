<?php

namespace app\admin\controller\busines;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Business extends Backend
{
    
    /**
     * Business模型对象
     * @var \app\admin\model\Business
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Business;

        $this->view->assign('statusList', $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     */
    public function index()
    {
        $this->searchFields = 'name,phone';
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {

            $wheres = array('uniacid'=>$GLOBALS['uniacid']);
            if(!empty($GLOBALS['city_id'])){
                $wheres['city_id'] = $GLOBALS['city_id'];
            }

            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with('users')
                ->where($where)
                ->where($wheres)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with('users')
                ->withCount(['orders'=>function($query){$query->where('status','>',1);}])
                ->where($where)
                ->where($wheres)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible([]);
            }

            $list = collection($list)->toArray();

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['uniacid'] = $GLOBALS['uniacid'];

            if ($params) {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
                    if(!$params['user_id']){
                        $this->error('请选择用户！');
                    }

                    $exit = Db::name('business')->where('user_id', $params['user_id'])->field('id')->find();
                    if(!empty($exit)){
                        $this->error('该用户已有商户, 不可重复添加！');
                    }

                    if(empty($params['lat']) || empty($params['lng'])){
                        $this->error('未选择大客户地址');
                    }

                    if(!empty($params['shop_id'])){
                        $params['shop_id'] = trim($params['shop_id']);
                    }

                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
                        Db::name('business_info')->insert([
                            'lat'       => $params['lat'],
                            'lng'       => $params['lng'],
                            'address' => $params['address'],
                            'business_id' => $this->model->id
                        ]);

                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }

                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        $mapkey = Db::name('setting')->where(['key'=>'tencent_key','uniacid'=>$GLOBALS['uniacid']])->field('value')->find();

        $this->view->assign('mapkey',isset($mapkey['value']) ? $mapkey['value'] : '');
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['uniacid'] = $GLOBALS['uniacid'];
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    if(!empty($params['shop_id'])){
                        $params['shop_id'] = trim($params['shop_id']);
                    }
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {

                        Db::name('business_info')->where('business_id',intval($ids))->update([
                            'lat'       => $params['lat'],
                            'lng'       => $params['lng'],
                            'address' => $params['address'],
                        ]);

//                        if($params['status'] != 0){
//                            import('lib.SendWchatTpl', EXTEND_PATH);
//                            $sendTpl  = new \SendWchatTpl();
//                            $tplID    = Db::name('setting')->where(['key'=>'audit_rider_tpl'])->value('value');
//                            $data    = [
//                                'tpl_id'   => $tplID,
//                                'user_id' => $row->user_id,
//                                'data'  => [
//                                    'keyword1'=>array('value' => date('Y-m-d H:i:s',$row->add_time) ),
//                                    'keyword2'=>array('value' => $params['status'] == 2 ? '审核通过' : '审核失败'),
//                                    'keyword3'=>array('value' => $params['status'] == 2 ? ''        : $params['remark']),
//                                    'keyword4'=>array('value' => date('Y-m-d H:i:s',time()) ),
//                                ]
//                            ];
//                            $sendTpl->sendRiderTemplate($data,false);
//                        }

                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        $info = Db::name('business_info')->where('business_id',intval($ids))->find();

        $mapkey = Db::name('setting')->where(['key'=>'tencent_key','uniacid'=>$GLOBALS['uniacid']])->field('value')->find();

        $this->view->assign('mapkey',isset($mapkey['value']) ? $mapkey['value'] : '');
        $this->view->assign("info", $info);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)
                ->select();
            $count = 0;
            foreach ($list as $k => $v) {
                $count += $v->delete();
            }
            if ($count) {

                Db::name('business_info')->where('business_id', 'in', $ids)->delete();
                Db::name('business_user')->where('business_id', 'in', $ids)->delete();

                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    //计费
    public function price($ids){

        $row = $this->model->get($ids);

        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }

        $field = 'night_price,price,agreement_price,charge_mode,init_price,init_distance,change_price';
        $price = Db::name('business_info')->where('business_id', $ids)->field($field)->find();

        if ($this->request->isPost()) {
            $params = !empty($_POST['price']) ? $_POST['price'] : array();
            //续程
            $distance = array_combine($params['distance'],$params['distance_price']);
            foreach ($distance as $k=>$v){
                if(empty($k) || empty($v)){
                    unset($distance[$k]);
                    continue;
                }
                if($k<$params['init_distance'])
                    $this->error('续程公里必须≥起步公里');

                $distance[$k] = toint($v);
            }
            $params['price'] = !empty($distance) ? serialize($distance) : '';

            $nightPrice = $this->request->param('night/a');

            if( count($nightPrice['start']) != count($nightPrice['end']) || count($nightPrice['start']) != count($nightPrice['price']) ){
                $this->error('夜间阶段费填写有误');
            }
            $nightPrice = $this->nightPrice($nightPrice);

            $data = array(
                'init_price'      => !empty($params['init_price']) ? $params['init_price'] : 0,
                'init_distance'   => !empty($params['init_distance']) ? $params['init_distance'] : 0,
                'price'           => $params['price'],
                'agreement_price' => $params['agreement_price'],
                'charge_mode'     => $params['charge_mode'],
                'night_price'     => !empty($nightPrice)   ? serialize($nightPrice) : '',
                'change_price'    => $params['change_price'],
            );

            $up = Db::name('business_info')->where('business_id', $ids)->update($data);

            if(empty($up))
                $this->error('更新失败, 请稍后重试');

            $this->success('保存成功。');
        }

        $price['price'] = !empty($price['price']) ? @unserialize($price['price']) : array();
        $price['night'] = !empty($price['night_price']) ? @unserialize($price['night_price']) : array();
        empty($price['price']) && $price['price'] = array();

        $this->view->assign("price", $price);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    //店员
    public function person($ids){
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            $data = array(
                'business_id'   => intval($ids),
                'user_id'   => $params["user_id"],
                'username'  => $params["username"],
                'sex'       => $params["sex"],
                'mobile'    => $params["mobile"],
                'home_address'=> $params["home_address"],
                'add_time'  => time()
            );

            $result = Db::name('business_user')->insert($data);

            if ($result !== false) {
                $this->success('操作成功！已添加1个店员');
            } else {
                $this->error('添加失败, 请刷新后重试');
            }
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    //骑手
    public function rider($ids){
        !empty($ids) && $ids = intval($ids);
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));



        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $num = 0;
            !empty($_POST['data']) && is_array($_POST['data']) && $num = count($_POST['data']);
            $data = (!empty($_POST['data']) && is_array($_POST['data'])) ? implode(',', $_POST['data']) : '';

            $info = Db::name('business_info')->where(['business_id'=>$ids])->update(['rider_id'=>$data]);

            if(empty($info))
                $this->error('操作失败,请稍后重试');

            if(!empty($_POST['type'])){
                $this->success('操作成功, 已移除选中骑手');
            }

            $this->success('操作成功, 已分配'.$num.'个骑手');
        }

        //骑手列表
        $rwhere = ['uniacid'=>$GLOBALS['uniacid']];
        if(!empty($GLOBALS['city_id'])){
            $rwhere['city_id'] = $GLOBALS['city_id'];
        }
        $rider = Db::name('rider')->where($rwhere)->field('id,status,real_name,mobile')->select();
        foreach ($rider as $k=>$v){
            $rider[$k]['status'] = ($v['status']<2) ? true : false;
        }
        //已存在骑手
        $ridered = Db::name('business_info')->where('business_id',$ids)->field('rider_id')->find();
        $ridered = empty($ridered['rider_id']) ? array() : explode(',', $ridered['rider_id']);

        $this->view->assign('riderList', $rider);
        $this->view->assign('ridered', $ridered);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


    public function getaddress(){

        $lat = !empty($_REQUEST['lat']) ? floatval($_REQUEST['lat']) : 0;
        $lng = !empty($_REQUEST['lng']) ? floatval($_REQUEST['lng']) : 0;

        $type = !empty($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
        $address = !empty($_REQUEST['address']) ? trim($_REQUEST['address']) : '';

        $url = "https://apis.map.qq.com/ws/geocoder/v1/?";

        if(!empty($type) && !empty($address)){
            $url .= "key=".'Y4SBZ-XG76W-EMORO-RFJ6H-J2WNV-ONBKS'."&address=".$address;

            $html   = file_get_contents($url);
            $results= json_decode($html,true);

            if(!empty($results['status']) || empty($results['result'])){
                $this->error('地图响应失败,请稍后重试'.$results['status']);
            }

            $this->success('','',$results['result']);
        }

        $param = array(
            'location'  => "$lat,$lng",
            'get_poi'   => 0,
            'key'       => 'Y4SBZ-XG76W-EMORO-RFJ6H-J2WNV-ONBKS'
        );
        $url .= http_build_query($param);

        $html   = file_get_contents($url);
        $results= json_decode($html,true);

        if(!empty($results['status']) || empty($results['result'])){
            $this->error('地图响应失败,请稍后重试'.$results['status']);
        }

        $this->success('','',$results['result']);

    }

    public function detail($ids){

        $person = Db::name('business_user')->where('business_id', intval($ids))->column('id,user_id,username,mobile,sex,home_address,add_time');

        empty($person) && $person = array();

        $business = Db::name('business')->where('id', $ids)->find();
        if(!empty($business)) {
            //授权URL
            vendor('eleme.Config');
            vendor('eleme.Eleme');

            //获取系统设置
            $ele = Db::name('setting')
                ->where('key','in','eleme_switch,eleme_key,eleme_secret')
                ->where(['uniacid'=>$GLOBALS['uniacid']])
                ->select();
            empty($ele) && $ele=array();
            $ele = @array_column($ele,'value','key');
            if(isset($ele['eleme_key']) && isset($ele['eleme_secret']) ){
                $domian = $this->request->domain();
                $params = array(
                    'key' => $ele['eleme_key'],
                    'secret' => $ele['eleme_secret'],
                    'sandbox' => true,
                    'callback_url' => urlencode($domian . "/addons/make_speed/core/public/index.php/admin/eleme/callback?shopid=". $business['shop_id'].'&uniacid='.$GLOBALS['uniacid']),
                );
                if(!empty($ele['eleme_switch'])){
                    $params['sandbox'] = false;
                }

                $config = new \Config($params['key'], $params['secret'], $params['sandbox']);

                $ele = new \Eleme($config);

                $business['ele_auth_url'] = $ele->get_oauth_url($params['callback_url']);
            }
            $this->view->assign('result', $business);

        }

        $this->view->assign('person', $person);

        return $this->view->fetch();
    }

    /**
     * 删除店员
     */
    public function delperson(){
        $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $del = Db::name('business_user')->where('id', $id)->delete();

        if(empty($del)){
            $this->error('删除失败, 请稍后重试');
        }

        $this->error('操作成功, 已移除此店员');
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
