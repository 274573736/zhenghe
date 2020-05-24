define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'equiporder/index',
                    add_url: 'equiporder/add',
                    edit_url: 'equiporder/edit',
                    del_url: 'equiporder/del',
                    multi_url: 'equiporder/multi',
                    table: 'equip_order',
                }
            });

            var table = $("#table");

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索订单号";};

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
                        {field: 'equipname', title: __('Equip_id')},
                        {field: 'ridername', title: __('Rider_id')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'),searchList:{0:__('Status 0'), 1:__('Status 1'), 2:__('Status 2')},  custom:{0:'danger',1:'primary',2:'success'},formatter: Table.api.formatter.status},
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