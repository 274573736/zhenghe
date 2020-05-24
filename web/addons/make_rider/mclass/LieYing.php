<?php


namespace Mclass;

class LieYing
{

    /**
     * 生成轨迹
     * @param  $tid 终端ID
     * @return string 轨迹iD
     */
    public static function addTrack($tid){
        $amap_driver_key = pdo_get('make_speed_setting',['key'=>'amap_driver_key','uniacid'=>$GLOBALS['uniacid'] ],['value'] );
        $amap_service_id = pdo_get('make_speed_setting',['key'=>'amap_service_id','uniacid'=>$GLOBALS['uniacid'] ],['value'] );
        if(!$amap_driver_key){
            msg('代驾地图key未配置');
        }elseif (!$amap_service_id){
            msg('服务ID未生成');
        }

        $data = [
            'key'  => $amap_driver_key['value'],
            'sid'  => $amap_service_id['value'],
            'tid'  => $tid,
        ];
        load()->function('communication');
        $url  = 'https://tsapi.amap.com/v1/track/trace/add';
        $data = http_build_query($data);
        $re   = ihttp_request($url, $data);
        $re   = json_decode($re['content'],true);
        if( (int)$re['errcode'] != 10000){
            $msg = isset($re['errdetail']) ? $re['errdetail'] : $re['errmsg'];
            msg($msg);
        }
        if(!isset($re['data']['trid'])){
            msg('获取轨迹ID异常,抢单失败');
        }
        return $re['data']['trid'];
    }

    /**
     * 上传轨迹
     * @param $data array
     * @return bool
     */
    public function upload_point($data){
        load()->func('communication');
        $url  = 'https://tsapi.amap.com/v1/track/point/upload';
        $re   = ihttp_request($url,http_build_query($data));
        $re   = json_decode( $re['content'] ,true);

        if( $re['errcode'] != 10000 && $re['errcode'] != 20100){
            msg(isset($re['errdetail']) ? $re['errdetail'] : $re['errmsg']);
        }
        return true;
    }

    /**
     * 查询轨迹
     * @param  $data array
     * @param  $distance
     * @return mixed
     */
    public function trSearch($data,$distance = true){
        load()->func('communication');
        $url  = "https://tsapi.amap.com/v1/track/terminal/trsearch?".http_build_query($data);
        $re   = ihttp_get($url);
        $re   = json_decode( $re['content'] ,true);
        if($re['errcode'] != 10000){
            msg(isset($re['errdetail']) ? $re['errdetail'] : $re['errmsg']);
        }
        if($distance){
            if(isset($re['data']['tracks'][0]['distance'])){
                return $re['data']['tracks'][0]['distance'];
            }
            return 0;
        }
        return $re;
    }

}