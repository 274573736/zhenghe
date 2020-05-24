<?php


namespace Validate\app;
use Validate\BaseValidate;

class RiderAuth extends BaseValidate
{
    protected $rule = [
        'name'       => 'require|chs|length:2,4',
        'idcard'     => 'require|IDcard',
        'sex'        => 'require|between:0,1',
        'upload_photos'  => 'require|uploadImage',
        'address_detail' => 'require',
    ];

    protected $message = [
        'upload_photos'  => '身份证图片不能为空',
        'idcard'         => '身份证号不能为空',
        'idcard.IDcard'  => '身份证号码格式不正确',
        'sex'            => '请选择性别',
        'sex.between'    => '性别参数不合法',
        'name'           => '用户名不能为空',
        'name.chs'       => '用户名只能输入中文',
        'name.length'    => '用户名只能输入2到4位汉字！',
        'address_detail' => '请输入地址',

    ];

    public  function uploadImage($value){
        $img = explode(',', $value);
        if($img){
            if(count($img) != 4){
                return '请上传完整图片！';
            }
            return true;
        }
        return '上传图片数据非法';
    }
}