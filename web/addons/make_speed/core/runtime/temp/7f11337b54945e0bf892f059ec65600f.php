<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:111:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/setting/theme/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
    .theme-icon{
        position: absolute;
        left: 230px;
        bottom: 18px;
        font-size: 88px;
        color: #1AAD19;
        display: none;
    }

    .theme-img{
        box-shadow:0 2px 10px rgba(0, 0, 0, 0.2);
        width:320px;
        height:600px;
        border: solid 9px #ffffff;
        border-radius: 12px;
    }

    .theme-img:hover{
        border: solid 10px #1AAD19;
        border-radius: 15px;
    }

    .theme-img-selected{
        border-radius: 15px;
        border: solid 10px #1AAD19;
    }
</style>

<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">小程序首页主题设置</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="home">
                <form id="ssl-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="theme/save">

                    <div class="form-group">
                        <label class="col-sm-1 control-label">选择主题：</label>
                        <div class="col-sm-3 theme">
                            <img src="/addons/make_speed/core/public/uploads/theme/theme_0.jpg" alt="主题一" data-id="0" class="theme-img <?php if(empty($theme_index) || (($theme_index instanceof \think\Collection || $theme_index instanceof \think\Paginator ) && $theme_index->isEmpty())): ?>theme-img-selected<?php endif; ?>">
                            <i class="fa fa-check-square-o theme-icon" aria-hidden="true" <?php if(empty($theme_index) || (($theme_index instanceof \think\Collection || $theme_index instanceof \think\Paginator ) && $theme_index->isEmpty())): ?>style="display:block"<?php endif; ?>></i>
                        </div>

                        <div class="col-sm-3 theme">
                            <img src="/addons/make_speed/core/public/uploads/theme/theme_1.jpg" alt="主题二" data-id="1" class="theme-img <?php if($theme_index == '1'): ?>theme-img-selected<?php endif; ?>">
                            <i class="fa fa-check-square-o theme-icon" aria-hidden="true" <?php if($theme_index == '1'): ?>style="display:block"<?php endif; ?>></i>
                        </div>

                        <div class="col-sm-3 theme">
                            <img src="/addons/make_speed/core/public/uploads/theme/theme_2.jpg" alt="主题三" data-id="2" class="theme-img <?php if($theme_index == '2'): ?>theme-img-selected<?php endif; ?>">
                            <i class="fa fa-check-square-o theme-icon" aria-hidden="true" <?php if($theme_index == '2'): ?>style="display:block"<?php endif; ?>></i>
                        </div>

                    </div>

                    <input type="hidden" name="themeid" value="" />

                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12 col-sm-2"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<script src="/addons/make_speed/core/public//assets/libs/jquery/dist/jquery.min.js" type="text/javascript"></script>

<script>
    $(function(){

        $('.theme img').click(function(e){

            var id = $(this).attr('data-id');

            $('.theme img').removeClass('theme-img-selected');

            $('.theme i').css('display','none');
            $(this).next().css('display','block');
            $(this).addClass('theme-img-selected');

            $("input[name=themeid]").val(id);

        })

    })
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
