<?php
namespace Server\rider;

class RiderType{

    public $where = [];

    public function __construct($rider_id = 0){
        !$rider_id && $rider_id = $GLOBALS['CURRENT_RIDER'];
        $this->where = [ 'rider_id' => $rider_id  ];
    }

    /**
     * 是否代驾司机
     */
    public function isDriver(){
        $re = pdo_get('make_speed_rider_driver',array_merge($this->where,[ 'status' => 2] ),['id']);
        return $re ? $re : false;
    }

    /**
     * 是否货运司机
     */
    public function isFreightDriver(){
        if (pdo_tableexists('make_speed_rider_fdriver')) {
            $re = pdo_get('make_speed_rider_fdriver',array_merge($this->where,['status' => 1]),['id','car_id']);

            return $re ? $re : false;
        }
        return false;
    }

    /**
     * 是否技师
     */
    public function isTechnician(){
        if (pdo_tableexists('make_speed_homemaking_technician')) {
            $re  = pdo_get('make_speed_homemaking_technician',array_merge($this->where,['status' => 2]),['id','category_id']);
            return $re ? $re : false;
        }
        return false;
    }

}