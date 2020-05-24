<?php


namespace app\api\v1;
use app\common\controller\App;

class WqBase extends App
{
    public function _initialize()
    {
        $GLOBALS['uniacid'] = $this->request->param('uniacid');
    }
}