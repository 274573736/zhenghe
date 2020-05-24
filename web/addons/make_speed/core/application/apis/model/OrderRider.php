<?php


namespace app\apis\model;


class OrderRider extends BaseModel
{
    public function rider(){
        return $this->hasOne('Rider','id','rider_id',[],'LEFTJOIN');
    }

    public function getAcceptTimeAttr($value,$data){
        if($value) {
            return $this->convertData($value, $data);
        }
    }
    public function getGetTimeAttr($value,$data){
        if($value) {
            return $this->convertData($value, $data);
        }
    }
    public function getGotoTimeAttr($value,$data){
        if($value) {
            return $this->convertData($value, $data);
        }
    }
    public function getCompleteTimeAttr($value,$data){
        if($value) {
            return $this->convertData($value, $data);
        }
    }

    public function getPickImgAttr($value, $data){
        if($value){
            return $this->prefixImgUrl($value,$data);
        }
    }

    public function getEndImgAttr($value, $data){
        if($value){
            return $this->prefixImgUrl($value,$data);
        }
    }
}