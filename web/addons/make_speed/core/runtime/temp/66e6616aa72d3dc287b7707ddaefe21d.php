<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:110:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/order/order/detail.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/addons/make_speed/core/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/addons/make_speed/core/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/addons/make_speed/core/public/assets/js/html5shiv.js"></script>
  <script src="/addons/make_speed/core/public/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <style>
.bella-checkbox{
    position: relative;
}
/** 将初始的checkbox的样式改变 */
.bella-checkbox input[type="checkbox"] {
    opacity: 0; /*将初始的checkbox隐藏起来*/
}

/** 设计新的checkbox，位置 */
.bella-checkbox label:before {
    content: '';
    width: 19px;
    height: 19px;
    display: inline-block;
    border-radius: 2px;
    border: 1px solid #bbb;
    background: #fff;
}

/** 点击初始的checkbox，将新的checkbox关联起来 */
.bella-checkbox input[type="checkbox"]:checked + label:after {
    display: inline-block;
    font-family: 'Glyphicons Halflings';
    content: "\e013";
    top: 15%;
    left: 10%;
    position: absolute;
    font-size: 11px;
    line-height: 1;
    width: 16px;
    height: 16px;
    color: #333;
}

.bella-checkbox label {
    cursor: pointer;
    text-align: center;
    position: absolute;
    left: 10px;
}
</style>

                                <div class="panel panel-default panel-intro" style="-webkit-box-shadow:none;box-shadow: none">
    <div class="panel-heading">
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#order" data-toggle="tab">基本信息</a></li>
        <li><a href="#address" data-toggle="tab">订单地址</a></li>
        <li><a href="#rider" data-toggle="tab">配送骑手</a></li>
    </ul>
    </div>
</div>
<style>
    .form-horizontal{margin-top: 18px}
</style>
<div class="panel-body">
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="order">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Order_code'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['order_code']; ?></p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('User_id'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static"><?php echo $row['username']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Goods_id'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['goodsname']; ?> kg</p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('Coupon_id'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static">
                            <?php if(!empty($row['coupons_name'])): ?>
                            <?php echo $row['coupons_name']; ?><span class='text-warning'>【-￥<?php echo $row['coupons_money']; ?>】</span>
                            <?php else: ?>
                            暂无使用
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Weight_price'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['weight_price']; ?></p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('Get_time'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static"><?php echo $row['oget_time']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Distance'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['distance']; ?> 公里</p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('Distance_price'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static"><?php echo $row['distance_price']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Total_price'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['total_price']; ?> 元</p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('Pay_price'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static"><?php echo $row['pay_price']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Small_price'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['small_price']; ?></p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('Status'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static"><?php echo __('Status '.$row['status']); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('取件码'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo $row['pick_code']; ?></p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('收件码'); ?>:</label>
                    <div class="col-sm-5">
                        <p class="form-control-static"><?php echo $row['end_code']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Add_time'); ?>:</label>
                    <div class="col-sm-3">
                        <p class="form-control-static"><?php echo datetime($row['add_time']); ?></p>
                    </div>

                    <!--<label class="col-sm-2 control-label"><?php echo __('Update_time'); ?>:</label>-->
                    <!--<div class="col-sm-5">-->
                        <!--<p class="form-control-static"><?php echo datetime($row['update_time']); ?></p>-->
                    <!--</div>-->
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>
                    <div class="col-xs-12 col-sm-8">
                        <p class="form-control-static"><?php echo $row['description']; ?></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade in" id="address">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Begin_username'); ?>:</label>
                    <div class="col-sm-4">
                        <p class="form-control-static"><?php echo $row['begin_username']; ?></p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('Begin_phone'); ?>:</label>
                    <div class="col-sm-4">
                        <p class="form-control-static"><?php echo $row['begin_phone']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Begin_address'); ?>:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo $row['begin_address']; ?> <?php echo $row['begin_detail']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('End_username'); ?>:</label>
                    <div class="col-sm-4">
                        <p class="form-control-static"><?php echo $row['end_username']; ?></p>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo __('End_phone'); ?>:</label>
                    <div class="col-sm-4">
                        <p class="form-control-static"><?php echo $row['end_phone']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('End_address'); ?>:</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo $row['end_address']; ?> <?php echo $row['end_detail']; ?></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade in" id="rider">
            <div class="form-horizontal">
                <?php if(empty($row['rider_mobile']) || (($row['rider_mobile'] instanceof \think\Collection || $row['rider_mobile'] instanceof \think\Paginator ) && $row['rider_mobile']->isEmpty())): ?>
                    暂无
                    <hr>
                <?php else: ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">配送骑手:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo isset($row['rider_name'])?$row['rider_name']: ''; ?></p>
                        </div>
                        <label class="col-sm-2 control-label">联系电话:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo isset($row['rider_mobile'])?$row['rider_mobile']: ''; ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务得分:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['score'])?$row['score']: '暂无评分'; ?></p>
                        </div>

                        <label class="col-sm-2 control-label">评价标签:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo isset($row['tag'])?$row['tag']: ''; ?></p>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">骑手行程:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['rider_distance'])?$row['rider_distance']: '暂无'; ?></p>
                        </div>

                        <label class="col-sm-2 control-label">行程用时:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['time'])?$row['time']: '暂无'; ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">接单时间:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['accept_time'])?$row['accept_time']: '暂无'; ?></p>
                        </div>

                        <label class="col-sm-2 control-label">揽件时间:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['get_time'])?$row['get_time']: '暂无'; ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">送达时间:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['goto_time'])?$row['goto_time']: '暂无'; ?></p>
                        </div>

                        <label class="col-sm-2 control-label">完成(评价)时间:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static"><?php echo !empty($row['complete_time'])?$row['complete_time']: '暂无'; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">取件拍照:</label>
                        <div class="col-sm-5">
                            <?php if(empty($row['pick_img']) || (($row['pick_img'] instanceof \think\Collection || $row['pick_img'] instanceof \think\Paginator ) && $row['pick_img']->isEmpty())): ?>
                            无
                            <?php else: if(is_array($row['pick_img']) || $row['pick_img'] instanceof \think\Collection || $row['pick_img'] instanceof \think\Paginator): $i = 0; $__LIST__ = $row['pick_img'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <img src="<?php echo $vo; ?>" alt="" style="width:60px;height:60px">
                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">送达拍照:</label>
                        <div class="col-sm-5">
                            <?php if(empty($row['end_img']) || (($row['end_img'] instanceof \think\Collection || $row['end_img'] instanceof \think\Paginator ) && $row['end_img']->isEmpty())): ?>
                            无
                            <?php else: if(is_array($row['end_img']) || $row['end_img'] instanceof \think\Collection || $row['end_img'] instanceof \think\Paginator): $i = 0; $__LIST__ = $row['end_img'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vq): $mod = ($i % 2 );++$i;?>
                            <img src="<?php echo $vq; ?>" alt="" style="width:60px;height:60px">
                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
