<?php

defined('IN_IA') or exit('Access Denied');
require "autoload.php";
use Mclass\Loader;

function loader() {
    $loader = Loader::instance();
    return $loader;
}

function msg($msg='',$data='',$code=0){
    $params = [
        'data'    => $data,
        'errno'   => $code,
        'message' => $msg,
    ];
    exit(json_encode($params));
}
/**
 * 浏览器友好的变量输出
 * @access public
 * @param  mixed       $var   变量
 * @param  boolean     $echo  是否输出(默认为 true，为 false 则返回输出字符串)
 * @param  string|null $label 标签(默认为空)
 * @param  integer     $flags htmlspecialchars 的标志
 * @return null|string
 */
function dump($var, $echo = true, $label = null, $flags = ENT_SUBSTITUTE)
{
    $label = (null === $label) ? '' : rtrim($label) . ':';

    ob_start();
    var_dump($var);
    $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', ob_get_clean()); //得到当前缓冲区的内容并删除当前输出缓。

    if (PHP_SAPI == 'cli') {
        $output = PHP_EOL . $label . $output . PHP_EOL;
    } else {
        if (!extension_loaded('xdebug')) {
            $output = htmlspecialchars($output, $flags);
        }

        $output = '<pre>' . $label . $output . '</pre>';
    }

    if ($echo) {
        echo($output);
        return;
    }

    return $output;
}

/**
 * 设置全局uniacid
 */
function setUniacid(){
    global $_W;
    $speedUniacid = pdo_getcolumn('make_speed_setting',array('key'=>'rider_uniacid','value'=>$_W['uniacid']),'uniacid');
    if(!$speedUniacid)
        msg('未与用户端小程序绑定');

    if($speedUniacid == $_W['uniacid']){
        msg('与用户端小程序绑定有误');
    }
    $GLOBALS['uniacid'] = $speedUniacid;
}

function  getRedis(){
    $redis = Mclass\GetRedis::instance();
    return $redis;
}

function msetting($key){
    $config = require_once  'config.php';
    return isset($config[$key]) ? $config[$key] : null;
}