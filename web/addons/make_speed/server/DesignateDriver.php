<?php
namespace server;


class DesignateDriver
{
    /**
     * 呼叫司机
     * @param $address  array   订单地址
     * @param $id       int     订单ID
     */
    public function callDriver($address,$id){
        $drivers = $this->getScopeDriver($address);
        try{
            include MODULE_ROOT .'/wokerman/vendor/autoload.php';
            \GatewayWorker\Lib\Gateway::$registerAddress = '127.0.0.1:1238';
            \GatewayWorker\Lib\Gateway::sendToUid($drivers,json_encode( ['order_id' => $id,'type'=>'new_order']) );
            \GatewayWorker\Lib\Gateway::sendToUid('uniacid'.$GLOBALS['uniacid'], $id);
        }catch(\Exception $e){
            msg($e->getMessage());
        }

    }

    /**
     * 获取附近司机
     * @param $address
     * @return string
     */
    public function getScopeDriver($address){
        $distance = pdo_get('make_speed_setting',array('key'=>'rider_distance','uniacid'=>$GLOBALS['uniacid']),array('value'));

        $distance['value'] = !empty($distance['value']) ? intval($distance['value']) : 10;

        $scope = getPointDistance($address['begin_lng'], $address['begin_lat'], $distance['value']);

        $where = array(
            'i.lat >=' => $scope['minlat'],
            'i.lat <=' => $scope['maxlat'],
            'i.lng >=' => $scope['minlng'],
            'i.lng <=' => $scope['maxlng']
        );

        //听单状态
        $where['i.is_accept'] = 1;
        $where['i.uniacid']   = $GLOBALS['uniacid'];

        $query  = load()->object('query');
        $rider  = $query->from('make_speed_rider_driver', 'd')
                ->select("i.rider_id")
                ->innerjoin('make_speed_rider_info', 'i')
                ->on('d.rider_id','i.rider_id')
                ->where($where)
                ->getall();

        if(empty($rider))
            return '';

        $rider =  array_column($rider,'rider_id');

        return $rider;
    }

}