<?php
namespace app\admin\library;

use think\exception\Handle;
use think\App;
use think\Config;
use think\Log;

class ExceptionHandler extends Handle{

    public function render(\Exception $e)
    {
        return parent::render($e);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(\Exception $exception)
    {
        if (!$this->isIgnoreReport($exception)) {
            // 收集异常数据
            if (App::$debug) {
                $data = [
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'message' => $this->getMessage($exception),
                    'code'    => $this->getCode($exception),
                ];
                $log = "[{$data['code']}]{$data['message']}[{$data['file']}:{$data['line']}]";
            } else {
                $data = [
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'code'    => $this->getCode($exception),
                    'message' => $this->getMessage($exception),
                ];
                $log = "[{$data['code']}]{$data['message']}".PHP_EOL."[{$data['file']}:{$data['line']}]".PHP_EOL;
            }

            if (Config::get('record_trace')) {
                $log .= "\r\n" . $exception->getTraceAsString();
            }

            Log::record($log, 'error');
        }
    }
}