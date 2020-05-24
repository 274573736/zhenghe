<?php
//消息推送Demo
error_reporting(0);
header("Content-Type: text/html; charset=utf-8");
require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/' . 'igetui/template/notify/IGt.Notify.php');


//采用"PHP SDK 快速入门"， "第二步 获取访问凭证 "中获得的应用配置
//现网demo
define('APPKEY','yI7WSGKnAl7dcEjwsN3dV9');
define('APPID','sQKhs1Gw047WjAl8jOu7lA');
define('MASTERSECRET','ZZDUXIB7f1AE42PxOq9RiA');
define('HOST',"http://sdk.open.api.igexin.com/apiex.htm");

$cids = [
  '955ea46d121cd47690e3276cd44bf763',
  '1d76de96f0f95e2d476987143237ec60',
];


$uni_identify = 'uni.UNI61D8078';
$payload = '{"title":"标题","content":"内容","sound":"default","payload":"test"}';
$intent = 'intent:#Intent;action=android.intent.action.oppopush;launchFlags=0x14000000;component='.$uni_identify.'/io.dcloud.PandoraEntry;S.UP-OL-SU=true;S.title=标题;S.content=内容;S.payload=test;end';
$template =  new IGtTransmissionTemplate();              //使用透传消息模板
$template->set_appId(APPID);                      //应用appid
$template->set_appkey(APPKEY);                   //应用appkey
$template->set_transmissionType(2);      //透传消息类型
$template->set_transmissionContent($payload);            //消息内容

$notify = new IGtNotify();
$notify->set_title('标题');
$notify->set_content('内容');
$notify->set_intent($intent);
$notify->set_type(NotifyInfo_type::_intent);

$template->set3rdNotifyInfo($notify);

pushMessageToList($cids);

//多推接口案例
function pushMessageToList($cids){
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    //$igt = new IGeTui('',APPKEY,MASTERSECRET);//此方式可通过获取服务端地址列表判断最快域名后进行消息推送，每10分钟检查一次最快域名
    //消息模版：
    // LinkTemplate:通知打开链接功能模板
    $template = IGtLinkTemplate();


    //定义"ListMessage"信息体
    $message = new IGtListMessage();
    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(3600*12*1000);//离线时间
    $message->set_data($template);//设置推送消息类型
    $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送，在wifi条件下能帮用户充分节省流量
    $contentId = $igt->getContentId($message);


    $targetList = [];
    foreach ($cids as $k=>$v){
        $target = new IGtTarget();
        $target->set_appId(APPID);
        $target->set_clientId($v);
        $targetList[$k] = $target;
    }


    $rep = $igt->pushMessageToList($contentId, $targetList);
    var_dump($rep);
    echo ("<br><br>");
}

function IGtLinkTemplate(){
    $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType(1);//透传消息类型
    $template->set_transmissionContent("测试离线");//透传内容
    $template->set_title("接单提醒");//通知栏标题
    $template->set_text("您有一条订单跑腿订单待接单");//通知栏内容
//    $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除
//    $template->set_notifyId(123456789);
//    $template->set_channel("set_channel");
//    $template->set_channelName("set_channelName");
//    $template->set_channelLevel(3);
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    return $template;
}