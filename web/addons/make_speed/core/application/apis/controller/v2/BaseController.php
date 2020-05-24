<?php
namespace app\apis\controller\v2;
use think\Controller;
use think\Request;
use app\apis\server\Token;


class BaseController extends Controller{
    protected $request;

    public function _initialize(){
        $this->request      = Request::instance();
        $GLOBALS['uniacid'] = Token::getCurrentTokenVar('uniacid');
    }

}