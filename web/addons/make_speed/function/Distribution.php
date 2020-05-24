<?php

function isDistributor(){
    $re = pdo_get('make_speed_distribution_distributor',[ 'user_id'=>$GLOBALS['CURRENT_USER'],'uniacid'=>$GLOBALS['uniacid'] ],['id','status']);
    if(!$re){
        return array(0,'尚未成为分销商');
    }elseif($re['status'] == 0){
        return array(1,'您提交的申请正在审核中!');
    }
    return true;
}