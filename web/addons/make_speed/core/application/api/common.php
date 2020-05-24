<?php

use think\Db;

/**
 * @param $mobile string 接收短信手机号
 * @param $codeParam   array    模板参数 例:array('code' =>'12345')
 * @param $templateCode string
 * @return array|bool|mixed
 */
function send_aliyun_sms($mobile,$codeParam,$templateCode='ali_temp_code'){

    if( empty($mobile) )
        return false;

    $params = array();

    //读取配置
    $where = array('uniacid'=>$GLOBALS['uniacid']);

    $smsparam = Db::name('setting')->where($where)->where('key','in','ali_sms_appid,ali_sms_secret,ali_sign_name,'.$templateCode)->column('key,value');


    $keyId     = $smsparam['ali_sms_appid'];
    $keySecret = $smsparam['ali_sms_secret'];

    $params["SignName"]      = $smsparam['ali_sign_name'];
    $params["TemplateCode"]  = $smsparam[$templateCode];
    $params["PhoneNumbers"]  = $mobile;
    $params['TemplateParam'] = $codeParam;


    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }


    vendor('Aliyun.SignatureHelper');

    $helper = new \SignatureHelper();

    $result = $helper->request($keyId,$keySecret,$params);

    return !empty($result) ? json_decode($result, true) : array();
}