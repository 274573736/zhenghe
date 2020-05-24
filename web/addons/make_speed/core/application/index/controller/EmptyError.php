<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-30
 * Time: 11:48
 */

namespace app\index\controller;

use app\common\controller\Frontend;

class EmptyError extends Frontend
{
    public function _initialize()
    {
        $this->redirect(tp_url('admin/index/index'));

        return false;
        //parent::_initialize();
    }

}