<?php
namespace app\apis\model;


use app\apis\exception\ParamException;

class Setting extends BaseModel
{

    public static function getVar($key){
        if(!is_array($key)){
            $val = self::where(['key'=>$key,'uniacid'=>$GLOBALS['uniacid'] ])->field('value')->find();
            if(!$val){
                throw new ParamException(['msg'=>'请求的'.$key.'配置不存在,uniacid为'.$GLOBALS['uniacid'] ]);
            }
            return $val['value'];
        }
    }

}