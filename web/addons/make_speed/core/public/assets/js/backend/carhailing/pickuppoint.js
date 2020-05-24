define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'carhailing/pickup_point/index' + location.search,
                    add_url: 'carhailing/pickup_point/add',
                    edit_url: 'carhailing/pickup_point/edit',
                    del_url: 'carhailing/pickup_point/del',
                    table: 'car_pickup_point',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'city_id', title: __('City_id'),formatter(val,row,index){
                                if(row.city){
                                    return row.city.name;
                                }
                            }
                        },
                        {field: 'address', title: __('Address')},
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"0":__('Status 0')}, formatter: Table.api.formatter.status},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $('#get-address').click(function (e) {
                e.preventDefault();
                var init_lat = 1 * $("input[name='row[latitude]']").val();
                var init_lng = 1 * $("input[name='row[longitude]']").val();

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
                    content:' <input id="search-text" style="width: 200px;" class=" address-search-text" name="search-text" type="text">' +
                        '<button class="btn btn-success address-search-btn" style="margin-left:20px" id="search-btn">搜索地址</button>' +
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

                        var icon = new qq.maps.MarkerImage(
                            'https://t.xiaomawei.com/addons/make_speed/core/public//uploads/program_icon/business_icon.png',
                            size, origin, anchor, scaleSize);
                        size = new qq.maps.Size(52, 30);
                        var originShadow = new qq.maps.Point(32, 0);
                        var shadow =new qq.maps.MarkerImage(
                            'https://t.xiaomawei.com/addons/make_speed/core/public//uploads/program_icon/business_icon.png',
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

                                var street = result.detail.addressComponents.street == 'undefined' ? '' :result.detail.addressComponents.street;
                                var streetNumber = typeof(result.detail.addressComponents.streetNumber) == 'undefined' ?  '' :result.detail.addressComponents.streetNumber;
                                $('input[name="search-text"]').val(result.detail.address);
                                //赋值表单
                                $('input[name="row[latitude]"]').val(result.detail.location.lat);
                                $('input[name="row[longitude]"]').val(result.detail.location.lng);
                                $('input[name="row[address]').val(street+streetNumber);

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
            $('#get-address').click(function (e) {
                e.preventDefault();
                var init_lat = 1 * $("input[name='row[latitude]']").val();
                var init_lng = 1 * $("input[name='row[longitude]']").val();

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
                    content:' <input id="search-text" style="width: 200px;" class=" address-search-text" name="search-text" type="text">' +
                        '<button class="btn btn-success address-search-btn" style="margin-left:30px" id="search-btn">搜索地址</button>' +
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

                        var icon = new qq.maps.MarkerImage(
                            'https://t.xiaomawei.com/addons/make_speed/core/public//uploads/program_icon/business_icon.png',
                            size, origin, anchor, scaleSize);
                        size = new qq.maps.Size(52, 30);
                        var originShadow = new qq.maps.Point(32, 0);
                        var shadow =new qq.maps.MarkerImage(
                            'https://t.xiaomawei.com/addons/make_speed/core/public//uploads/program_icon/business_icon.png',
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
                                $('input[name="row[latitude]"]').val(result.detail.location.lat);
                                $('input[name="row[longitude]"]').val(result.detail.location.lng);
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});