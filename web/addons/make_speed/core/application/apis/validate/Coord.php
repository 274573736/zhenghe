<?php


namespace app\apis\validate;


class Coord extends BaseValidate
{
    protected $rule = [
        'fromcoord' => 'require|isNotEmpty|checkCoord',
        'tocoord'   => 'require|isNotEmpty|checkCoord',
    ];

    protected $message = [
        'fromcoord' => '起点坐标不能为空',
        'tocoord'   => '终点坐标不能为空'
    ];



}
