<?php


namespace Mclass;
use Model\Config;

class ScopePersonnel
{
    public static $distance;
    public function __construct()
    {
        $distance = Config::get('rider_distance');
        self::$distance = $distance ? $distance : 10;
    }


    public static function getRider($lat,$lng,$field='id')
    {
        $scope = getPointDistance($lat,$lng,self::$distance);

        $where = array(
            'i.lat >='    => $scope['minlat'],
            'i.lat <='    => $scope['maxlat'],
            'i.lng >='    => $scope['minlng'],
            'i.lng <='    => $scope['maxlng'],
            'i.is_accept' => 1,
            'r.uniacid'   => $GLOBALS['uniacid'],
            'r.status'    => 2,
        );

        $sfield = 'r.'.$field;
        $query = load()->object('query');
        $rider = $query->from('make_speed_rider', 'r')
            ->select($sfield)
            ->innerjoin('make_speed_rider_info', 'i')
            ->on('r.id', 'i.rider_id')
            ->where($where)
            ->getall();
        if(empty($rider))
            return [];

        $rider = array_filter(array_column($rider,$field) );

        return $rider;
    }


}