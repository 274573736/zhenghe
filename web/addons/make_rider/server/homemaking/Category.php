<?php
namespace Server\homemaking;

class Category{

    public function checkCateId($cate_dis){
        if(!is_array($cate_dis) ){
            msg('not array');
        }
        foreach( $cate_dis as $k => $v ){
            $re = pdo_get('make_speed_homemaking_category',[ 'id' => $v ],[ 'id' ]);
            if(!$re){
                msg('选择类目不存在,请重新选择！');
            }
        }
    }
}