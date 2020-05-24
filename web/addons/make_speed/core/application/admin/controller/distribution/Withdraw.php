<?php

namespace app\admin\controller\distribution;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Withdraw extends Backend
{
    
    /**
     * Withdraw模型对象
     * @var \app\admin\model\distribution\Withdraw
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\distribution\Withdraw;
        $this->view->assign([
            "typeList"   => $this->model->getTypeList(),
            'statusList' => $this->model->getStatisList(),
        ]);
    }

    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['distributor'])
                    ->where( ['uniacid'=>$GLOBALS['uniacid'] ])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['distributor'])
                    ->where( ['uniacid'=>$GLOBALS['uniacid'] ])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();


            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

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
            if($row->status == 3){
                return $this->error('改订单已退还提现金额！');
            }
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    Db::startTrans();

                    //审核失败
                    $inc = $dec = true;
                    if( $params['status'] == 3 ){
                        $amount = sprintf("%.2f",$row->amount + $row->server_charge);
                        $inc = Db::name('distribution_distributor')->where('id', $row->did)->setInc('commission', $amount );
                        $dec = Db::name('distribution_distributor')->where('id', $row->did)->setDec('pay_commission', $amount );
                    }

                    $result = $row->allowField(true)->save($params);

                    //审核通过打款
                    if($params['status']== 2 && $row->type == 1 && $params['wx_type'] != 1){
                        //支付配置参数
                        $certPath = ROOT_PATH . 'vendor/'.uniqid().'.pem';
                        $keyPath  = ROOT_PATH . 'vendor/'.uniqid().'k.pem';

                        $pay_param = getCertKey($certPath, $keyPath,true);
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

                        $existo = $wxpay->getTransferByWallet($row->order_num);
                        if(strtolower($existo['result_code']) == 'success')
                            $this->error('该订单流水号已存在处理！');

                        $data = array(
                            'partner_trade_no'	=> $row->order_num,
                            'openid'			=> $row->open_id,
                            'amount'			=> $row->amount,
                            'desc'				=> '后台分销打款',
                            'check_name'        => 'NO_CHECK'
                        );
                        $withdraw = $wxpay->setTransferToWallet($data);

                        is_file($certPath) && unlink($certPath);
                        is_file($keyPath)  && unlink($keyPath);

                        if( empty($withdraw) || !is_array($withdraw) ){
                            Db::rollback();
                            $this->error('系统异常，请稍后重试！');
                        }
                        if(strtolower($withdraw['return_code']) != 'success'){
                            $withdraw['return_msg'] = !empty($withdraw['return_msg']) ? $withdraw['return_msg'] : '出现未知错误！';
                            Db::rollback();
                            $this->error($withdraw['return_msg']);
                        }

                        if(strtolower($withdraw['result_code']) != 'success'){
                            Db::rollback();
                            $this->error($withdraw['err_code_des']);
                        }
                    }

                    if ($result !== false ) {
                        Db::commit();
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

}
