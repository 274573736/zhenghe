<?php
namespace Server;
defined('IN_IA') or exit('Access Denied');

use Model\Config;
use Mclass\DateTools;
use Mclass\LieYing;
use Mclass\GetRedis;


class DesignateDriver
{

    /**
     * 获取司机经纬度坐标点
     * @param $lng
     * @param $lat
     * @param $rider_id
     * @return json对象坐标
     */
    public function getCoord($rider_id,$lng='',$lat=''){
        $redis = GetRedis::instance();
        $coord = $redis->lRange('d'.$rider_id,0,-1);
        if($coord){
            $coord = array_slice($coord,0,90);
        }
        if($lng && $lat){
            $point = [
                'location'   => $lng.','.$lat,
                'locatetime' => DateTools::msecTime(),
            ];
            $point = json_encode($point);
            array_push($coord,$point);
        }
        if(!$coord){
            msg('','nullcoord');
        }

        array_walk($coord,function(&$value){
            $value = json_decode($value,true);
        });
        $coord = json_encode($coord);
        return $coord;
    }

    /**
     * 上传轨迹点并返回距离   上传完后删除之前的坐标
     * @param $order_id  int   订单ID
     * @param coord      json  坐标
     * @return int
     */
    public  function uploadCoord($order_id,$coord){
        if(!$coord){
            return false;
        }

        $riderID  = $GLOBALS['CURRENT_RIDER'];

        $rider = pdo_get('make_speed_rider_driver',['rider_id' => $riderID ],['rider_id','tid']);

        $trid  = pdo_get('make_speed_order_rider',['rider_id'=> $riderID ,'order_id' => $order_id],['trid','get_msec_time']);

        if(!$trid){ msg('未查询到进行中订单！','nul'); }

        $keys = ['amap_driver_key','amap_service_id'];
        $setting   = Config::getm($keys);
        if( !isset( $setting['amap_driver_key'] ) || !isset( $setting['amap_service_id'] ) ){
             msg('高德地图key未配置或服务ID未生成！');
        }

        $postData = [
            'key'    => $setting['amap_driver_key'],
            'sid'    => $setting['amap_service_id'],
            'tid'    => $rider['tid'],
            'trid'   => $trid['trid'],
            'points' => $coord,
        ];

        $lieying  = new LieYing();
        $lieying->upload_point($postData);

        $redis = GetRedis::instance();
        $redis->del('d'.$riderID);
        return true;
    }


    public function getTrackDistance($order_id){
        $riderID  = $GLOBALS['CURRENT_RIDER'];

        $rider = pdo_get('make_speed_rider_driver',['rider_id' => $riderID ],['rider_id','tid']);


        $trid  = pdo_get('make_speed_order_rider',['rider_id'=> $riderID ,'order_id' => $order_id],['trid','get_msec_time']);
        if(!$trid){ msg('未查询到进行中订单！');}

        $keys = ['amap_driver_key','amap_service_id'];
        $setting   = Config::getm($keys);
        if( !isset( $setting['amap_driver_key'] ) || !isset( $setting['amap_service_id'] ) ){
            msg('高德地图key未配置或服务ID未生成！');
        }

        $searchData = [
            'key'       => $setting['amap_driver_key'],
            'sid'       => $setting['amap_service_id'],
            'tid'       => $rider['tid'],
            'trid'      => $trid['trid'],
            'ispoints'  => 0,

            'denoise'   => 1,
            'mapmatch'  => 1,
            'attribute' => 1,
            'rthreshold'=> 100,
            'mode'      => 'driving',
            'recoup'    => 1,
        ];
        if( !empty($trid['get_msec_time']) ){
            array_push($searchData,[ 'starttime' => $trid['get_msec_time'],'endtime'   => DateTools::msecTime() ]);
        }
        $lieying  = new LieYing();

        $distance = $lieying->trSearch($searchData);
        return sprintf("%.2f",floatval($distance/1000) );
    }


    /**
     * 代驾司机送达
     * @param $lng
     * @param $lat
     * @param $id    int  订单id
     */
    public function deliveryOrder($lng,$lat,$id){
        if(!$lng || !$lat){
            msg('经纬度不能为空');
        }
        $riderID  = $GLOBALS['CURRENT_RIDER'];
        $coord    = $this->getCoord($riderID,$lng,$lat);
                    $this->uploadCoord($id,$coord);
        $distance = $this->getTrackDistance($id);
        loader()->func('Driver');
        $price    = countDestDriverPrice($distance);

        $price['status'] = 0;
        $re = pdo_update('make_speed_order',$price,['id' => $id]);
        if(!$re){
            msg('更新实时订单计费异常！');
        }

        pdo_update('make_speed_order_rider',['goto_time'=>time(),'goto_msec_time'=> DateTools::msecTime()],['order_id' => $id]);

        //完成后删除缓存
        $redis = GetRedis::instance();
        $key   = ['driver'.$riderID,'d'.$riderID];
        $redis->del($key);
        try{
            @\Server\Gateway::$registerAddress = '127.0.0.1:1238';
            @\Server\Gateway::sendToUid('order'.$id,json_encode( ['price' => $price,'type'=>'pay']));
        }catch (Exception $e){

        }

    }


}




