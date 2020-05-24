<?php

namespace app\api\exception;

use think\exception\Handle;
use think\Log;
use think\Request;
use Exception;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
//   防止httpException报错，改成基类/exception
    public function render(\Exception $e)
    {

        if ($e instanceof BaseException)
        {
            $this->code      = $e->code;
            $this->msg       = $e->msg;
            $this->errorCode = $e->errorCode;
        }
        else{
            // 服务器未处理的异常，将http状态码设置为500，并记录日志
            if(config('app_debug')){
                // 调试状态下需要显示TP默认的异常页面
                return parent::render($e);
            }

            $this->code = 500;
            $this->msg = 'sorry，we make a mistake. (^o^)Y';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }

        $request = Request::instance();
        $result = [
            'messsage'    => $this->msg,
            'errno'       => $this->errorCode,
            'data'        => '',
            'request_url' => $request = $request->url()
        ];
        return json($result, $this->code);
    }

    /*
     * 将异常写入日志
     */
    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' => ['error']
        ]);
//        Log::record($e->getTraceAsString());
        Log::record($e->getMessage(),'error');
    }
}