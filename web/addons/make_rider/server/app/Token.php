<?php
namespace Server\app;
use Mclass\Request;

class Token{
    public static function generateToken(){
        $randChar = random(30);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = msetting('salt');
        return md5($randChar . $timestamp . $salt);
    }

    public static function getCurrentRid()
    {
        $rider_id = self::getCurrentTokenVar('rid');
        return $rider_id;
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars  = getRedis()->get($token);

        if (!$vars) {
            msg('token无效','',1001);
        } else {
            $expire_time = msetting('token_expire_time');
            getRedis()->expire($token,$expire_time);

            $vars = json_decode($vars, true);

            if( is_array($key) ){
                return $vars;
            }else{
                if (array_key_exists($key, $vars)) {
                    return $vars[$key];
                }
            }

           msg('获取token变量不存在！');
        }
    }

    public static function refreshToken(){
        $token = Request::instance()->header('token');
        $info = self::exist($token);
        if($info){

            $cacheValue = [
                'mobile'    => $info['mobile'],
                'rid'       => $info['rid'],
            ];
            $expire_time = msetting('token_expire_time');
            $saveValue  = getRedis()->setex( $token,$expire_time,json_encode($cacheValue) );
            if($saveValue){
                msg('success');
            }
        }
        msg('token无效','',1001);
    }

    public static function exist($token){
        $val = getRedis()->get($token);
        if($val){
            return  true;
        }
        return false;
    }

}