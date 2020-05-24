<?php
namespace Model;
use Model\Base;
defined('IN_IA') or exit('Access Denied');


class Config extends Base
{
    private static $table = 'make_speed_setting';
    public  function __construct(){
        parent::__construct();
    }

    /**
     * 读取配置
     * @param $key string
     * @return string|bool
     */
    public static function get($key){
        $config = pdo_get(self::$table,['key'=>$key,'uniacid' => $GLOBALS['uniacid'] ],['value']);
        return $config ? $config['value'] : false;
    }

    public static function getm($key){
        $config = pdo_getall(self::$table,['key'=>$key,'uniacid' => $GLOBALS['uniacid'] ],['value','key']);
        if( is_array($key) ){
            return $config ? array_column($config,'value','key') : false;
        }
        return false;
    }

}