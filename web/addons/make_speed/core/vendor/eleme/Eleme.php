<?php
/**
 * Created by PhpStorm.
 * User: sweets
 * Date: 2019/9/5
 * Time: 15:57
 */
class Eleme
{

    protected $app;

    private $client_id;
    private $secret;
    private $token_url;
    private $authorize_url;
    private $log;
    private $openId_rul;

    public $config = array();

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**获取授权URL
     *
     */
    public function get_oauth_url($callback, $scope = 'all', $state = 'make_speed'){

        $url = $this->config->get_request_url() . "/authorize";
        $response_type = "code";
        $client_id = $this->config->get_app_key();

        return $url . '?response_type=' .$response_type. '&client_id=' .$client_id. "&state=" . $state . "&redirect_uri=" .$callback."&scope=" . $scope;

    }

    /**获取token
     *
     */
    public function get_oauth_token($code, $callback=''){

        $url = $this->config->get_request_url() . "/token";

        $body = array(
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => urldecode($callback),
            "client_id" => $this->config->get_app_key()
        );

        $response = $this->request($body, $url);

        return $response;
    }

    /**发送请求
     *
     */
    public function request($body, $url){

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

        if (empty($response)) {
            throw new Exception("illegal response :" . $request_response);
        }
        if (isset($response['error'])) {
            throw new Exception(json_encode($response));
        }

        curl_close($ch);

        return $response;
    }

    private function get_headers(){
        return array(
            "Authorization: Basic " . base64_encode(urlencode($this->config->get_app_key()) . ":" . urlencode($this->config->get_app_secret())),
            "Content-Type: application/x-www-form-urlencoded; charset=utf-8",
            "Accept-Encoding: gzip"
        );
    }

}