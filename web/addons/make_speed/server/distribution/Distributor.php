<?php


namespace Server\distribution;


class Distributor{

    public static function isDistributor(){
        $distribution = pdo_get('make_speed_distribution_distributor',['user_id'=>$GLOBALS['CURRENT_USER'],'status'=>1,'is_distributor'=>1],['id'] );
        if(!$distribution){
            return false;
        }
        return true;
    }

    public static function get_downline_list($list, $uid,$tier=2, $level = 1){
        static  $arr = array();
        foreach ($list as $key => $v) {
            if ($v['pid'] == $uid) {
                if($tier == $level){
                    array_push($arr,[
                        'user_id'   => $v['user_id'],
                    ]);
                }

                self::get_downline_list($list, $v['user_id'], $tier,$level + 1);
            }
        }
        return $arr;
    }

    public static function count_downline($list, $uid,$tier=2, $level = 0){
        static  $count = 0;
        foreach ($list as $key => $v) {
            if ($v['pid'] == $uid) {
                $count ++;
                self::count_downline($list, $v['user_id'], $tier,$level + 1);
            }
        }
        return $count;
    }

    public function getlist($ids,$query,$field){
        $re = $query->from('make_speed_distribution_distributor', 'd')
            ->innerjoin('make_speed_user', 'u')
            ->on([ 'd.user_id' => 'u.id' ])
            ->where([ 'user_id' => $ids ])
            ->select($field)
            ->orderby('d.id desc')
            ->getall();

        if($re){
            foreach ($re as $k=>&$v ){
                $conutWhere =  ['status >' => 4,'user_id'=>$v['user_id'] ];
                $usercount = pdo_get('make_speed_order',$conutWhere, array('SUM(total_price) as total_price ','COUNT(id) as count') );
                $v['total_price'] = $usercount['total_price'] ? $usercount['total_price'] : 0.00;
                $v['count']       = $usercount['count'];
                $v['create_time'] = date("Y-m-d H:i:s",$v['create_time']);
            }
        }

        return $re;
    }
}