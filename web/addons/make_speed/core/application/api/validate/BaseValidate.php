<?php
namespace app\api\validate;

use think\Validate;
use think\Request;
use app\api\exception\ParamException;

class BaseValidate extends Validate
{
    public function goCheck()
    {

        $request = Request::instance();
        $params  = $request->param();
        if (!$this->check($params)) {

            $exception = new ParamException(
                [
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]);
            throw $exception;
        }
        return true;
    }


    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    protected function verifyOrderNum($value){
        if(strrpos($value, 'A')===false){
            return '订单号有误';
        }
        return true;
    }

}