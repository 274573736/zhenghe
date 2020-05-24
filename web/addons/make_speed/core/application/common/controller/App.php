<?php

namespace app\common\controller;

use think\Request;

/**
 * API控制器基类
 */
class App
{

    /**
     * @var Request Request 实例
     */
    protected $request;


    /**
     * @var array 前置操作方法列表
     */
    protected $beforeActionList = [];


    /**
     * 构造方法
     * @access public
     * @param Request $request Request 对象
     */
    public function __construct(Request $request = null)
    {
        $this->request = is_null($request) ? Request::instance() : $request;

        // 控制器初始化
        $this->_initialize();

        // 前置操作方法
        if ($this->beforeActionList)
        {
            foreach ($this->beforeActionList as $method => $options)
            {
                is_numeric($method) ?
                    $this->beforeAction($options) :
                    $this->beforeAction($method, $options);
            }
        }
    }

    /**
     * 初始化操作
     * @access protected
     */
    protected function _initialize()
    {
        //移除HTML标签
        $this->request->filter('strip_tags');

    }



    /**
     * 前置操作
     * @access protected
     * @param  string $method  前置操作方法名
     * @param  array  $options 调用参数 ['only'=>[...]] 或者 ['except'=>[...]]
     * @return void
     */
    protected function beforeAction($method, $options = [])
    {
        if (isset($options['only']))
        {
            if (is_string($options['only']))
            {
                $options['only'] = explode(',', $options['only']);
            }

            if (!in_array($this->request->action(), $options['only']))
            {
                return;
            }
        }
        elseif (isset($options['except']))
        {
            if (is_string($options['except']))
            {
                $options['except'] = explode(',', $options['except']);
            }

            if (in_array($this->request->action(), $options['except']))
            {
                return;
            }
        }

        call_user_func([$this, $method]);
    }





}
