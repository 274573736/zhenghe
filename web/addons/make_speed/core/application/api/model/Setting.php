<?php
namespace app\api\model;

use app\api\exception\ParamException;

class Setting extends BaseModel {

    public function getVar($key){
        if(!is_array($key)){
            $val = self::where(['key'=>$key,'uniacid'=>$GLOBALS['uniacid'] ])->value('value');
            if(!$val){
                throw new ParamException(['messsage'=>'请求的'.$key.'配置不存在,uniacid为'.$GLOBALS['uniacid'] ]);
            }
            return $val;
        }
        return false;
    }
}