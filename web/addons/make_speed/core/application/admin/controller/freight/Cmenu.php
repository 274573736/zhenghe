<?php
/**
 * Created by PhpStorm.
 * User: HelloWord
 * Date: 2019/9/6
 * Time: 15:16
 */

namespace app\admin\controller\freight;

use app\common\library\Menu;
use app\common\controller\Backend;

class Cmenu extends Backend
{
    public function index(){

        $menu = [
            [
                'name'    => 'carhailing/vehicle_brand',
                'title'   => '车辆品牌管理',
                'icon'    => 'fa fa-circle-o',
                'sublist' => [
                    ['name' => 'carhailing/vehicle_brand/index','title' => '查看'],
                    ['name' => 'carhailing/vehicle_brand/add',  'title' => '添加'],
                    ['name' => 'carhailing/vehicle_brand/edit', 'title' => '编辑'],
                    ['name' => 'carhailing/vehicle_brand/del',  'title' => '删除'],
                ],
            ],
            [
                'name'    => 'carhailing/vehicle_type',
                'title'   => '车辆类型管理',
                'icon'    => 'fa fa-circle-o',
                'sublist' => [
                    ['name' => 'carhailing/vehicle_type/index','title' => '查看'],
                    ['name' => 'carhailing/vehicle_type/add',  'title' => '添加'],
                    ['name' => 'carhailing/vehicle_type/edit', 'title' => '编辑'],
                    ['name' => 'carhailing/vehicle_type/del',  'title' => '删除'],
                ],
            ],
            [
                'name'    => 'carhailing/vehicle_list',
                'title'   => '车辆信息',
                'icon'    => 'fa fa-circle-o',
                'sublist' => [
                    ['name' => 'carhailing/vehicle_list/index','title' => '查看'],
                    ['name' => 'carhailing/vehicle_list/add',  'title' => '添加'],
                    ['name' => 'carhailing/vehicle_list/edit', 'title' => '编辑'],
                    ['name' => 'carhailing/vehicle_list/del',  'title' => '删除'],
                ],
            ],
        ];
        Menu::create($menu,'cvehicle');
        return true;
    }
}