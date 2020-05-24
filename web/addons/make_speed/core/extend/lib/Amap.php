<?php
namespace lib;

class Amap
{
    /**
     * 添加终端
     * @param  array $data ['key'=>xx,'name'=>xx,'sid'=>xx]
     * @return array
     */
    public static function addTerminal($data){
        $url = "https://tsapi.amap.com/v1/track/terminal/add";
        $re = setRequest($url,http_build_query($data));
        $re = json_decode($re,true);
        return $re;
    }
    public static function terminalList($key,$sid){
        $url = 'https://tsapi.amap.com/v1/track/terminal/list?sid='.$sid.'&key='.$key.'';
        $re = setRequest($url);
        $re = json_decode($re,true);
        return $re;
    }

    /**
     * 生成ServiceID
     * @param $data ['key'=>$key,'name'=>'代驾司机']
     * @return array
     */
    public static function addServiceID($data){
        $url = "https://tsapi.amap.com/v1/track/service/add";
        $re = setRequest($url,http_build_query( $data) );
        $re = json_decode($re,true);
        return $re;
    }

    /**
     * 搜索轨迹
     * @param $data
     * @return mixed
     */
    public static function trsearch($data){
        $url = "https://tsapi.amap.com/v1/track/terminal/trsearch?".http_build_query($data);
        $re = setRequest($url);
        $re = json_decode($re,true);
        return $re;
    }
}