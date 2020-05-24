<?php


namespace Server;
use Model\Config;

class PushOrderType{
    public static function getTechnician($order_id){

        $address = pdo_get('make_speed_order_address',array('order_id'=>$order_id),array('begin_lat','begin_lng'));

        if(empty($address) || empty($address['begin_lat']) || empty($address['begin_lng']))
            return '';
        $distance = Config::get('rider_distance');

        $distance = !empty($distance) ? intval($distance) : 50;
        $scope = getPointDistance($address['begin_lng'], $address['begin_lat'], $distance);
        $category = pdo_get('make_speed_order',['id' => $order_id],['category_id']);

        $field  = 'i.rider_id';
        $where  = "i.lat >=:minlat AND i.lat <=:maxlat AND i.lng >=:minlng AND i.lng <=:maxlng AND ";
        $where .= "FIND_IN_SET(:cate,d.category_id) AND d.uniacid = :uniacid AND i.is_accept = :is_accept AND d.status = :status";

        $sql    = "SELECT $field FROM ".tablename('make_speed_rider_info')." AS i INNER JOIN ".tablename('make_speed_homemaking_technician')." AS d ON i.rider_id = d.rider_id WHERE $where";
        $params = [
            ':cate'     => $category['category_id'],
            ':uniacid'  => $GLOBALS['uniacid'],
            ':is_accept'=> 1,
            ':status'   => 2,
            ':minlat'   => $scope['minlat'],
            ':maxlat'   => $scope['maxlat'],
            ':minlng'   => $scope['minlng'],
            ':maxlng'   => $scope['maxlng'],
        ];
        $technician  = pdo_fetchall($sql, $params);

        if(empty($technician))
            return '';

        $technician = implode(',', array_column($technician,'rider_id'));

        return $technician;
    }
}