<?php

namespace Mclass;


class DateTools
{
    //返回毫秒级时间戳
    public static function  msecTime(){
        list($usec, $sec) = explode(" ", microtime());
        $time = (float)sprintf('%.0f',(floatval($usec)+floatval($sec))*1000);
        return $time;
    }

}