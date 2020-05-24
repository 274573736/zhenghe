<?php
namespace Model;
defined('IN_IA') or exit('Access Denied');


class Base
{
    public static $W;

    public function __construct()
    {
//        global $_W;
//        self::$W    = $_W;
    }
    public function replaceImgUrl(&$array){
        $modelUrl = str_replace( 'make_speed_plugin_freight','make_speed',MODULE_URL);

        $array = str_replace('/uploads', $modelUrl.'core/public/uploads', $array);
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    $this->replaceImgUrl($array[$key]);
                }
            }
        }
        return $array;
    }
}