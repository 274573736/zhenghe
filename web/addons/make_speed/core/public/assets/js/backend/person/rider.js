define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/rider/index',
                    add_url: 'person/rider/add',
                    edit_url: 'person/rider/edit',
                    detail_url: 'person/rider/detail',
                    del_url: 'person/rider/del',
                    multi_url: 'person/rider/multi',
                    order_url:'person/rider/riderorder',
                    order_detail:'person/rider/order_detail',
                    table: 'rider',
                }
            });

            //扩展行按钮点击事件
            var eventBtn = [];
            eventBtn['click .btn-detailone'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.detail_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('Detail'), $(this).data() || {});
            };
            eventBtn['click .btn-order_detail'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.order_detail;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('Detail'), $(this).data() || {});
            };
            var table = $("#table");
            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 姓名/手机号";};
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'nick_name', title: '用户昵称',align:'left',width:100,formatter:Controller.api.formatter.name,},
                        {field: 'real_name', title: __('Real_name')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'recommend_name', title:'推荐人', formatter:Controller.api.formatter.recommend},
                        {field: 'valid_money', title: __('Valid_money'), operate:'BETWEEN',sortable: true},
                        {field: 'bond_money', title: '保证金',width:60},
                        {field: 'info.service_total', title: '已服务次数', operate:'BETWEEN',formatter:Controller.api.formatter.totalorder},
                        {field: 'info.is_accept', title: '接单状态', operate:'BETWEEN',formatter:function(val,row,index){
                                if(val == 1){
                                    return "<span class=\"label label-primary\">听单中</span>";
                                }
                                return "<span class=\"label label-danger\">已下线</span>";
                            }
                        },

                        {field: 'user_grade', title: __('Grade'), searchList:{0:__('Grade 0'),1:__('Grade 1'),2:__('Grade 2'),3:__('Grade 3')},custom:{0:'primary', 1:'primary',2:'info',3:'danger'}, formatter:Table.api.formatter.flag},
                        {field: 'status', title: __('Status'), searchList:{0:__('Status 0'),1:__('Status 1'),2:__('Status 2')}, custom:{0:'primary',1:'danger',2:'success'}, formatter:Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: $.extend(eventBtn ,Table.api.events.operate || []),
                            buttons: [
                                {
                                    name: 'detail',
                                    icon: 'fa fa-calendar-o',
                                    title: __('接单列表'),
                                    extend: 'data-toggle="tooltip"',
                                    classname: 'btn btn-xs btn-primary btn-order_detail',
                                    url: $.fn.bootstrapTable.defaults.extend.order_detail
                                },
                                {
                                name: 'detail',
                                icon: 'fa fa-list',
                                title: __('Detail'),
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-detailone',
                                url: $.fn.bootstrapTable.defaults.extend.detail_url
                                }
                            ],

                        formatter: Table.api.formatter.operate}

                    ]
                ]
            });

            

            // 为表格绑定事件
            Table.api.bindevent(table);

            //当双击单元格时
            table.on('dbl-click-row.bs.table', function (e, row, element, field) {
                $('.btn-detailone', element).trigger("click");
            });



        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {

            Controller.api.bindevent();
        },
        riderorder:function(e){
            var rider_id = $('#order-rider-id').val();
            // 初始化表格参数配置
            Table.api.init({
                //关闭双击编辑
                dblClickToEdit: false,

                extend: {
                    index_url: 'person/rider/riderorder',
                    detail_url: 'order/order/detail',
                    multi_url: 'order/order/multi',
                    tasking_url: 'order/order/tasking',
                    table: 'order',
                }
            });


            //扩展行按钮点击事件
            var eventBtn = [];

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索订单号";};

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url+'/rider_id/'+rider_id,
                pk: 'id',
                sortName: 'id',
                commonSearch: false,
                formatSearch:false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'cityname', title: __('City_id'), width:120, operate:'LIKE'},
                        {field: 'order_code', title: __('Order_code')},
                        {field: 'username', title: __('User_id'),width:150, operate:'LIKE'},
                        {field: 'goodsname', title: __('Goods_id'), width:120, formatter:Controller.api.formatter.goods, operate:'LIKE'},
                        {field: 'distance', title: __('Distance'),width:90, formatter:Controller.api.formatter.distance, operate:'BETWEEN'},
                        {field: 'pay_price', title: __('Pay_price'),width:120, formatter:Controller.api.formatter.payPrice, operate:'BETWEEN'},
                        {field: 'begin_address', title: '起始地点', align:'left', operate:'LIKE', formatter:Controller.api.formatter.address},
                        {field: 'status', title: __('Status'),width:130,searchList:{0:__('Statuso 0'),1:__('Statuso 1'),2:__('Statuso 2'),3:__('Statuso 3'),4:__('Statuso 4'),5:__('Statuso 5'),6:__('Statuso 6')},formatter:Controller.api.formatter.ostatus},
                        {field: 'operate', title: __('Operate'), table: table, events: $.extend(eventBtn ,Table.api.events.operate || []),
                            buttons: [],

                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 绑定TAB事件
            $('.panel-heading a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var field = $(this).closest("ul").data("field");
                var value = $(this).data("value");
                var options = table.bootstrapTable('getOptions');
                options.pageNumber = 1;
                options.queryParams = function (params) {
                    var filter = {};
                    if (value !== '') {
                        filter[field] = value;
                    }
                    params.filter = JSON.stringify(filter);
                    return params;
                };

                table.bootstrapTable('refresh', {});
                return false;
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

            //当双击单元格时
            table.on('dbl-click-row.bs.table', function (e, row, element, field) {
                $('.btn-detailone', element).trigger("click");
            });


        },

        api: {
            formatter:{
                name:function(value, row, index){
                    row.avatar = row.avatar ? row.avatar : '/assets/img/avatar.png';
                    var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                    return '<a href="' + Fast.api.cdnurl(row.avatar) + '" target="_blank"><img class="' + classname + '" src="' + Fast.api.cdnurl(row.avatar) + '" /></a>'+'&nbsp;&nbsp;'+ row.nick_name;
                },
                sex:function(value, row, index){
                    return value ? '<span class="text-info">男</span>' : '<span class="text-danger">女</span>';
                },
                recommend:function(value, row, index){
                    if(value!==null) {
                        return value;
                    }else{
                        return '无';
                    }
                },

                totalorder:function(value, row, index){

                    html = '<a href="'+ $.fn.bootstrapTable.defaults.extend.order_url +'/rider_id/'+row.id+'" class="btn btn-dialog">' + value + '</a>';

                    return html;

                },

                address:function(value, row, index){
                    var color = 'primary';
                    value = value === null ? '' : value.toString();
                    if (value === '')
                        value='无';

                    var html = '<span class="">起：</span><span>' + row.begin_address + '</span>'
                        + '<br><span class="">终：</span><span>' + row.end_address + '</span>';

                    return html;
                },

                ostatus:function(value, row, index){
                    var colorArr = ["primary", "success", "danger", "warning", "info", "gray", "red", "yellow", "aqua", "blue", "navy", "teal", "olive", "lime", "fuchsia", "purple", "maroon"];

                    var custom = {};
                    if (typeof this.custom !== 'undefined') {
                        custom = $.extend(custom, this.custom);
                    }
                    value = value === null ? '' : value.toString();
                    var keys = typeof this.searchList === 'object' ? Object.keys(this.searchList) : [];
                    var index = keys.indexOf(value);
                    var color = value && typeof custom[value] !== 'undefined' ? custom[value] : null;
                    var display = index > -1 ? this.searchList[value] : null;
                    var icon = typeof this.icon !== 'undefined' ? this.icon : null;

                    if (!color) {
                        color = index > -1 && typeof colorArr[index] !== 'undefined' ? colorArr[index] : 'primary';
                    }
                    if (!display) {
                        display = __(value.charAt(0).toUpperCase() + value.slice(1));
                    }
                    var html = '<span class="text-' + color + '">' + (icon ? '<i class="' + icon + '"></i> ' : '') + display + '</span>';
                    return html;
                }
            },

            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };

    $('#settle-btn').click(function(e){
        e.preventDefault();
        var id = $('input[name=riderid]').val();
        Fast.api.ajax('person/rider/settle?id='+id,function(res){
            console.log(res);

        });
        return false;
    });

    $('#usettle-btn').click(function(e){
        e.preventDefault();
        var id = $('input[name=riderid]').val();
        Fast.api.ajax('person/rider/settle?type=1&id='+id,function(res){
            console.log(res);

        });
        return false;
    });

    $('.riderorder').click(function(e){
        e.preventDefault();
        console.log('点击点击');
    });

    return Controller;
});