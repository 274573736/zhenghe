<?php
namespace app\apis\controller\v2;
use app\apis\controller\v2\BaseController;
use app\apis\exception\OrderException;
class Index extends BaseController
{
    public function index(){
        $exception = new OrderException([
            'code'      => 200,
            'errcode'   => 0,
            'msg'       => 'ojbk'
        ]);
        throw $exception;
    }
}