<?php


namespace Model;


class Rider
{
    private static $table = 'make_speed_rider';

    public static function getRiderByMobile($mobile){
        $re = pdo_get(self::$table,[ 'mobile' => $mobile,'uniacid'=>$GLOBALS['uniacid'] ]);
        return $re;
    }

}