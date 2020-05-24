<?php

namespace app\admin\controller\general;

use app\common\controller\Backend;
use app\common\library\Email;
use app\common\model\Config as ConfigModel;
use think\Exception;
use think\Db;
use think\Request;

/**
 * 系统配置
 *
 * @icon fa fa-cogs
 * @remark 可以在此增改系统的变量和分组,也可以自定义分组和变量,如果需要删除请从数据库中删除
 */
class Config extends Backend
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

    public function saveConfig(){
        $params = $this->request->param('row/a');

        $params['pindex_icon']  = $params['pindex_icon'] ? serialize( $params['pindex_icon'] ) : '';

        $set = (new \app\admin\model\Setting)->saveValue($params);
        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 查看
     */
    public function index()
    {
        //已有配置
        $results = (new \app\admin\model\Setting)->where(['uniacid'=>$GLOBALS['uniacid'],'city_id'=>0])->column('key,value');

        if( !empty($results['distance']) ){
            $results['distance'] = unserialize($results['distance']);
            $n = count($results['distance']);
            $t = '';
            while($n<3){
                $results['distance'][$t] = $t;
                $n++;
                $t.=' ';
            }
        }

        if(!empty($results['weight'])){
            $results['weight'] = unserialize($results['weight']);
            $wn = count($results['weight']);
            $t = '';
            while($wn<3){
                $results['weight'][$t] = $t;
                $wn++;
                $t.=' ';
            }
        }

        if(!empty($results['night_time'])) {
            $results['night_time'] = unserialize($results['night_time']);
        }

        $results['open_business'] = !empty($results['open_business']) ? @unserialize($results['open_business']) : array();
        $results['open_business'] = @array_merge($results['open_business']);

        if( empty($results['open_business']) || count($results['open_business']) < 4 ) {
            $results['open_business'] = array(
                array(
                    'type' => 0,
                    'status' => true,
                    'title' => '帮我送',
                    'sort' => 3,
                ),
                array(
                    'type' => 1,
                    'status' => true,
                    'title' => '帮我买',
                    'sort' => 2,
                ),
                array(
                    'type' => 2,
                    'status' => true,
                    'title' => '万能服务',
                    'sort' => 1,
                ),
                array(
                    'type' => 3,
                    'status' => true,
                    'title' => '帮我代驾',
                    'sort'  => 0,
                ),
            );
        }


        $results['register_business'] = !empty($results['register_business']) ? @unserialize($results['register_business']) : array();
        $results['register_business'] = @array_merge($results['register_business']);

        if(empty($results['register_business']) || !is_array($results['register_business'])) {
            $results['register_business'] = array(
                array(
                    'type' => 0,
                    'status' => true,
                    'cname'  => 'pt',
                    'title' => '跑腿',
                    'sort' => 3,
                ),
                array(
                    'type' => 1,
                    'status' => true,
                    'cname'  => 'dj',
                    'title' => '代驾',
                    'sort' => 2,
                )
            );
        }

        $business_type = array('帮我送','帮我买','万能跑腿','帮我代驾','货运','家政');
        $register_type = array('跑腿','代驾司机','货车司机','家政');

        $tableName  = config('database.prefix').'vehicle';
        $exists     = db()->query('SHOW TABLES LIKE '."'".$tableName."'");

        $types      = @array_column($results['open_business'],'type');
        $registers  = @array_column($results['register_business'],'type');
        if($exists){
            if( !in_array(4,$types) ){
                $ftype = array(
                    'type' => 4,
                    'status' => false,
                    'title' => '货运',
                    'sort'  => -1,
                );
                array_push($results['open_business'],$ftype);
            }
            if ( !in_array(2,$registers) ){
                $ftype = array(
                    'type' => 2,
                    'cname' => 'hy',
                    'status' => false,
                    'title' => '货运',
                    'sort'  => 1,
                );
                array_push($results['register_business'],$ftype);
            }
        }

        $homemmakingTableName  = config('database.prefix').'homemaking_category';
        $homemmakingExists     = db()->query('SHOW TABLES LIKE '."'".$homemmakingTableName."'");
        if($homemmakingExists){
            if( !in_array(5,$types) ){
                $htype = array(
                    'type' => 5,
                    'status' => false,
                    'title' => '家政',
                    'sort'  => -1,
                );
                array_push($results['open_business'],$htype);
            }
            if ( !in_array(3,$registers) ){
                $htype = array(
                    'type' => 3,
                    'cname' => 'jz',
                    'status' => false,
                    'title' => '家政',
                    'sort'  => 1,
                );
                array_push($results['register_business'],$htype);
            }
        }

        if(isset($results['open_business'][0]['sort'])){
            @array_multisort(array_column($results['open_business'],'sort'),SORT_DESC,$results['open_business']);
        }
        if(isset($results['register_business'][0]['sort'])){
            @array_multisort(array_column($results['register_business'],'sort'),SORT_DESC,$results['register_business']);
        }


        $results['rider_wages'] = !empty($results['rider_wages']) ? $results['rider_wages'] * 100 : '';
        $results['user_gral'] = !empty($results['user_gral']) ? $results['user_gral'] * 100 : '';
        $results['user_grow'] = !empty($results['user_grow']) ? $results['user_grow'] * 100 : '';
        $results['public_price'] = !empty($results['public_price']) ? $results['public_price'] * 100 : '';

        $results['user_recharge_coupon'] = !empty($results['user_recharge_coupon']) ? $results['user_recharge_coupon'] * 100 : '';

        $progromIndexIcon = isset($results['pindex_icon']) ? unserialize($results['pindex_icon']) : '';


        //小程序码
        $smallProgramImg = [
            [
                'type'  => 0,
                'name'  => '帮我送',
                'url'   => isset($results['help_send_img'])   ? $results['help_send_img']  :'',
            ],
            [
                'type'  => 1,
                'name'  => '帮我买',
                'url'   => isset($results['help_buy_img'])    ? $results['help_buy_img']   :'',
            ],
            [
                'type'  => 2,
                'name'  => '万能服务',
                'url'   => isset($results['all_service_img']) ? $results['all_service_img'] :'',
            ],
            [
                'type'  => 3,
                'name'  => '帮我代驾',
                'url'   => isset($results['sub_driver_img'])  ? $results['sub_driver_img']  :'',
            ],
        ];

        $tableName  = config('database.prefix').'vehicle';
        $table    = db()->query('SHOW TABLES LIKE '."'".$tableName."'");
        if($table) {
            $freightType = [
                'type'  => 4,
                'name'  => '货运',
                'url'   => isset($results['freight_img'])     ? $results['freight_img']      :'',
            ];
            array_push($smallProgramImg,$freightType);
        }

        $path = ROOT_PATH . 'port/port.txt';
        $port = 9502;
        if(is_file($path)){
            $port = file_get_contents($path);
        }
        $this->view->assign('result', $results);
        $this->view->assign('btype', $business_type);
        $this->view->assign([
            'register_type'  =>  $register_type,
            'pindex_icon'    =>  $progromIndexIcon,
            'smallProgramImg'=>  $smallProgramImg,
            'port'           => $port,
        ]);

        return $this->view->fetch();
    }

    /**
     * 小程序配置
     *
     */
    public function miniprogram(){
        $data = $this->request->post('row/a');

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 小程序首页图片
     *
     */
    public function program_icon(Request $request){
        $data = $request->param('row/a');

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 短信配置
     *
     */
    public function sms(){
        //sms
        $row = $this->request->param('row/a');

        $set = (new \app\admin\model\Setting)->saveValue($row);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 其他配置
     */
    public function other(){
        //other
        $row = $this->request->param('row/a');

        $row['user_recharge_coupon']   = !empty($row['user_recharge_coupon']) ? sprintf('%.2f', $row['user_recharge_coupon']*1/100) : '';
        $row['wechat_withdraw'] = is_array($row['wechat_withdraw']) && isset($row['wechat_withdraw'][0])  ? implode(',',$row['wechat_withdraw']) : '0,1,2';
        $set = (new \app\admin\model\Setting)->saveValue($row);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     * 骑手端小程序绑定
     *
     */
    public function riderprogram(){
        $data = array();

        $data['rider_program_key'] = !empty($_POST['rider_program_key']) ? trim($_POST['rider_program_key']) : '';
        $data['rider_program_secret'] = !empty($_POST['rider_program_secret']) ? trim($_POST['rider_program_secret']) : '';

        //骑手端uniacid
        $result = Db::table('ims_account_wxapp')
            ->where(array('key'=>$data['rider_program_key'], 'secret'=>$data['rider_program_secret']))
            ->order('uniacid','asc')->find();

        if(empty($result['uniacid']))
            $this->error('尚未添加此骑手端小程序');

        $data['rider_uniacid'] = $result['uniacid'];

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功！');
        }

        $this->error('保存失败！请稍后重试');
    }

    /**
     * SSL证书保存
     */
    public function savessl(){
        $data = array();

        $data['ssl_key'] = !empty($_POST['ssl_key']) ? $_POST['ssl_key'] : '';
        $data['ssl_cert'] = !empty($_POST['ssl_cert']) ? $_POST['ssl_cert'] : '';

        if(empty($data['ssl_key']) || empty($data['ssl_cert']))
            $this->error('内容不能为空');

        //echo ROOT_PATH;/www/wwwroot/t.xiaomawei.com/addons/make_speed/core/

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {

            file_put_contents(ROOT_PATH.'server/config/ssl.crt',$data['ssl_cert']);
            file_put_contents(ROOT_PATH.'server/config/ssl.key',$data['ssl_key']);

            $this->success('保存成功！');
        }

        $this->error('保存失败！请稍后重试');

    }

    /**
     * 开通业务
     */
    public function business(Request $request){

        if($request->isPost()){
            $data = array();

            $business = !empty($_POST['business']) ? $_POST['business'] : array();

            //开发注册业务
            $register = $request->param('register_business/a');
            if($register && is_array($register)){
                $f = 0;
                foreach($register as $k=>$v){
                    $register[$k]['status'] = isset($v['status']) ? true : false;
                    $register[$k]['sort']   = !empty($v['sort'])  ? intval($v['sort']) : 0;
                    !empty($register[$k]['status']) && $f++;
                }
                if($f<1){
                    $this->error('至少选择开启一种业务！');
                }
                $data['register_business'] = serialize($register);
            }



            if(empty($business) || !is_array($business))
                $this->error('请选择正确业务类型');

            $n =0;
            foreach ($business as $k=>$v){
                $business[$k]['status'] = isset($v['status']) ? true : false;
                $business[$k]['sort']   = !empty($v['sort'])  ? intval($v['sort']) : 0;
                !empty($business[$k]['status']) && $n++;
            }

            if($n<1){
                $this->error('至少选择开启一种业务！');
            }

            $data['open_business'] = serialize($business);

            $set = (new \app\admin\model\Setting)->saveValue($data);

            if(!empty($set)) {
                $this->success('保存成功！');
            }

            $this->error('保存失败！请稍后重试');
        }

    }

    /**
     * 启用模板消息
     */
    public function startrider(){

        $type = !empty($_REQUEST['type']) ? abs(intval($_REQUEST['type'])) : 0;
        if($type>5)
            $this->error('传递类型有误，请刷新后重试');

        $value = array('template_id','cancel_template_id','acceptorder_template_id','accepted_template_id','complete_template_id','audit_rider_tpl');
        $keys  = [
            ['thing8','character_string1','amount9','phrase10','time2'],    //下单成功
            ['character_string2','amount10','phrase11','time12','thing5'],  //订单取消
            ['number4','thing2','thing3','time6'],
            ['number1','time4','name7','phone_number8','thing9'],
            ['time5','thing2','thing6','date3'],
        ];
        $data  = [
            [ 'tid' => 3621, 'kidList' => [8,1,9,10,2],  'sceneDesc' => '下单成功通知'],
            [ 'tid' => 2171, 'kidList' => [2,10,11,12,5],'sceneDesc' => '订单取消通知'],
            [ 'tid' => 1395, 'kidList' => [4,2,3,6],     'sceneDesc' => '抢单提醒'],
            [ 'tid' => 3219, 'kidList' => [1,13,4],      'sceneDesc' => '通知用户已接单'],
            [ 'tid' => 3676, 'kidList' => [1,6,7,8,9],   'sceneDesc' => '通知用户订单完成'],
            [ 'tid' => 3975, 'kidList' => [5,2,6,3],     'sceneDesc' => '骑手注册申请'],
        ];

        $unicid = $GLOBALS['uniacid'];
        if($type==2 || $type == 5) {
            $rider = Db::name('setting')->where(['key' => 'rider_uniacid', 'uniacid' => $GLOBALS['uniacid']])->find();
            if (empty($rider) || empty($rider['value']))
                $this->error('未绑定骑手端小程序!');

            $unicid = $rider['value'];
        }

        $token = get_access_token($unicid);
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/addtemplate?access_token='.$token;
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
        );

        $result = httpPost($url,json_encode( $data[$type]),$headers);
        $result = json_decode($result, true);
        if($result['errcode']!==0 || empty($result['priTmplId'])){
            $this->error($result['errmsg'] ? $result['errmsg'] : '添加至模板库列表失败!');
        }


        //直接更新
        $set = (new \app\admin\model\Setting)->saveValue(array($value[$type]=>$result['priTmplId']));

        if(!empty($set)) {
            $this->success('操作成功！已启用',null,$result);
        }

        $this->error('保存失败！请稍后重试');
    }


    public function savesystem(){
        //other
        $data = $this->request->param('row/a');
        $data['system_switch']  = isset($data['system_switch']) ? intval($data['system_switch']) : 0;
        $data['public_price']   = isset($data['public_price'])  ? doubleval($data['public_price']/100) : 0;


        $port = $this->request->param('workerman_port');

        $addPort = 0;
        if($port){

            $path = ROOT_PATH.'port';
            if( !is_dir($path) ){
                mkdir($path,0777);
            }
            $addPort = file_put_contents($path.'/port.txt',$port);
        }

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set) || $addPort) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');
    }

    /**
     *
     */
    public function settime(){
        $data = array();

        $data['expect_time0'] = !empty($_POST['give_expect_time']) ? abs(intval($_POST['give_expect_time'])) : 0;
        $data['expect_timed0']= !empty($_POST['give_expect_timed']) ? abs(intval($_POST['give_expect_timed'])) : 0;
        $data['expect_time1'] = !empty($_POST['buy_expect_timed']) ? abs(intval($_POST['buy_expect_timed'])) : 0;
        $data['expect_timed1'] = !empty($_POST['buy_expect_timed']) ? abs(intval($_POST['buy_expect_timed'])) : 0;
        $data['s_expect_timed1'] = !empty($_POST['buys_expect_timed']) ? abs(intval($_POST['buys_expect_timed'])) : 0;
        $data['expect_time2'] = !empty($_POST['fuwu_expect_time']) ? abs(intval($_POST['fuwu_expect_time'])) : 0;
        $data['expect_time3'] = !empty($_POST['drive_expect_time']) ? abs(intval($_POST['drive_expect_time'])) : 0;

        

        $set = (new \app\admin\model\Setting)->saveValue($data);

        if(!empty($set)) {
            $this->success('保存成功');
        }

        $this->error('更新修改失败！请稍后重试');

    }

    public function programMenu(){
        $menu = [
            '用户端首页'   => 'make_speed/router/router',
            '服务端首页'   => 'make_rider/auth/auth',
            '个人中心'      => '/make_speed/info/info',
            '优惠券列表'    => '/make_speed/coupons/coupons',
            '我的钱包'      => '/make_speed/my_money/my_money',
            '订单列表'      => '/make_speed/order_list/order_list',
            '邀请好友奖励'   => '/make_speed/activity/activity',
            '大客户中心'     => '/make_speed/big_customer/info/info',
            '帮我送'        => '/make_speed/router/router?type=0',
            '帮我买'        => '/make_speed/router/router?type=1',
            '万能服务'      => '/make_speed/router/router?type=2',
            '帮我代驾'     => '/make_speed/router/router?type=3',
            '货运'        => '/make_speed/router/router?type=4',
        ];

        return $this->view->fetch('',[
            'programMenu'   => $menu
        ]);
    }

    public function programtwo(Request $request){
        if( $request->isAjax() ){
            $params = $request->param('row/a');
            dump($params);die;
        }
    }

    /**
     * 生成小程序码
     */
    public function createSmallProgramImg(){

        if( $this->request->isAjax() ){
            $page = $this->request->param('url');
            $type = $this->request->param('type');
            $key  = ['help_send_img','help_buy_img','all_service_img','sub_driver_img','freight_img'];

            $url  = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".get_access_token($GLOBALS['uniacid']);
            $data = [
                'path' => $page.'?type='.$type
            ];
            $data = json_encode($data);
            $res = setRequest($url,$data);

            $rootPath = ROOT_PATH . 'public';
            $dir      = '/qrcode/admincode/';
            $saveName = $type.$GLOBALS['uniacid']. ".png";
            if (!is_dir($rootPath.$dir)) {
                mkdir($rootPath.$dir, 0777, true);
            }
            $fileName = $dir.$saveName;
            $re = file_put_contents($rootPath.$dir.$saveName, $res);
            if( $re ){
                $saveData = [ $key[$type] => $fileName];
                (new \app\admin\model\Setting)->saveValue($saveData);

                return $this->success('生成成功','','/addons/make_speed/core/public'.$fileName);
            }
            return $this->error('生成失败');
        }
    }

    /**
     * 订单配置
     */
    public function order(){
        if( $this->request->isAjax() ){
            $row = $this->request->param('row/a');
            $row['rider_wages']            = !empty($row['rider_wages']) ? sprintf('%.2f', $row['rider_wages']*1/100) : '';
            $row['user_gral']              = !empty($row['user_gral'])   ? sprintf('%.2f', $row['user_gral']*1/100) : '';
            $row['user_grow']              = !empty($row['user_grow'])   ? sprintf('%.2f', $row['user_grow']*1/100) : '';
            $re    = (new \app\admin\model\Setting)->saveValue($row);

            return !empty($re) ? $this->success('保存成功') : $this->error('保存失败');

        }
    }

}
