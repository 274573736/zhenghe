define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'freight/order/index' + location.search,
                    add_url: 'freight/order/add',
                    edit_url: 'freight/order/edit',
                    del_url: 'freight/order/del',
                    detail_url:'freight/order/detail',
                    assign_url: 'freight/order/assignDriver',
                    table: 'order',
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
            eventBtn['click .btn-tasking'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.assign_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('分配司机'), $(this).data() || {});
            };

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索订单号";};

            var table = $("#table");
            table.on('post-common-search.bs.table', function (event, table) {
                var form = $("form", table.$commonsearch);
                $("input[name='order_rider']", form).addClass("selectpage").data("source", "person.rider/index").data("primaryKey", "id").data("field", "real_name").data("orderBy", "id desc");
                Form.events.cxselect(form);
                Form.events.selectpage(form);
            });

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'order_code', title: __('Order_code')},
                        {field: 'username', title: __('User_id'),width:150, operate:'LIKE'},
                        {field: 'address.begin_phone', title: '发货人手机号',width:150},
                        {field: 'distance', title: __('Distance'),width:90, formatter:Controller.api.formatter.distance, operate:'BETWEEN'},
                        {field: 'pay_price', title: __('Pay_price'),width:120, formatter:Controller.api.formatter.payPrice, operate:'BETWEEN'},
                        {field: 'car_id',title:'下单车型',formatter:function(val,row,index){
                            if(!row.vehicle){
                                return '无';
                            }
                            return row.vehicle.title;
                        }},
                        {field: 'address.begin_address', title: '收发地址', width:100,align:'left', operate:false, formatter:Controller.api.formatter.address},
                        {field: 'payment', title: '支付方式',width:130,searchList:{1:'余额支付',2:'微信支付',3:'现金支付'},formatter:Table.api.formatter.status},

                        {field: 'status', title: '订单状态',width:130,searchList:{0:__('Status 0'),1:__('Status 1'),2:__('Status 2'),3:__('Status 3'),4:__('Status 4'),5:__('Status 5'),6:__('Status 6')},formatter:Table.api.formatter.status},
                        {field: 'order_rider', title: '接单骑手',formatter:function(val,row,index){
                                    return val.rider_name;
                            }
                        },
                        {field: 'add_time', title: '下单时间',width:150,formatter:Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: $.extend(eventBtn ,Table.api.events.operate || []),
                            buttons: [{
                                name: 'detail',
                                icon: 'fa fa-list',
                                title: __('Detail'),
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-detailone',
                                url: $.fn.bootstrapTable.defaults.extend.detail_url
                            },
                                {
                                    name: 'detail',
                                    icon: 'fa fa-hand-o-left',
                                    title: __('分配司机'),
                                    extend: 'data-toggle="tooltip"',
                                    classname: 'btn btn-xs btn-primary btn-tasking',
                                    url: $.fn.bootstrapTable.defaults.extend.assign_url
                                }
                            ],

                            formatter: Table.api.formatter.operate
                        },
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            formatter:{
                distance : function(value,row,index){
                    return '<span class="text-info">'+value+' km</span>';
                },
                goods : function(value,row,index){
                    return value ? value+' kg' : '无';
                },
                price : function(value,row,index){
                    return '<span class="text-primary">'+value+' 元</span>';
                },
                payPrice : function(value,row,index){
                    return '<span class="text-success">'+value+' 元</span>';
                },
                address:function(value, row, index){
                    var color = 'primary';
                    value = value === null ? '' : value.toString();
                    if (value == '')
                        return true;

                    if(row.address.begin_address)

                        var html = '<span class="" style="color:#3498E2">起：</span><span>' + row.address.begin_address + '</span>'
                            + '<br><span class="" style="color: #E74C3C">终：</span><span>' + row.address.end_address + '</span>';
                    return html;
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});