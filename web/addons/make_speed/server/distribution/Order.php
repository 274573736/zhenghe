<?php
namespace Server\distribution;

use Model\Config;

class Order
{


    public static function addOrder($data,$id){
        //查看分销商
        $exits = pdo_get('make_speed_distribution_distributor',[ 'user_id' => $data['user_id']],['id','gid','pid','is_distributor']);
        if( !$exits ){ return false ;}

        //分销层级
        $tier = Config::get('d_tier');
        $tier = empty($tier) ? 1 : $tier;

        //分销内购
        $iap = Config::get('d_iap');
        if($iap == 1){
            $parents = [];
            if($exits['is_distributor'] == 1){
                $frist = [
                    'id'        => $exits['id'],
                    'user_id'   => $data['user_id'],
                    'level'     => 1,
                    'gid'       => $exits['gid'],
                ];

                $parents = self::getParents($exits['pid'],$tier,2);
                array_push($parents,$frist);
            }
        }else{
            $parents = self::getParents($exits['pid'],$tier);
        }


        if($parents){
            $price   = self::countType($data);
            $parents = self::countCommission($parents,$price);
            self::doAdd($data,$id,$parents);
        }
    }



    public static function doAdd($data,$id,$parents){
        $insertData = [
            'order_number'  => $data['order_code'],
            'pay_user_id'   => $data['user_id'],
            'price'         => $data['pay_price'],
            'uniacid'       => $GLOBALS['uniacid'],
            'order_id'      => $id,
            'city_id'       => $data['city_id'],
            'create_time'   => time(),
            'status'        => 0,
        ];
        foreach ($parents as $k=>$v) {
            $insertData['level']      = $v['level'];
            $insertData['user_id']    = $v['user_id'];
            $insertData['commission'] = $v['commission'];
            pdo_insert('make_speed_distribution_order',$insertData);
        }
    }

    public static function countCommission($parents,$price){

        foreach ($parents as $k => &$v){
            $field = ['first_commission','second_commission','three_commission'];
            $grade = pdo_get('make_speed_distribution_grade',['id'=> $v['gid'] ],$field);
            if( $v['level'] == 1){
                $v['commission'] = sprintf("%.2f",$price*$grade['first_commission']/100);
            }elseif ($v['level'] == 2){
                $v['commission'] = sprintf("%.2f",$price*$grade['second_commission']/100);
            }elseif ($v['level'] == 3){
                $v['commission'] = sprintf("%.2f",$price*$grade['three_commission']/100);
            }
        }
        return $parents;
    }

    /**
     * 1=支付金额，2=平台抽佣
     * @param $data
     * @return price
     */
    public static function countType($data){
        $countType = Config::get('d_count_commission_type');
        $countType = $countType ? $countType : 1 ;
        if($countType == 1){
            return $data['pay_price'];
        }
        //平台抽佣
        //骑手所得佣金设置
        $riderCommission = Config::get('rider_wages');
        $setting  = sprintf('%.2f', $riderCommission ) > 0 ? sprintf('%.2f', $riderCommission ) : 0.8;

        //平台所得金额、分销金额分平台所得金额................
        $price    = $data['total_price'] - ($data['total_price'] * $setting);
        return sprintf("%.2f",$price);
    }

    /**
     * @param int $pid   用户id
     * @param int $tier  获取多少层级分销
     * @param int $level 分销层级
     * @return array
     */
    public static function getParents($pid,$tier = 1,$level = 1){
        static $array = [];
        $re = pdo_get('make_speed_distribution_distributor',['user_id' => $pid,'status'=>1,'is_distributor'=>1,'uniacid'=>$GLOBALS['uniacid']],['pid','id','user_id','gid']);
        if(!$re){
            return $array;
        }

        array_push($array,[
            'id'        => $re['id'],
            'user_id'   => $re['user_id'],
            'level'     => $level,
            'gid'       => $re['gid'],
        ]);


        if ( $tier == $level || $level >= 3){
            return $array;
        }

        if($re['pid'] != 0){
            self::getParents($re['pid'],$tier,$level+1);
        }

        return $array;
    }

    public static function updateOrder($id,$status=1){
        $re = pdo_update('make_speed_distribution_order',[ 'status' => $status ],[ 'order_id' => $id ]);
        if($re){
            return true;
        }
        return false;
    }
}