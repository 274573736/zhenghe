<?php
namespace Server\homemaking;

class Category{

    /**
     * @param $pids
     * @param $cates
     */
    public function tree($pids,$cates){
        foreach ($pids as $k => $v ){

        }
    }

    public function getChild($parent,$cates){
        static $arr = [];
        foreach ($cates as $k=>$v){
            if($cates['pid'] == $parent['id']){
               $parent['child'][] = $v;
            }
        }
    }
}