<?php


namespace app\api\exception;


class OrderException extends BaseException
{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "订单不存在！";

}