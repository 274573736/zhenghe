<?php


namespace app\api\exception;


class MissException extends BaseException
{
    public $code = 404;
    public $msg = '未找到所请求的资源';
    public $errorCode = 10001;

}