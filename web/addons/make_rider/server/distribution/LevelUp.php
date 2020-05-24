<?php


namespace Server\distribution;
use Model\Config;
use Server\distribution\Count;

class LevelUp
{
    //分销用户ID
    public function  isLevelUp($ids){
        $query   = load()->object('query');
        $re      = $query->from('make_speed_distribution_distributor','d')
                        ->innerjoin('make_speed_distribution_grade','g')
                        ->on([ 'd.gid' => 'g.id'])
                        ->where([ 'user_id' => $ids ])
                        ->select(['d.user_id','d.gid','g.rank','g.total_amount','g.total_order','g.number_people'])
                        ->getall();

        $this->update($re);

    }

    public function update($re){
        $condition = $this->levelUpCondition();
        $list = pdo_getall('make_speed_distribution_distributor',['uniacid'=>$GLOBALS['uniacid'],'pid <>' => 0],['pid','user_id']);

        foreach ($re as $k=>$v ){
            if($condition == 0){
                $amount = Count::amount( $v['user_id'] );
                $grade  = $this->upOneLevel($v['rank']);
                if($grade){
                    if( $amount > $grade['total_amount']) {
                        pdo_update('make_speed_distribution_distributor',[ 'gid' => $grade['id'] ],[ 'user_id'=> $v['user_id'] ]);
                    }
                }

            }elseif ( $condition == 1){
                $totalOrder = Count::complete($v['user_id']);
                $grade      = $this->upOneLevel($v['rank']);
                if($grade){
                    if( $totalOrder > $grade['total_order']) {
                        pdo_update('make_speed_distribution_distributor',[ 'gid' => $grade['id'] ],[ 'user_id'=> $v['user_id'] ]);
                    }
                }
            }elseif ( $condition == 2){
                $referrals = Count::referrals($list,$v['user_id']);
                $grade     = $this->upOneLevel($v['rank']);
                if($grade){
                    if($referrals > $grade['number_people']){
                        $gid = $this->upOneLevel($v['rank']);
                        if ( $gid ) {
                            pdo_update('make_speed_distribution_distributor',[ 'gid' => $gid ],[ 'user_id'=> $v['user_id'] ]);
                        }
                    }
                }
            }

        }
    }

    //获取上一级等级
    public function upOneLevel($level){
        $sql   = "SELECT id,total_amount,total_order,number_people FROM " .tablename('make_speed_distribution_grade'). " WHERE uniacid=:uniacid AND rank > :rank ORDER BY rank asc LIMIT 0,1";
        $grade = pdo_fetch($sql,[
            ':uniacid'   => $GLOBALS['uniacid'],
            ':rank'      => $level,
        ]);
        if($grade){
            return $grade;
        }
        return false;
    }

    public function levelUpCondition(){
        //0 = 分销订单总额(完成的订单),1=分销订单总数(完成的订单),2=分销商下线人数
        $config = Config::get('d_grade');
        $config = empty($config) ? 0 : $config;
        return $config;
    }

}