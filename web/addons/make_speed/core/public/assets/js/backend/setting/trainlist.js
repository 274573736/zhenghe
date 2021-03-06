define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'setting/trainlist/index',
                    add_url: 'setting/trainlist/add',
                    edit_url: 'setting/trainlist/edit',
                    del_url: 'setting/trainlist/del',
                    multi_url: 'setting/trainlist/multi',
                    table: 'train_point',
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
                        {field: 'city_name', title: __('City_id')},
                        {field: 'name', title: __('Name')},
                        {field: 'business_date', title: __('Business_date')},
                        {field: 'morn', title: __('Morn')},
                        {field: 'after', title: __('After')},
                        {field: 'total', title: __('Total')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'address', title: __('Address')},
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