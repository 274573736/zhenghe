<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:107:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/dashboard/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

                                <style type="text/css">
    .sm-st {
        background:#fff;
        padding:20px;
        -webkit-border-radius:3px;
        -moz-border-radius:3px;
        border-radius:3px;
        margin-bottom:20px;
        -webkit-box-shadow: 0 1px 0px rgba(0,0,0,0.05);
        box-shadow: 0 1px 0px rgba(0,0,0,0.05);
    }
    .sm-st-icon {
        width:90px;
        height:70px;
        display:inline-block;
        line-height:70px;
        text-align:center;
        font-size:30px;
        background:#eee;
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
        float:left;
        margin-right:10px;
        color:#fff;
    }
    .sm-st-info {
        font-size:12px;
        padding-top:10px;
    }
    .sm-st-info span {
        display:block;
        font-size:24px;
        font-weight:600;
    }
    .orange {
        background:#fa8564 !important;
    }
    .tar {
        background:#45cf95 !important;
    }
    .sm-st .green {
        background:#86ba41 !important;
    }
    .pink {
        background:#AC75F0 !important;
    }
    .yellow-b {
        background: #fdd752 !important;
    }
    .stat-elem {

        background-color: #fff;
        padding: 18px;
        border-radius: 40px;

    }

    .stat-info {
        text-align: center;
        background-color:#fff;
        border-radius: 5px;
        margin-top: -5px;
        padding: 8px;
        -webkit-box-shadow: 0 1px 0px rgba(0,0,0,0.05);
        box-shadow: 0 1px 0px rgba(0,0,0,0.05);
        font-style: italic;
    }

    .stat-icon {
        text-align: center;
        margin-bottom: 5px;
    }

    .st-red {
        background-color: #F05050;
    }
    .st-green {
        background-color: #27C24C;
    }
    .st-violet {
        background-color: #7266ba;
    }
    .st-blue {
        background-color: #23b7e5;
    }

    .stats .stat-icon {
        color: #28bb9c;
        display: inline-block;
        font-size: 26px;
        text-align: center;
        vertical-align: middle;
        width: 50px;
        float:left;
    }

    .stat {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        margin-right: 10px; }
    .stat .value {
        font-size: 20px;
        line-height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500; }
    .stat .name {
        overflow: hidden;
        text-overflow: ellipsis; }
    .stat.lg .value {
        font-size: 26px;
        line-height: 28px; }
    .stat.lg .name {
        font-size: 16px; }
    .stat-col .progress {height:2px;}
    .stat-col .progress-bar {line-height:2px;height:2px;}

    .item {
        padding:30px 0;
    }
    .panel{
        border:none;
        border-radius: 6px;
    }

    .panel .bg-aqua-gradient{
        box-shadow: 1px 2px 2px rgba(0, 0, 0, 0.2);
    }

    .panel-title h5{
        font-size:15px;
    }
    .ibox-title h5{
        font-size:15px;
    }

    .lv{
        background:-webkit-gradient(linear,left bottom,left top,color-stop(0,#bce55f),color-stop(1,#86d391)) !important;
    }
    .lan{
        background:-webkit-gradient(linear,left bottom,left top,color-stop(0,#13c4fc),color-stop(1,#2fe5c2)) !important;
    }
    .fen{
        background:-webkit-gradient(linear,left bottom,left top,color-stop(0,#ff6e8f),color-stop(1,#fea59d)) !important;
    }
    .mo{
        background:-webkit-gradient(linear,left bottom,left top,color-stop(0,#9bc0dd),color-stop(1,#6499c2)) !important;
    }
    .cheng{
        background:-webkit-gradient(linear,left bottom,left top,color-stop(0,#fe8986),color-stop(1,#fead7e)) !important;
    }
    .zi{
        background:-webkit-gradient(linear,left bottom,left top,color-stop(0,#c59cfe),color-stop(1,#916fff)) !important;
    }
</style>
<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>

    </div>
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">

                <div class="row">
                    <?php if(empty($GLOBALS['city_id']) || (($GLOBALS['city_id'] instanceof \think\Collection || $GLOBALS['city_id'] instanceof \think\Paginator ) && $GLOBALS['city_id']->isEmpty())): ?>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient lan">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <h5>会员总数</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $totaluser; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient zi">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <!--<span class="label label-success pull-right"><?php echo __('Real time'); ?></span>-->
                                    <h5>待处理订单</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $totalorderwait; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient fen">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <!--<span class="label label-success pull-right"><?php echo __('Real time'); ?></span>-->
                                    <h5>总订单数</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $totalorder; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient mo">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <!--<span class="label label-success pull-right"><?php echo __('Real time'); ?></span>-->
                                    <h5>订单总收入</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $totalorderamount; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(empty($GLOBALS['city_id']) || (($GLOBALS['city_id'] instanceof \think\Collection || $GLOBALS['city_id'] instanceof \think\Paginator ) && $GLOBALS['city_id']->isEmpty())): ?>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient cheng">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <!--<span class="label label-success pull-right"><?php echo __('Real time'); ?></span>-->
                                    <h5>骑手已提现</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $rideramount; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient zi">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <!--<span class="label label-success pull-right"><?php echo __('Real time'); ?></span>-->
                                    <h5>骑手总数</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $ridernum; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 统计 -->
                <div class="row" style="margin-top:15px;">
                    <?php if(empty($GLOBALS['city_id']) || (($GLOBALS['city_id'] instanceof \think\Collection || $GLOBALS['city_id'] instanceof \think\Paginator ) && $GLOBALS['city_id']->isEmpty())): ?>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient lan">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <h5>今日新增用户</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $today_user; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient zi">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <h5>今日订单</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $today_order; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient fen">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <h5>今日收入</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $today_income; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient mo">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <h5>本周订单</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $week_order; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient cheng">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <h5>本周收入</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $week_income; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <div class="panel bg-aqua-gradient zi">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <h5>骑手今日提现</h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $today_tixian; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="height:38px;">
                    <div class="col-lg-12">
                        <div style="height:38px;width:100%;"><h4 style='text-align: center'>20天内订单数量统计</h4></div>
                    </div>
                </div>
                <div class="row" style="height:420px;">
                    <div class="col-lg-12">
                        <div id="echart" style="height:400px;width:100%;"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    var Orderdata = {
    column: <?php echo json_encode(array_keys($paylist)); ?>,
            createdata: <?php echo json_encode(array_values($createlist)); ?>,
            paydata: <?php echo json_encode(array_values($paylist)); ?>,
    };

</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
