<?php

/***********************************************************************/

/*
 *
 *	后台主要扩展配置
 *
 */

return [

    //公众号级别，普通订阅号1，普通服务号2，认证订阅号3，认证服务号4
    'account_level' => [
        1 => '普通订阅号',
        2 => '普通服务号',
        3 => '认证订阅号',
        4 => '认证服务号',
    ],

    //文件上传路径
    'upload_path'   => ROOT_PATH . 'public/uploads/',

    //文件上传URL
    'upload_url'    => '/addons/make_speed/core/public/uploads/',


];