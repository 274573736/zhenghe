define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                showFooter: true,
                extend: {
                    index_url: 'person/cashlog/index',
                    add_url: 'person/cashlog/add',
                    del_url: 'person/cashlog/del',
                    multi_url: 'person/cashlog/multi',
                    table: 'user_cashlog',
                }
            });

            var table = $("#table");

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 业务订单号";};


            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'title', title: __('Title')},
                        {field: 'order_code', title: __('Order_code'),footerFormatter: function (value) {
                            return '<span class="text-primary" style="font-weight:bold">当前页合计：</span>';
                        }},
                        {field: 'username', title: __('User_id'),operate:false},
                        {field: 'amount', title: __('Amount'), with:160, operate:'BETWEEN',sortable: true,valign: 'middle',footerFormatter: function (value) {
                            var count = 0;
                            console.log(value);
                            for (var i in value) {
                                count += parseFloat(value[i].amount);
                            }
                            return '<span class="text-info" style="font-weight:bold">' + count.toFixed(2) + ' 元</span>';
                        }},
                        {field: 'type', title: __('Type'), searchList:{0:__('Type 0'), 1:__('Type 1'), 2:__('Type 2')},custom:{0:'warning', 1:'info',2:'success'}, formatter:Table.api.formatter.flag},
                        {field: 'status', title: __('Status'), searchList:{0:__('Status 0'), 1:__('Status 1')},custom:{0:'danger',1:'success'},formatter:Table.api.formatter.status},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});