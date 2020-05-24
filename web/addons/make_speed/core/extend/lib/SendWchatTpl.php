<?php

use think\Db;

class SendWchatTpl
{
    public  $sendUrl     = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=';

    public function getAccessToken($rider_uniacid = false){
        if($rider_uniacid){
            $rider = Db::name('setting')->where(['key' => 'rider_uniacid', 'uniacid' => $GLOBALS['uniacid']])->find();
            if (empty($rider) || empty($rider['value']))
                return array(1,'未绑定小程序');

            $uniacid  = $rider['value'];
        }else{
            $uniacid = $GLOBALS['uniacid'];
        }
        return get_access_token($uniacid);
    }

    //骑手or用户发送审核模板消息
    function sendRiderTemplate($data,$isRider = true){
        if( isset($data['user_id']) ){
            $openid = Db::name('rider')->where(['id' => $data['user_id']])->value('open_id');
        }else{
            $openid = Db::name('rider')->where(['id' => $data['id']])->value('open_id');
        }

        $tplID    = Db::name('setting')->where(['key'=>'audit_rider_tpl'])->value('value');
        $url      = $this->sendUrl.$this->getAccessToken($isRider);

        $sendData = array(
            'touser'        => $openid,
            'template_id'   => $tplID,
            'page'          => array_key_exists('page',$data) ? $data['page'] :'',
            'data'          => $data['data'],
        );

        $sendData = json_encode($sendData);
        $re       = setRequest($url, $sendData);
    }
}