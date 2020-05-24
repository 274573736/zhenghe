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


    /*
     * 中国居民身份证号格式验证
     * 根据  GB11643-1999 标准校验格式
     */
    protected function IDcard($value){
        if(!is_scalar($value))
            return false;

        $str = (string)$value;

        // 基础格式验证
        if(!preg_match('/^([0-9]{17})([0-9]|[x])$/i', $str) && !preg_match('/^[0-9]{15}$/i', $str))
            return false;

        // 地区码校验
        if(!array_key_exists(intval(substr($str, 0, 2)), array(
            11 => '北京',	12 => '天津',	13 => '河北',	14 => '山西',
            15 => '内蒙古',	21 => '辽宁',	22 => '吉林',	23 => '黑龙江',
            31 => '上海',	32 => '江苏',	33 => '浙江',	34 => '安徽',
            35 => '福建',	36 => '江西',	37 => '山东',	41 => '河南',
            42 => '湖北',	43 => '湖南',	44 => '广东',	45 => '广西',
            46 => '海南',	50 => '重庆',	51 => '四川',	52 => '贵州',
            53 => '云南',	54 => '西藏',	61 => '陕西',	62 => '甘肃',
            63 => '青海',	64 => '宁夏',	65 => '新疆',	71 => '台湾',
            81 => '香港',	82 => '澳门',	91 => '国外'
        )))
            return false;

        // 出生日期验证
        if(strlen($str) == 15)
            $birthday = '19'.substr($str, 6, 2).'-'.substr($str, 8, 2).'-'.substr($str, 10, 2);
        else
            $birthday = substr($str, 6, 4).'-'.substr($str, 10, 2).'-'.substr($str, 12, 2);

        $checkday = date_create($birthday);

        if(!$checkday || date_format($checkday, 'Y-m-d') !== $birthday)
            return false;

        unset($birthday, $checkday);

        // 18位尾数校验码验证
        if(strlen($str) == 18){
            $basecode	= substr($str, 0, 17);
            $verifycode	= substr($str, -1);

            $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            $verify = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

            $checksum = 0;

            for($i = 0; $i < 17; $i++)
                $checksum += (int)$basecode{$i} * $factor[$i];

            $mod = $checksum % 11;

            if(!isset($verify[$mod]) || strtoupper($verifycode) != $verify[$mod])
                return false;
        }

        return true;

    }
}