<?php
namespace Validate;
use Validate\Validate as CV;

class BaseValidate extends CV{
    public function goCheck(){
        global $_GPC;
        if (!$this->check($_GPC)) {
            msg( is_array($this->error) ? implode(';', $this->error) : $this->error );
        }
        return true;
    }

    //正整数验证
    protected function isPositiveInteger($value, $rule='', $data='', $field=''){
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8|9)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}