<?php
namespace app\apis\model;
use think\Model;
use think\Request;

class BaseModel extends Model
{
    protected function convertData($value,$data){
        $date = date("Y-m-d H:i:s",$value);
        return $date;
    }

    protected function  prefixImgUrl($value, $data){
        $request = Request::instance();
        $finalUrl = $request->domain().'/addons/make_speed/core/public/'.$value;
        return $finalUrl;
    }
}