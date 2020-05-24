<?php
namespace app\admin\model\homemaking;


use think\Model;


class Category extends Model{

    protected $name = 'homemaking_category';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

}