define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'busines/business/index',
                    add_url: 'busines/business/add',
                    edit_url: 'busines/business/edit',
                    del_url: 'busines/business/del',
                    multi_url: 'busines/business/multi',
                    price_url: 'busines/business/price',
                    rider_url: 'busines/business/rider',
                    person_url: 'busines/business/person',
                    detail_url: 'busines/business/detail',
                    table: 'business'
                }
            });

            var eventBtn = [];
            eventBtn['click .btn-price'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.price_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), '计费规则', {area:[$(window).width() > 950 ? '1200px' : '90%', $(window).height() > 700 ? '730px' : '95%']} );
            };
            eventBtn['click .btn-person'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.person_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), '添加店员', $(this).data() || {});
            };
            eventBtn['click .btn-rider'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.rider_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), '分配骑手', $(this).data() || {area:[$(window).width() > 950 ? '930px' : '95%', $(window).height() > 700 ? '730px' : '95%']});
            };
            eventBtn['click .btn-edit'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.edit_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), '编辑', $(this).data() || {});
            };
            eventBtn['click .btn-detail'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.detail_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), '详情', $(this).data() || {});
            };


            var table = $("#table");
            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 名称/电话";};
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user', title: __('User_id'), operate:false},
                        {field: 'name', title: __('Name')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'orders_count', title: '下单总数', width:100, operate:'BETWEEN'},
                        {field: 'valid', title: __('Valid'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'),searchList:{0:__('Status 0'),1:__('Status 1'),2:__('Status 2')}, custom:{0:'primary',1:'danger',2:'success'}, formatter:Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), width:'290px', table: table,  events: $.extend(eventBtn ,Table.api.events.operate || []),
                            buttons: [{
                                name: 'price',
                                icon: 'fa fa-jpy',
                                title: '计费规则',
                                text: '计费',
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-price',
                                url: $.fn.bootstrapTable.defaults.extend.price_url
                            },
                            {
                                name: 'person',
                                icon: 'fa fa-user-plus',
                                title: '添加店员',
                                text:'店员',
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-info btn-person',
                                url: $.fn.bootstrapTable.defaults.extend.person_url
                            },
                            {
                                name: 'rider',
                                icon: 'fa fa-motorcycle',
                                title: '分配骑手',
                                text:'骑手',
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-info btn-rider',
                                url: $.fn.bootstrapTable.defaults.extend.rider_url
                            },
                            {
                                name: 'edit',
                                icon: 'fa fa-edit',
                                title: '编辑',
                                text:'编辑',
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-success btn-edit',
                                url: $.fn.bootstrapTable.defaults.extend.edit_url
                            },
                            {
                                name: 'detail',
                                icon: 'fa fa-list',
                                title: '详情',
                                text:'',
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-detail',
                                url: $.fn.bootstrapTable.defaults.extend.detail_url
                            }
                            ],
                        formatter: Table.api.formatter.operate}
                    ]
                ]
            });


            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $('#get-address').click(function (e) {
                e.preventDefault();
                var init_lat = 1 * $("input[name='row[lat]']").val();
                var init_lng = 1 * $("input[name='row[lng]']").val();

                if(!init_lat) init_lat = 22.83393;
                if(!init_lng) init_lng = 108.31343;
                var layerMap = null;
                var geocoder = null;
                layerMap = layer.open({
                    type   : 1,
                    title  : '选择位置',
                    zIndex : 9999999999,
                    area   : ['90%','90%'],
                    maxmin : true,
                    shadeClose:false,
                    content:' <input id="search-text" class="form-control address-search-text" name="search-text" type="text">' +
                    '<button class="btn btn-success address-search-btn" id="search-btn">搜索地址</button>' +
                    '<span class="help-block" style="display: inline;"><i class="fa fa-info-circle mr-xs"></i>地图上选点后关闭即可</span>' +
                    '<div id="map-container" style="width:100%; height:100%;"></div>',
                    success: function(layero, index){
                        //加载地图
                        var map = new qq.maps.Map(document.getElementById("map-container"), {
                            center: new qq.maps.LatLng(init_lat,init_lng),
                            zoom:14
                        });

                        var anchor = new qq.maps.Point(30, 30);
                        var size = new qq.maps.Size(42, 50);
                        var origin = new qq.maps.Point(0, 0);
                        var scaleSize = new qq.maps.Size(42, 50);

                        var icon = new qq.maps.MarkerImage(upload_img_url+'business_icon.png', size, origin, anchor, scaleSize);

                        size = new qq.maps.Size(52, 30);
                        var originShadow = new qq.maps.Point(32, 0);
                        var shadow =new qq.maps.MarkerImage(
                            upload_img_url+'business_icon.png',
                            size,
                            originShadow,
                            anchor,
                            scaleSize
                        );

                        var marker = new qq.maps.Marker({
                            icon: icon,
                            shadow: shadow,
                            map: map,
                            position:new qq.maps.LatLng(init_lat,init_lng)
                        });

                        //调用地址解析类
                        geocoder = new qq.maps.Geocoder({
                            complete : function(result){
                                console.log(result);
                                marker.setMap(null);
                                map.setCenter(result.detail.location);
                                marker = new qq.maps.Marker({
                                    icon: icon,
                                    shadow: shadow,
                                    map:map,
                                    position: result.detail.location
                                });

                                $('input[name="search-text"]').val(result.detail.address);
                                //赋值表单
                                $('input[name="row[lat]"]').val(result.detail.location.lat);
                                $('input[name="row[lng]"]').val(result.detail.location.lng);
                                $('input[name="row[address]').val(result.detail.address);

                                $('#search-btn').text('搜索地址');
                            },
                            error : function(result){
                                alert('搜索失败！请输入准确地址');
                                $('#search-btn').text('搜索地址');
                            }
                        });

                        qq.maps.event.addListener(
                            map,
                            'click',
                            function(event) {
                                console.log(event);
                                marker.setPosition(event.latLng);
                                $('#search-btn').text('搜索中..');
                                geocoder.getAddress(event.latLng);
                            }
                        );

                        //去掉腾讯地图logo等小部件
                        $("#map-container").bind("DOMNodeInserted",function(e){
                            var length = $("#map-container div:first-child").children('div').length;
                            $("#map-container > div > div").not(":first").remove();
                        });

                        //搜索地址
                        $('#search-btn').click(function(){
                            console.log('搜索...');
                            $('#search-btn').text('搜索中..');
                            var addre = $('input[name="search-text"]').val();
                            geocoder.getLocation(addre);
                        })

                    }
                })


            });

            Controller.api.bindevent();
        },
        edit: function () {
            $('#edit-form').validator({
                ignore: ':hidden'
            });

            var val = $("input[type='radio']:checked").val();
            if(val == 1){
                $("#pcau").removeClass('hide');
                $("#pcau").show();
            }

            $(':radio').click(function(){
                var value = $(this).val();
                if(value == 1){
                    $("#pcau").removeClass('hide');
                    $("#pcau").show();
                }else{
                    $("#pcau").hide();
                }
            });

            $('#get-address').click(function (e) {
                e.preventDefault();
                var init_lat = 1 * $("input[name='row[lat]']").val();
                var init_lng = 1 * $("input[name='row[lng]']").val();

                if(!init_lat) init_lat = 22.83393;
                if(!init_lng) init_lng = 108.31343;
                var layerMap = null;
                var geocoder = null;
                layerMap = layer.open({
                    type   : 1,
                    title  : '选择位置',
                    zIndex : 9999999999,
                    area   : ['90%','90%'],
                    maxmin : true,
                    shadeClose:false,
                    content:' <input id="search-text" class="form-control address-search-text" name="search-text" type="text" value="'+addresstext+'">' +
                    '<button class="btn btn-success address-search-btn" id="search-btn">搜索地址</button>' +
                    '<span class="help-block" style="display: inline;"><i class="fa fa-info-circle mr-xs"></i>地图上选点后关闭即可</span>' +
                    '<div id="map-container" style="width:100%; height:100%;"></div>',
                    success: function(layero, index){
                        //加载地图
                        var map = new qq.maps.Map(document.getElementById("map-container"), {
                            center: new qq.maps.LatLng(init_lat,init_lng),
                            zoom:14
                        });

                        var anchor = new qq.maps.Point(30, 30);
                        var size = new qq.maps.Size(42, 50);
                        var origin = new qq.maps.Point(0, 0);
                        var scaleSize = new qq.maps.Size(42, 50);

                        var icon = new qq.maps.MarkerImage(upload_img_url+'business_icon.png', size, origin, anchor, scaleSize);

                        size = new qq.maps.Size(52, 30);
                        var originShadow = new qq.maps.Point(32, 0);
                        var shadow =new qq.maps.MarkerImage(
                            upload_img_url+'business_icon.png',
                            size,
                            originShadow,
                            anchor,
                            scaleSize
                        );

                        var marker = new qq.maps.Marker({
                            icon: icon,
                            shadow: shadow,
                            map: map,
                            position:new qq.maps.LatLng(init_lat,init_lng)
                        });

                        //调用地址解析类
                        geocoder = new qq.maps.Geocoder({
                            complete : function(result){
                                console.log(result);
                                marker.setMap(null);
                                map.setCenter(result.detail.location);
                                marker = new qq.maps.Marker({
                                    icon: icon,
                                    shadow: shadow,
                                    map:map,
                                    position: result.detail.location
                                });

                                $('input[name="search-text"]').val(result.detail.address);
                                //赋值表单
                                $('input[name="row[lat]"]').val(result.detail.location.lat);
                                $('input[name="row[lng]"]').val(result.detail.location.lng);
                                $('input[name="row[address]').val(result.detail.address);

                                $('#search-btn').text('搜索地址');
                            },
                            error : function(result){
                                alert('搜索失败！请输入准确地址');
                                $('#search-btn').text('搜索地址');
                            }
                        });

                        qq.maps.event.addListener(
                            map,
                            'click',
                            function(event) {
                                console.log(event);
                                marker.setPosition(event.latLng);
                                $('#search-btn').text('搜索中..');
                                geocoder.getAddress(event.latLng);
                            }
                        );

                        //去掉腾讯地图logo等小部件
                        $("#map-container").bind("DOMNodeInserted",function(e){
                            var length = $("#map-container div:first-child").children('div').length;
                            $("#map-container > div > div").not(":first").remove();
                        });

                        //搜索地址
                        $('#search-btn').click(function(){
                            console.log('搜索...');
                            $('#search-btn').text('搜索中..');
                            var addre = $('input[name="search-text"]').val();
                            geocoder.getLocation(addre);
                        })

                    }
                })


            });

            Controller.api.bindevent();
        },
        price: function () {
            $("#edit-form").on("click",'.add',function(){
                var groupDOM = $(this).closest(".addgroup");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#edit-form").on("click",'.del',(function(){
                var groupCount = $(".addgroup").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addgroup");
                groupDOM.remove();
            }))

            $("#edit-form").on("click",'.addPrice',function(){
                var groupDOM = $(this).closest(".addNightPrice");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
                Controller.api.bindevent();
            })
            $("#edit-form").on("click",'.delPrice',(function(){
                var groupCount = $(".addNightPrice").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addNightPrice");
                groupDOM.remove();
            }))
            Controller.api.bindevent();
        },

        person: function(){
            Controller.api.bindevent();
        },
        detail: function () {
            $('.del-personnel').click(function (e) {

                var btnelem = $(this);

                var username = $(this).attr('data-name');
                var pid = $(this).attr('data-personid');

                Layer.confirm('是否确认删除店员“'+username+'”', {icon: 3, title:'提示'}, function(index){

                    $.post('busines/business/delperson',{id:pid},function(res){
                        if(res.code===0){
                            Toastr.success(res.msg);
                            btnelem.parents('.form-group').remove();

                        }else{
                            Toastr.error(res.msg);
                        }

                    });

                    Layer.close(index);
                });



            })
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});