<?php
use Model\Config;

function setKeyExpire($id){
    if(!$id){
        return false;
    }
    $expire_time = Config::get('order_expire');
    $expire_time = $expire_time ? intval($expire_time*60) : intval(30*60);
    include_once MODULE_ROOT.'/extend/lib/redis/MyRedis.php';
    $redis = new MyRedis();
    $redis->setex('ex_order_id'.$id,$expire_time,$id);
}

function numeral($num){
    $china=array('零','一','二','三','四','五','六','七','八','九');
    $arr=str_split($num);
    for($i=0;$i<count($arr);$i++){
        return $china[$arr[$i]];
    }
}