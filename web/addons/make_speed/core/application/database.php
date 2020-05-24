<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Env;
include IA_ROOT.'/data/config.php';
global $_W;

return [
    'hostname'        => array_key_exists( 'master',$config['db'] )?  $config['db']['master']['host']       : $config['db']['host'],
    // 数据库名
    'database'        => array_key_exists( 'master',$config['db'] )?  $config['db']['master']['database']   : $config['db']['database'],
    // 用户名
    'username'        => array_key_exists( 'master',$config['db'] )?  $config['db']['master']['username']   : $config['db']['username'],
    // 密码
    'password'        => array_key_exists( 'master',$config['db'] )?  $config['db']['master']['password']   : $config['db']['password'],
    // 端口
    'hostport'        => array_key_exists( 'master',$config['db'] )?  $config['db']['master']['port']       : $config['db']['port'],
    // 连接dsn

   // 连接dsn
   'dsn'             => '',
   // 数据库连接参数
   'params'          => [],
   // 数据库编码默认采用utf8
   'charset'         => Env::get('database.charset', 'utf8'),
   // 数据库表前缀
   'prefix'          => $_W['config']['db']['tablepre'].'make_speed_',
    // 数据库调试模式
    'debug'           => Env::get('database.debug', true),
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式,默认为Y-m-d H:i:s
    'datetime_format' => false,
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
];
