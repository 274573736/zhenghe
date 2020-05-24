<?php

namespace app\common\controller;

use think\Db;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;

/**
 * API控制器基类
 */
class Apis
{

    /**
     * @var Request Request 实例
     */
    protected $request;

    /**
     * 默认响应输出类型,支持json/xml
     * @var string
     */
    protected $responseType = 'json';

    /**
     * 构造方法
     * @access public
     * @param Request $request Request 对象
     */
    public function __construct(Request $request = null)
    {
        $this->request = is_null($request) ? Request::instance() : $request;

        $token = $this->request->param("token");
        $domain= $this->request->domain();


        if(!empty($token)) {
            $cloud = Db::name('clouds')->where(['token' => $token])->field('id,domain,add_time,uniacid')->find();

            \think\Log::record('APIAPIAPIAPIAPIA：'.@json_encode($cloud), 'error');

            if (empty($cloud)) {
                $this->error('请求token无效');
            }

            if (!empty($cloud['domain']) && $cloud['domain'] != $domain) {
                $this->error('请求域名不合法');
            }
        }
        //uniacid
        $GLOBALS['uniacid'] = !empty($cloud['uniacid']) ? intval($cloud['uniacid']) : 0;
        $GLOBALS['cloud_id']= !empty($cloud['id']) ? intval($cloud['id']) : 0;

        if(empty($GLOBALS['uniacid']) || empty($GLOBALS['cloud_id'])){
            $this->error('请求对接模块不存在, 请检验token是否正确');
        }

    }

    /**
     * 操作成功返回的数据
     * @param string $msg   提示信息
     * @param mixed $data   要返回的数据
     * @param int   $code   错误码，默认为1
     * @param string $type  输出类型
     * @param array $header 发送的 Header 信息
     */
    protected function success($msg = '', $data = null, $code = 0, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    /**
     * 操作失败返回的数据
     * @param string $msg   提示信息
     * @param mixed $data   要返回的数据
     * @param int   $code   错误码，默认为0
     * @param string $type  输出类型
     * @param array $header 发送的 Header 信息
     */
    protected function error($msg = '', $data = null, $code = 1, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @access protected
     * @param mixed  $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为0
     * @param string $type   输出类型，支持json/xml/jsonp
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    protected function result($msg, $data = null, $code = 0, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            //'time' => Request::instance()->server('REQUEST_TIME'),
            'data' => $data,
        ];
        // 如果未设置类型则自动判断
        $type = $type ? $type : ($this->request->param(config('var_jsonp_handler')) ? 'jsonp' : $this->responseType);

        if (isset($header['statuscode']))
        {
            $code = $header['statuscode'];
            unset($header['statuscode']);
        }
        else
        {
            //未设置状态码,根据code值判断
            $code = $code >= 1000 || $code < 200 ? 200 : $code;
        }
        $response = Response::create($result, $type, $code)->header($header);
        throw new HttpResponseException($response);
    }

}