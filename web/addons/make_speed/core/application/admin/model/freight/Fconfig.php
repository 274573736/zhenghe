<?php

namespace app\admin\model\freight;

use think\Model;


class Fconfig extends Model
{

    protected $name = 'setting';

    public function editConfig($params,$field){

//        $params = array_filter(array_intersect_key($params, array_flip( $field ) ),'filtrfunction' );
        $params = array_intersect_key($params, array_flip( $field ) );



        $field          = implode(',',$field);
        $where['key']  = ['in',$field];


        $res    = self::where($where)->where('uniacid',$GLOBALS['uniacid'])->select();

        $update_data = [];

        if($res){
            //更新表配置
            $num    = null;
            foreach($res as $k=>$v){

                if( isset($params[ $v['key'] ]) ){
                    //如果提交的值和数据的值相同则不更新
                    if($params[ $v['key'] ] !== $v['value']){
                        $num += self::where('key',$v['key' ])->where('uniacid',$GLOBALS['uniacid'])->update([ 'value'=>$params[ $v['key'] ]  ]);
//                        $v['value'] = $params[ $v['key'] ];
//                        $update_data[] = $v;

                    }
                    unset($params[ $v['key'] ]);
                }
            }
//            if($update_data){
//
//                $update_data = collection($update_data)->toArray();
//                $num         = self::isUpdate()->saveAll($update_data);
//                dump(collection($num)->toArray());die;
//            }
        }





        //新增表的配置
        $insert_data = [];
        if($params){
            foreach($params as $k=>$v){
                $insert_data[] = ['key'=>$k,'value'=>$v,'uniacid'=>$GLOBALS['uniacid']];
            }

            $ins = self::saveAll($insert_data);
        }


        if( !empty($num) || !empty($ins) ){
            return true;
        }else{
            return false;
        }

    }

}
