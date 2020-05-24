<?php


namespace app\apis\controller\v2;

use app\apis\validate\TokenGet;
use app\apis\server\Token as AppToken;
use app\apis\exception\ParamException;
use think\Cache;

class Token
{

    /**
     * 获取令牌
     * @url /get_token?
     * @POST token=:token appid = :appid
     */
    public function getToken($token='',$appid='')
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
        (new TokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($token,$appid);
        return [
            'token' => $token
        ];
    }



    /*
     * 查看令牌是否存在
     * @params string $token
     * @return array
     */
    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParamException([
                'msg' =>'token不允许为空'
            ]);
        }
        $exist   = Cache::get($token);
        $isValid = false;
        if($exist){
            $isValid = true;
        }
        return ['isValid' => $isValid];
    }
}