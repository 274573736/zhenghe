define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'freight/virtual_driver/index' + location.search,
                    add_url: 'freight/virtual_driver/add',
                    edit_url: 'freight/virtual_driver/edit',
                    del_url: 'freight/virtual_driver/del',
                    table: 'virtual_driver',
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
                        {field: 'lat', title: __('Latitude'), operate:'BETWEEN'},
                        {field: 'lng', title: __('Longitude'), operate:'BETWEEN'},
                        {field: 'address', title: '地址'},
                        {field: 'is_show', title: __('Is_show'), searchList: {"0":__('Is_show 0'),"1":__('Is_show 1')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: '添加时间', operate:'RANGE', addclass:'datetimerange',operate: false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ],
                onPostBody : function (options) {
                }
            });

            $('#distribution').on('click', function () {
                Fast.api.open('freight/virtual_driver/distribution','分布图');
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