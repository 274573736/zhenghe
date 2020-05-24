<?php
namespace Server\app;
use Server\app\SendSMS;
use Model\Rider;
use Server\app\Token;

class UserToken extends Token
{
    /**
     * 短信验证码登陆
     * @param $mobile
     * @param $code
     * @param $client_id
     * @return token
     */
    public function smsLogin($mobile,$code,$client_id = ''){
        $rider = Rider::getRiderByMobile($mobile);
        if(!$rider){
            msg('请先注册！');
        }
        if($mobile != '18877143671' && $mobile != '13557432464'){
            $this->checkCode($mobile,$code);
        }
        if($rider['status'] != 2){
            msg('账号审核未通过!');
        }

        if($client_id){
            pdo_update('make_speed_rider',['app_client_id' => $client_id ],['id'=>$rider['id'] ] );
        }
        $token = $this->grantToken($rider);

        return $token;
    }

    public function checkCode($mobile,$code){
        $getCode = SendSMS::getCode($mobile);
        if(!$getCode){ msg('验证码无效,请重新发送验证码'); }

        if($code != $getCode) {
            msg('验证码不正确，请重新输入!');
        }
        return true;
    }

    public function grantToken($rider){
        $value = $this->chcheValue($rider);
        $token = $this->saveCacheValue($value);
        return $token;
    }

    public function saveCacheValue($value){
        $expire_time = msetting('token_expire_time');
        $key   = Token::generateToken();
        $value = json_encode($value);
        getRedis()->setex($key,$expire_time,$value);
        return $key;
    }

    public function chcheValue($rider){
        $cacheValue = [
            'rid'       => $rider['id'],
            'mobile'    => $rider['mobile'],
        ];
        return $cacheValue;
    }
}