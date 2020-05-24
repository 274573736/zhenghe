<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:117:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/person/rider/order_detail.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

                                
<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#sms" data-toggle="tab">接单历史</a></li>
            <li><a href="#count" data-toggle="tab">统计</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="sms">
                <button class="btn btn-success" type="button">
                    今日订单 <span class="badge"><?php echo $today_orderNum; ?></span>
                </button>
                <button class="btn btn-info" type="button">
                    今日收入 <span class="badge"><?php echo $today_amount; ?></span>
                </button>
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 8%">订单id</th>
                        <th style="width: 8%">订单类型</th>
                        <th style="width: 10%">订单状态</th>
                        <th>接单时间</th>
                        <th>取件时间</th>
                        <th>送达时间</th>
                        <th>起始地址</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(($list)): foreach($list as $v): ?>
                    <tr>
                        <th scope="row" style="text-align: left;vertical-align: middle;width: 100px;"><?php echo $v['id']; ?></th>
                        <td style="text-align: left;vertical-align: middle;width: 100px;">
                        <?php switch($v['type']): case "0": ?>跑腿<?php break; case "1": ?>帮买<?php break; case "2": ?>万能服务<?php break; case "3": ?>代驾<?php break; case "5": ?>货运<?php break; case "6": ?>家政<?php break; endswitch; ?>
                        </td>
                        <td style="text-align: left;vertical-align: middle;width: 100px;">
                            <?php switch($v['status']): case "3": ?>待取件<?php break; case "4": ?>待送达<?php break; case "5": ?>已送达<?php break; case "6": ?>已送达<?php break; default: ?>其他
                            <?php endswitch; ?>
                        </td>
                        <td style="text-align: left;vertical-align: middle;width: 100px;"><?php echo datetime($v['accept_time']); ?></td>
                        <td style="text-align: left;vertical-align: middle;width: 100px;"><?php echo !empty($v['get_time'])?date("Y-m-d H:i:s",$v['get_time'])  : '未取件'; ?></td>
                        <td style="text-align: left;vertical-align: middle;width: 100px;"><?php echo !empty($v['goto_time'])?date("Y-m-d H:i:s",$v['goto_time']) : '未送达'; ?></td>
                        <td style="text-align: left;vertical-align: middle;width: 100px;">
                            <span style="color:#3498E2">起</span>
                            <span><?php echo isset($v['begin_address'])?$v['begin_address']: '无'; ?></span>
                            <br>
                            <span style="color: #E74C3C">终</span>
                            <span><?php echo isset($v['end_address'])?$v['end_address']: '无'; ?></span>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
                <?php echo $list->render(); ?>


            </div>
            <div class="tab-pane fade" id="count">
                <div class="box box-danger">

                    <div class="box-body">
                        <div id="order_count" style="height: 265px; width: 800px;" >

                        </div>
                        <div id="amountCount" style="height: 265px; width: 800px;margin-top: 30px">

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
    </div>
</div>

<script src="/addons/make_speed/core/public/assets/js/echarts.min.js"></script>
<script type="text/javascript">
    orderCount();
    amountCount();

    function orderCount(){
        var orderCount = echarts.init(document.getElementById('order_count'));

        var option = {
            title: {
                text: '骑手接单统计',
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: ['总订单', '今日订单', '本周订单','本月订单','上月订单']
            },
            series: [
                {
                    name: '订单统计',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '60%'],
                    data: [
                        {value: <?php echo $total_orderNum; ?>, name: '总订单'},
                        {value: <?php echo $today_orderNum; ?>, name: '今日订单'},
                        {value: <?php echo $week_orderNum; ?>, name: '本周订单'},
                        {value: <?php echo $month_orderNum; ?>, name: '本月订单'},
                        {value: <?php echo $last_month; ?>, name: '上月订单'}
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        orderCount.setOption(option);
    }

    function amountCount(){
        var amountCount = echarts.init(document.getElementById('amountCount'));

        var option = {
            title: {
                text: '骑手收入统计',
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: ['总收入', '今日收入', '本周收入','本月收入','上月收入']
            },
            series: [
                {
                    name: '收入统计',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '60%'],
                    data: [
                        {value: <?php echo $total_amount; ?>, name: '总收入'},
                        {value: <?php echo $today_amount; ?>, name: '今日收入'},
                        {value: <?php echo $week_amount; ?>,  name: '本周收入'},
                        {value: <?php echo $month_amount; ?>, name: '本月收入'},
                        {value: <?php echo $lastMonthAmount; ?>,name: '上月收入'}
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        amountCount.setOption(option);
    }

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
