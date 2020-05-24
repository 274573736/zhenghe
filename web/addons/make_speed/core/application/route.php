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
use think\Route;
// 注册路由到index模块的News控制器的read操作

Route::rule('apis/:version/get_rider','apis/:version.Index/getrider');
Route::rule('apis/:version/get_price','apis/:version.Index/getprice');
Route::rule('apis/:version/generate_order','apis/:version.Index/generateorder');
Route::rule('apis/:version/order_status','apis/:version.Index/orderstatus');
Route::rule('apis/:version/add_order','apis/:version.Index/addorder');
Route::rule('apis/:version/update_order','apis/:version.Index/updateorder');
Route::rule('apis/:version/order_detail','apis/:version.Index/orderdetail');


Route::rule('apis/v2/test','apis/v2.Index/index');


Route::post('apis/:version/get_token','apis/:version.Token/getToken');
Route::post('apis/:version/verify_token','apis/:version.Token/verifyToken');
Route::post('apis/:version/create_order','apis/:version.Order/createOrder');
Route::get('apis/:version/get_delivery_price','apis/:version.Order/getDeliveryPrice');
Route::post('apis/:version/update_order_status','apis/:version.Order/updateOrderStatus');
Route::post('apis/:version/get_order_status','apis/:version.Order/getOrderStatus');
Route::post('apis/:version/get_order_detail','apis/:version.Order/getOrderDetail');


/**
 * 微擎app
 */
Route::rule([
    'api/:version/send_sms/:mobile' => ['api/:version.common/sendsms',[],['mobile'=>'\d+'] ],
]);
















