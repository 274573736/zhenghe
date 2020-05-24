<?php
namespace app\apis\model;

class Clouds extends BaseModel
{
    public static function getModuleByToken($token,$appid){
        $module = self::where(['token' => $token,'appid' => $appid])->find();
        return $module;
    }

    public static function getModuleByID($id){
        $module = self::where(['id'=>$id])->field(['charging'])->find();
        return $module;
    }


}