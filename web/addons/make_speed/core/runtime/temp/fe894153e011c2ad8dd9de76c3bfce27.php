<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:111:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/order/order/tasking.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

                                <style>
    .profile-avatar-container {
        position:relative;
        width:100px;margin:0 auto;
    }
    .profile-avatar-container .profile-user-img{
        width:100px;
        height:100px;
    }
    .profile-avatar-container .profile-avatar-text {
        display:none;
    }
    .profile-avatar-container:hover .profile-avatar-text {
        display:block;
        position:absolute;
        height:100px;
        width:100px;
        background:#444;
        opacity: .6;
        color: #fff;
        top:0;
        left:0;
        line-height: 100px;
        text-align: center;
    }
    .profile-avatar-container button{
        position:absolute;
        top:0;left:0;width:100px;height:100px;opacity: 0;
    }

    .panel-body-myadd{
        padding:0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="row animated fadeInRight">
    <div class="col-sm-3" style="padding-right: 5px;">
        <div class="box box-success panel-body-myadd">
            <div class="panel-heading" style="padding-bottom: 0;">
                <?php if(empty($rider) || (($rider instanceof \think\Collection || $rider instanceof \think\Paginator ) && $rider->isEmpty())): ?>此订单附近暂无骑手<?php else: ?>选择骑手<?php endif; ?>
            </div>
            <div class="panel-body" style="padding-top:1px;">

                <form id="update-form" class="form-horizontal rider-detail-init" role="form" data-toggle="validator" method="POST" action="">
                    <div class="box-body box-profile">
                        <div class="profile-avatar-container" style="padding-bottom: 6px;">
                            <img class="profile-user-img img-responsive img-circle" src="/addons/make_speed/core/public//assets/img/avatar.png" alt="">
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">骑手姓名:</label>
                            <input type="text" class="form-control" value="未选择骑手" disabled />
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">手机号码:</label>
                            <input type="text" class="form-control" value="未选择骑手" data-rule="required;email" disabled />
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label">进行中订单:</label>
                            <input type="text" class="form-control" value="未选择骑手" data-rule="required" disabled />
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label">是否有惩罚记录:</label>
                            <input type="text" class="form-control" value="未选择骑手" data-rule="required" disabled />
                        </div>
                        <input type="hidden" name="rider_id" value="0" />
                        <input type="hidden" name="order_id" value="0" />
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm" disabled style="width:100%;">确认分配</button>
                        </div>
                    </div>
                </form>
                <?php if(!(empty($rider) || (($rider instanceof \think\Collection || $rider instanceof \think\Paginator ) && $rider->isEmpty()))): if(is_array($rider) || $rider instanceof \think\Collection || $rider instanceof \think\Paginator): if( count($rider)==0 ) : echo "" ;else: foreach($rider as $key=>$v): ?>
                <form id="update-form" class="form-horizontal rider-detail hide" data-title='骑手:<?php echo $v['real_name']; ?>' data-id="<?php echo $v['lat']; ?>-<?php echo $v['lng']; ?>" role="form" data-toggle="validator" method="POST" action="">
                    <div class="box-body box-profile">
                        <div class="profile-avatar-container" style="padding-bottom: 6px;">
                            <img class="profile-user-img img-responsive img-circle" src="<?php echo $v['avatar']; ?>" alt="">
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">骑手姓名:</label>
                            <input type="text" class="form-control" value="<?php echo $v['real_name']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">手机号码:</label>
                            <input type="text" class="form-control" value="<?php echo $v['mobile']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label">进行中订单:</label>
                            <input type="text" class="form-control" value="<?php echo $v['order_count']; ?>" data-rule="required" disabled />
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label">是否有惩罚记录:</label>
                            <input type="text" class="form-control" value="<?php echo $v['sanction']; ?>" data-rule="required" disabled />
                        </div>
                        <input type="hidden" name="rider_id" value="<?php echo $v['id']; ?>" />
                        <input type="hidden" name="order_id" value="<?php echo $v['order_id']; ?>" />
                        <input type="hidden" name="mobile" value="<?php echo $v['mobile']; ?>" />
                        <input type="hidden" name="real_name" value="<?php echo $v['real_name']; ?>" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm" style="width:100%;">确认分配</button>
                        </div>
                    </div>
                </form>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </div>
        </div>

    </div>
    <div class="col-sm-9" style="padding-left: 5px;">
        <div class="panel-body panel-body-myadd">
            <div id="map-container" style="width:100%; height:80%;"></div>
        </div>
    </div>
</div>



<!-- 腾讯地图 -->
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=<?php echo $tencenkey; ?>"></script>
<script src="/addons/make_speed/core/public//assets/libs/jquery/dist/jquery.min.js" type="text/javascript"></script>

<script>
    //初始化经纬度
    var init_lat = <?php echo $address['begin_lat']; ?>;
    var init_lng = <?php echo $address['begin_lng']; ?>;

    //点位坐标集合
    var latlngs = <?php echo json_encode($riderPoint); ?>;
</script>
<script>
$(function(){
    console.log($(window).height());

    $('#map-container').css('height',$(window).height() * 0.9);


    //实例化常用类
    var Map = qq.maps.Map;
    var Marker = qq.maps.Marker;
    var LatLng = qq.maps.LatLng;
    var Event = qq.maps.event;

    var MarkerImage = qq.maps.MarkerImage;
    var MarkerShape = qq.maps.MarkerShape;
    var MarkerAnimation = qq.maps.MarkerAnimation;
    var Point = qq.maps.Point;
    var Size = qq.maps.Size;
    var ALIGN = qq.maps.ALIGN;

    var MVCArray = qq.maps.MVCArray;
    var MarkerCluster = qq.maps.MarkerCluster;
    var Cluster = qq.maps.Cluster;
    var MarkerDecoration = qq.maps.MarkerDecoration;

    var markers = new MVCArray();

    var data = [];

    $.each(latlngs,function(i,v){
        data.push([v.lat,v.lng]);
    });


    //自定义Overlay代码开始 =================================================

    //声明类,opts为类属性，初始化时传入（非必须，看实际需求）
    var myOverlay=function(opts){
        qq.maps.Overlay.call(this, opts);
    };
    //继承Overlay基类
    myOverlay.prototype = new qq.maps.Overlay();
    //实现构造方法
    myOverlay.prototype.construct = function() {

        //创建了覆盖物的容器，这里我用了一个div，并且设置了样式
        this.dom = document.createElement('div');
        this.dom.style.cssText =
            'background:#fff;color:white;position:absolute;' +
            'text-align:center;width:30px;height:30px;'+
            'border-radius:50%;border:2px solid #fff';

        //将初始化的html填入到了窗口里，这根据您自己的需要决定是否加这属性
        this.dom.innerHTML=this.get('inithtml');

        //将dom添加到覆盖物层
        this.getPanes().overlayLayer.appendChild(this.dom);
    };

    //自定义的方法，用于设置myOverlay的html
    myOverlay.prototype.html=function(html){
        this.dom.innerHTML=html;
    };
    //实现绘制覆盖物的方法（覆盖物的位置在此控制）
    myOverlay.prototype.draw = function() {
        //获取地理经纬度坐标
        var position = this.get('position');
        if (position) {
            var pixel = this.getProjection().fromLatLngToDivPixel(position);
            this.dom.style.left = pixel.getX() + 'px';
            this.dom.style.top = pixel.getY() + 'px';
        }
    };
    //实现析构方法（类生命周期结束时会自动调用，用于释放资源等）
    myOverlay.prototype.destroy = function() {
        //移除dom
        this.dom.parentNode.removeChild(this.dom);
    };
    //以上自定义Overlay代码结束 =================================================


    //加载地图
    var map = new qq.maps.Map(document.getElementById("map-container"), {
        center: new qq.maps.LatLng(init_lat,init_lng),
        zoom:13
    });

    //点位图标
    var anchor1 = new qq.maps.Point(10, 30),
        size1 = new qq.maps.Size(26, 32),
        scaleSize1 = new qq.maps.Size(26, 32),
        origin1 = new qq.maps.Point(0, 0),
        icon1 = new qq.maps.MarkerImage("/addons/make_speed/core/public//uploads/program_icon/client/start.png", size1, origin1, anchor1,scaleSize1);



        var marker1 = new qq.maps.Marker({
            icon: icon1,
//            shadow: shadow,
            map: map,
            position:new qq.maps.LatLng(init_lat,init_lng)
//            animation: qq.maps.MarkerAnimation.BOUNCE
        });


    //窗口实例化
    var infoWin = new qq.maps.InfoWindow({
        map: map
    });


    //点位图标
    var anchor = new qq.maps.Point(10, 20),
        size = new qq.maps.Size(30, 25),
        scaleSize = new qq.maps.Size(30, 25),
        origin = new qq.maps.Point(0, 0),
        icon = new qq.maps.MarkerImage("/addons/make_speed/core/public//"+"<?php echo $ridericon; ?>", size, origin, anchor,scaleSize);

    //多个点位添加图标
    for (var n = 0; n < data.length; n++) {
        (function(i){
            var latLng = new LatLng(data[i][0], data[i][1]);
            var decoration = new MarkerDecoration(i, new Point(0, -5));
            var marker = new Marker({
                icon: icon,
                'position':latLng,
                map:map
            });

            var infoWin = new qq.maps.InfoWindow({
                map: map
            });

            $('.rider-detail').each(function(r){
                //相同显示,不相同隐藏
                if( $(this).attr('data-id') === latLng.lat+'-'+latLng.lng ){
                    infoWin.open();
                    infoWin.setContent('<div style="text-align:center;white-space:'+
                            'nowrap;margin:10px;">'+$(this).attr('data-title')+'</div>');
                    infoWin.setPosition(latLng);
                }

            })




            //点位点击事件
            qq.maps.event.addListener(marker, 'click', function(res) {
                //骑手信息展示
                //骑手信息展示
                $('.rider-detail').each(function(r){
                    //相同显示,不相同隐藏
                    if( $(this).attr('data-id') === res.latLng.lat+'-'+res.latLng.lng ){
                        infoWin.open();
                        infoWin.setContent('<div style="text-align:center;white-space:'+
                            'nowrap;margin:10px;">'+$(this).attr('data-title')+'</div>');
                        infoWin.setPosition(latLng);

                        $(this).removeClass('hide');
                        $('.rider-detail-init').hasClass('hide') || $('.rider-detail-init').addClass('hide');
                    }else{
                        $(this).hasClass('hide') || $(this).addClass('hide');
                    }

                })

            });


            markers.push(marker);
        })(n);
    }

    //去掉腾讯地图logo等小部件
    $("#map-container").bind("DOMNodeInserted",function(e){
        var length = $("#map-container div:first-child").children('div').length;
        $("#map-container > div > div").not(":first").remove();
    });

    //关闭门店详情
    $('.close-detail').on('click',function(){
        $(this).parent('.store-detail').removeClass('detail-show');
        $(this).parent('.store-detail').addClass('detail-hide');
    })

});
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
