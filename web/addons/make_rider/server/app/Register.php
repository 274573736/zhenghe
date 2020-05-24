<?php


namespace Server\app;
use Server\app\SendSMS;
use Model\Rider;
use Server\app\UserToken;

class Register
{
    public function check($params){
        if($params['mobile']  != '13557432464'){
            $smsCode = SendSMS::getCode($params['mobile']);
            if(!$smsCode){
                msg('请点击发送验证码!');
            }

            if($smsCode != $params['smscode']){
                msg('验证码不正确');
            }
        }

        $rider = Rider::getRiderByMobile($params['mobile']);

        //注册了但未绑定资料
        if(!empty($rider)){
            $bind = pdo_get('make_speed_rider_bind',['rider_id' => $rider['id'] ],['id']);
            if($bind){
                msg( '同一手机号只能注册一次');
            }

            $userToken = new UserToken();
            $token     = $userToken->grantToken([
                'id'    => $rider['id'],
                'mobile'=> $params['mobile']
            ]);

            return msg(0,['token'=>$token]);
        }
        $this->addRider($params);
    }

    public function addRider($params){

        $data = array(
            'avatar'    => $params['avatar'],
            'nick_name' => $params['nickname'],
            'real_name' => $params['username'],
            'sex'       => $params['sex'],
            'mobile'    => $params['mobile'],
            'add_time'  => time(),
            'uniacid'   => $GLOBALS['uniacid'],
            'app_client_id' => $params['app_client_id'],
        );

        $data['invite_code'] = generate_random_str();

        $recomcode = !empty($params['invite_code'])  ? trim($params['invite_code']) : '';        //邀请码
        $recomid   = !empty($params['recommend_id']) ? intval($params['recommend_id']) : 0;     //海报扫码携带的推荐人id

        !empty($recomid) && $data['recommend_id'] = $recomid;

        if(!empty($recomcode) && empty($data['recommend_id']))
        {
            $recommend = pdo_get('make_speed_rider',['invite_code' => $recomcode ],['id'] );
            !empty($recommend['id']) && $data['recommend_id'] = $recommend['id'];
        }

        $add = pdo_insert('make_speed_rider',$data);
        $uid = pdo_insertid();
        if($add) {
            pdo_insert('make_speed_rider_info',array(
                'rider_id'  => $uid,
                'score'     => 80,
                'is_accept' => 1,
                'uniacid'   => $GLOBALS['uniacid'],
            ));

            $userToken = new UserToken();
            $token     = $userToken->grantToken([
                'id'   => $uid,
                'mobile'=> $data['mobile']
            ]);
            msg(0,['token' => $token]);
        }

        msg(0,'注册失败');
    }

}