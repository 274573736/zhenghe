<?php


namespace app\apis\server;
use app\apis\exception\ParamException;
use app\apis\model\Setting;
use app\apis\server\Token;

class Map
{
    private   $turl = 'https://apis.map.qq.com/ws/';
    private   $tkey ;

    public function __construct(){
        $this->tkey = Setting::getVar('tencent_key');
    }

    /*
     * 腾讯地图api一对多计算距离
     * @params string $from 起点坐标
     * @params string $to   终点坐标
     * return  int          返回距离单位为km
     */
    public  function getDistance($from,$to){
        $query = [
            'mode' => 'walking',
            'key'  => $this->tkey,
            'from' => $from,
            'to'   => $to,
        ];
        $query = http_build_query($query);
        $url   = $this->turl.'distance/v1/?'.$query;

        $result = setRequest($url);
        $result = json_decode($result,true);
        if($result['status'] != 0){
            throw new ParamException(['msg'=>$result['message']]);
        }
        return  $result['result']['elements'][0]['distance']/1000;
    }
}