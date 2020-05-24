<?php
namespace app\apis\server;

use app\apis\exception\TokenException;
use app\apis\model\Clouds;
use think\Cache;
use think\Request;

class Token
{
    public function get($token,$appid){
        $module = Clouds::getModuleByToken($token,$appid);
        $this->verifyModule($module);

        $value = [
            'uniacid'   => $module->uniacid,
            'id'        => $module->id,
        ];
        $token = $this->saveToCache($value);
        return $token;
    }

    /*
     * 验证对接模块token/授权域名
     */
    public function verifyModule($module){
        if(!$module){
            throw new TokenException([
                'msg'       => 'token或appid无效！请在模块对接管理查看!',
                'errorCode' => 10004
            ]);
        }elseif($module->domain){
            $request = Request::instance();
            $domain  = $request->domain();
            if($domain !== $module->domain){
                throw new TokenException([
                    'msg'       => '非法域名！',
                    'errorCode' => 10005
                ]);
            }
        }

    }

    public function saveToCache($value){
        $token       = self::generateToken();
        $expire_date = config('setting.token_expire');
        $result      = cache($token, json_encode($value), $expire_date);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10006
            ]);
        }
        return $token;
    }

    /**
     * 获取唯一标识
     * @return string
     */
    public static function generateToken()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /*
     * 获取指定缓存变量
     * @params string $key
     * return  staring|int
     */
    public static function getCurrentTokenVar($key = '')
    {
        $token = Request::instance()
            ->param('token');
        if(!$token){
            throw new TokenException(['msg'=>'Token不能为空!']);
        }

        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if(!is_array($vars)) {
                $vars = json_decode($vars, true);
            }

            if(empty($key)){
                return $vars;
            }


            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }else{
                throw new TokenException('尝试获取的Token变量并不存在');
            }
        }
    }


}