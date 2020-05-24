<?php
namespace Server\app;

class SendSMS
{

    /**
     * @param $mobile
     * @return bool
     */
    public static function send($mobile){
        if( self::getCode($mobile) )
        {
            $expireTime = getRedis()->ttl('next_sms:'.$mobile);
            if($expireTime > 0){
                msg('距离下次发送还有'.$expireTime.'秒');
            }
        }

        $randCode = mt_rand(1000, 9999);
        $sms      = send_aliyun_sms($mobile, array('code'=>$randCode));
        if(empty($sms['Code']) || strtolower($sms['Code'])!=='ok')
        {
            $msg = !empty($sms['Message']) ? $sms['Message'] : '短信发送失败!';
            msg(0,$msg);
        }

        return self::saveCacheSMS($mobile,$randCode);
    }


    /**
     * 缓存手机号验证码
     * @param $mobile
     * @param $code
     * @return bool
     */
    public static function saveCacheSMS($mobile,$code){
        $expireTime = msetting('sms_expire_time');
        $nextTime   = msetting('next_sms');
        getRedis()->setex('next_sms:'.$mobile,$nextTime,$code);
        getRedis()->setex('sms:'.$mobile,$expireTime,$code);

        return true;
    }


    public static function getCode($mobile){
        $key   = 'sms:'.$mobile;
        $code  = getRedis()->get($key);
        return $code ? $code : false;
    }



}