<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 判断是否安装FastAdmin
if (!is_file(APP_PATH . 'admin/command/Install/install.lock'))
{
    header("location: /addons/make_speed/core/public/install.php");
    exit;
}

//加载微擎引导文件
require '../../../../framework/bootstrap.inc.php';

//加载微擎后台登陆管理
require '../../../../web/common/bootstrap.sys.inc.php';


// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
