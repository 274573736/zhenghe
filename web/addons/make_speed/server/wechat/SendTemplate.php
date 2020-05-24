<?php
namespace Server\wechat;

class SendTemplate{
    public  $url     = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=';
    public  $token   = '';

    public function __construct($token){
        $this->token = $token;
    }

    public  function send($data){
        $url = $this->url.$this->token;

        $data = array(
            'touser'        => $data['open_id'],
            'template_id'   => $data['tpl_id'],
            'page'          => $data['page'],
            'data'          => $data['data'],
        );
        $data = json_encode($data);
        load()->func('communication');
        $re   = ihttp_post($url, $data);
        return json_decode($re['content'],true);
    }

    public static function test(){
        $keys  = [
            ['thing8','character_string1','amount9','phrase10','time2'],    //下单成功
            ['character_string2','amount10','phrase11','time12','thing5'],  //订单取消
            ['number4','thing2','thing3','time6'],
            ['number1','time4','name7','phone_number8','thing9'],
            ['time5','thing2','thing6','date3'],
        ];
    }

}