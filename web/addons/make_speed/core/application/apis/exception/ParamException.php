<?php


namespace app\apis\exception;


class ParamException  extends BaseException
{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}