<?php
namespace app\apis\validate;

use think\Validate;
use think\Request;
use app\apis\exception\ParamException;

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

    /*
     * 验证逗号分割的经纬度
     */
    protected function checkCoord($value, $rule='', $data='', $field=''){
        $math = "/^[0-9]{2,15}\.[0-9]{2,20}\,[0-9]{2,10}\.[0-9]{2,20}$/";
        $result = preg_match($math, $value);
        if ($result) {
            return true;
        } else {
            return $field . '坐标必须是逗号分割的正整数';
        }
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