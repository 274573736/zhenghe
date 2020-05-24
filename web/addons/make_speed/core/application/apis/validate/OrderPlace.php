<?php


namespace app\apis\validate;

use app\apis\exception\ParamException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'goods_name' => 'require|isNotEmpty',
        'pick_time'  => 'require|isNotEmpty',
        'address'    => 'require|isNotEmpty|checkAddress',
        'pay_price'  => 'require|isNotEmpty',
    ];

    protected $addressRule = [
        'begin_address' => 'require',
        'begin_lat'     => 'require|checkLatLng',
        'begin_lng'     => 'require|checkLatLng',
        'begin_username'=> 'require',
        'begin_phone'   => 'require|isMobile',
        'end_address'   => 'require',
        'end_lat'       => 'require|checkLatLng',
        'end_lng'       => 'require|checkLatLng',
        'end_username'  => 'require',
        'end_phone'     => 'require|isMobile',
    ];

    protected $addressMessage  = [
        'begin_lat.checkLatLng' => '发货地维度不正确',
        'begin_lng.checkLatLng' => '发货地经度不正确',
        'begin_phone.isMobile'  => '发货人手机号格式不正确',
        'end_lat.checkLatLng'   => '收货地维度不正确',
        'end_lng.checkLatLng'   => '收货地经度不正确',
        'end_phone.isMobile'    => '收货人手机号格式不正确',
    ];

    protected function checkAddress($value){
        $address = json_decode($value,true);
        if(!$address){
            return 'json地址数据有误';
        }

        $result   = $this->message($this->addressMessage)->check($address,$this->addressRule);
        if (!$result) {
            throw new ParamException(['msg' => $this->getError()]);
        }
        return true;
    }

    protected function checkLatLng($value, $rule='', $data='', $field=''){
        $math = "/^[0-9]{2,10}\.[0-9]{2,20}$/";
        $result = preg_match($math, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


}