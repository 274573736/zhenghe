<?php
/**
 * Created by PhpStorm.
 * User: HelloWord
 * Date: 2019/10/26
 * Time: 17:03
 */

namespace app\admin\model;
use think\Model;

class VirtualRider extends Model
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    protected $autoWriteTimestamp = true;
    public function getIsShowList()
    {
        return ['0' => '隐藏', '1' => '显示'];
    }
}