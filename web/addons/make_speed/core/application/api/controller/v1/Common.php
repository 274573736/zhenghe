<?php


namespace app\api\controller\v1;

use app\common\controller\App;
use app\api\validate\Mobile;

class Common{
    public function sendSms($mobile)
    {
        ( new Mobile() )->goCheck();
        $re = send_aliyun_sms($mobile);
        dump($re);die;
    }




}