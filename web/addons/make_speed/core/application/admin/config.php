<?php

//配置文件
return [
    'url_common_param'       => true,
    'url_html_suffix'        => '',
    'controller_auto_search' => true,


    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => 'app\admin\library\ExceptionHandler',

    'show_error_msg'         => true,
    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------
    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => ['error','notice','debug'],
        // error和sql日志单独记录
        'apart_level'   =>  ['error','debug'],
        'time_format'   => 'm-d H:i:s'
    ],
];
