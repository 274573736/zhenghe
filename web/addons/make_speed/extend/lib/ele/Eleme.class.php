<?php

defined('IN_IA') || exit('Access Denied');
load()->func('communication');
load()->func('logging');
class Eleme 
{
	protected $app;
	public $config = array();
	protected $token_url;
	public function __construct($business_id)
	{
        global $_W;
        $shop = pdo_get('make_speed_business', array('id'=>$business_id), array('id','shop_id', 'name', 'token', 'token_expire', 'refresh_token'));

        if(empty($shop))
            throw new Exception('商户不存在或已删除');

        $setting = pdo_getall('make_speed_setting',array('uniacid'=>$GLOBALS['uniacid'], 'key'=>array('eleme_switch','eleme_key','eleme_secret')),array('key','value'));
        $setting = @array_column($setting,'value','key');

        if(empty($setting) || empty($setting['eleme_key']))
            return false;

        $this->config = array(
            'key' => $setting['eleme_key'],
            'secret' => $setting['eleme_secret'],
            'sandbox' => true,
            'callback_url' => urlencode($_W['siteroot']."addons/make_speed/core/public/index.php/admin/eleme/callback"),
        );

        $this->app = array( 'shop' => $shop, 'key' => $this->config['key'], 'secret' => $this->config['secret'] );
        $this->shopid = $shop['shop_id'];

        $api_urls = array('sandbox' => 'https://open-api-sandbox.shop.ele.me/', 'open' => 'https://open-api.shop.ele.me/');

        $sand = !empty($setting['eleme_switch']) ? 'open' : 'sandbox';

        $this->api_url = $api_urls[$sand];
        $this->token_url = $this->api_url . "token";

    }


	private function getAccessToken(){
        if(time() < $this->app['shop']['token_expire']){
            return $this->app['shop']['token'];
        }

        $body = array(
            "grant_type" => "refresh_token",
            "refresh_token" => $this->app['shop']['refresh_token'],
            "scope" => 'all'
        );

        $response = $this->request($body, $this->token_url);

        if(empty($response) || isset($response['error']) || empty($response['access_token'])){
            empty($response['error_description']) && $response['error_description']='';
            return array(1, $response['error_description'].':refresh_token刷新失败, 请重新授权');
        }

        $data = array(
            'token'         => $response['access_token'],
            'token_expire'  => time() + intval($response['expires_in'])  -  300,
            'refresh_token' => $response['refresh_token'],
        );

        pdo_update('make_speed_business', $data, array('id'=>$this->app['shop']['id']));

        return $response['access_token'];
    }


    /** call server api with nop
     * @param $action
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function call($action, $parameters)
    {
        $protocol = array(
            "nop" => '1.0.0',
            "id" => $this->generate_reqId(),
            "action" => $action,
            "token" => $this->getAccessToken(),
            "metas" => array(
                "app_key" => $this->config['key'],
                "timestamp" => time(),
            ),
            "params" => $parameters,
        );

        $protocol['signature'] = $this->generate_signature($protocol);



        //如果没有参数，赋值为一个空对象
        if (count($parameters) == 0) {
            $protocol["params"] = (object)array();
        }


        $result = $this->post($this->api_url . 'api/v1/', $protocol);

        $response = json_decode($result, false, 512, JSON_BIGINT_AS_STRING);

        if (is_null($response)) {
            logging_run(date('Y-m-d H:i').'['.$action.' ERROR0]：'.@json_encode($result), 'trace', 'makespeedlog');
            return array(1, "invalid response.");
        }

        if (isset($response->error) && isset($response->error->code)) {

            logging_run(date('Y-m-d H:i').'['.$action.' ERROR]：'.$response->error->code.':'.$response->error->message, 'trace', 'makespeedlog');

            return array(1, $response->error->code.':'.$response->error->message);
        }

        return true;
    }

    private function generate_signature($protocol)
    {
        $merged = array_merge($protocol['metas'], $protocol['params']);
        ksort($merged);
        $string = "";
        foreach ($merged as $key => $value) {
            $string .= $key . "=" . json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        $splice = $protocol['action'] . $this->app['shop']['token'] . $string . $this->config['secret'];

        $encode = mb_detect_encoding($splice, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
        if ($encode != null) {
            $splice = mb_convert_encoding($splice, 'UTF-8', $encode);
        }

        return strtoupper(md5($splice));
    }

    private function generate_reqId()
    {
        return strtoupper(str_replace("-", "", $this -> create_uuid())) . "|" . $this -> get_millisecond();
    }

    private function get_millisecond()
    {
        list($usec, $sec) = explode(" ", microtime());
        $msec = (string) round($usec * 1000);
        while (strlen($msec) < 3)
        {
            $msec = "0" . $msec;
        }
        return $sec . $msec;
    }

    private function create_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }


    private function get_headers(){
        return array(
            "Authorization: Basic " . base64_encode(urlencode($this->config['key']) . ":" . urlencode($this->config['secret'])),
            "Content-Type: application/x-www-form-urlencoded; charset=utf-8",
            "Accept-Encoding: gzip"
        );
    }

    private function post($url, $data)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json; charset=utf-8", "Accept-Encoding: gzip"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_USERAGENT, "eleme-openapi-php-sdk");
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return array(1, curl_error($ch));
        }

        curl_close($ch);
        return $response;
    }


    /**
     * @param $body
     * @param $url
     * @return mixed
     * @throws Exception
     */
    private function request($body, $url)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->get_headers());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "eleme-openapi-php-sdk");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $request_response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        $response = @json_decode($request_response, true);

        return $response;
    }

}
?>