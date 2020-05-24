<?php

namespace app\admin\controller\person;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Riderwithdraw extends Backend
{
    
    /**
     * Withdraw模型对象
     * @var \app\admin\model\rider\Withdraw
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\rider\Withdraw;

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

        //当前是否为关联查询
        $this->relationSearch = true;

        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with(['rider'=>function($query){
                    if(!empty($GLOBALS['city_id'])){
                        $query->where(['city_id'=>$GLOBALS['city_id']]);
                    }
                }])
                ->where($where)
                ->where(['withdraw.uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['rider'=>function($query){
                    if(!empty($GLOBALS['city_id'])){
                        $query->where(['city_id'=>$GLOBALS['city_id']]);
                    }
                }])
                ->where($where)
                ->where(['withdraw.uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {
                $row->visible(['id','type','tx_type','trade_code','money','status','description','add_time','ridername','ridermobile']);
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
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
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
            $result = $row->toArray();

            //已操作
            if($result['status']!=0)
                $this->error('此记录已处理，请勿重复操作。');

            //审核通过打款
            if($params['status']==2 && $result['type']==2){
                //支付配置参数
                $certPath = ROOT_PATH . 'vendor/'.uniqid().'.pem';
                $keyPath  = ROOT_PATH . 'vendor/'.uniqid().'k.pem';

                $pay_param = getCertKey($certPath, $keyPath);

                if(!empty($pay_param) && !empty($pay_param[0])){
                    $this->error($pay_param[1]);
                }

                //引入付款类库
                Vendor('Weixin.Wxpay');
                $wxpay = new \Wxpay();
                $wxpay->setConfig(array(
                    // 微信公众号开发接口appid
                    'appid' => $pay_param['appid'],

                    // 微信支付商户号ID
                    'mchid' => $pay_param['mchid'],

                    // 微信支付开发接口appsecret
                    'appsecret'	=> $pay_param['signkey'],

                    // 微信支付所签发的商户证书，请指定证书的完整物理路径
                    'ssl_mch_cert' => $certPath,

                    // 商户私钥，请指定证书的完整物理路径
                    'ssl_mch_key' => $keyPath
                ));

                $existo = $wxpay->getTransferByWallet($result['trade_code']);
                if(strtolower($existo['result_code']) == 'success')
                    $this->error('该订单流水号已存在处理！');

                $data = array(
                    'partner_trade_no'	=> $result['trade_code'],
                    'openid'			=> $result['open_id'],
                    'amount'			=> $result['money'],
                    'desc'				=> $params['description'],
                    'check_name'        => 'NO_CHECK'
                );
                $withdraw = $wxpay->setTransferToWallet($data);

                is_file($certPath) && unlink($certPath);
                is_file($keyPath)  && unlink($keyPath);

                if(empty($withdraw) || !is_array($withdraw))
                    $this->error('系统异常，请稍后重试！');

                if(strtolower($withdraw['return_code']) != 'success'){
                    $withdraw['return_msg'] = !empty($withdraw['return_msg']) ? $withdraw['return_msg'] : '出现未知错误！';
                    $this->error($withdraw['return_msg']);
                }

                if(strtolower($withdraw['result_code']) != 'success')
                    $this->error($withdraw['err_code_des']);

            }

            $up = db('rider_withdraw')->where('id',$result['id'])->setField('status', $params['status']);

            //审核更新
            if(!empty($up)){

                Db::name('rider')->where('id', $result['rider_id'])->setDec('invalid_money', $result['money']);

                Db::name('rider_cashlog')->where(array('order_code'=>$result['trade_code'],'rider_id'=>$result['rider_id']))->update(['status'=>2]);

                //如果审核不通过未打款,返还用户积分
                if($params['status']==1 && empty($result['tx_type'])) {
                    Db::name('rider')->where('id', $result['rider_id'])->setInc('valid_money', $result['money']);
                    addRiderCashLog($result['rider_id'],$result['money'],'提现驳回',1,2);
                }else if($params['status']==1 && $result['tx_type']==1){
                    Db::name('rider')->where('id', $result['rider_id'])->setInc('bond_money', $result['money']);
                    addRiderCashLog($result['rider_id'],$result['money'],'保证金提现驳回',1,2);
                }

                $msg    = ($params['status']==2) ? '已通过,并退款' : '未通过';
                $this->success('操作成功！审核'.$msg.'！');
            }

            $this->error('状态无变动或更新失败！');
        }

        $this->view->assign('statusList',$this->model->getStatusList());

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
                if($v->status < 1){
                    $this->error('提现申请尚未处理，无法删除');
                }

                $count += $v->delete();
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

}
