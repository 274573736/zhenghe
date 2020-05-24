define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'setting/trainrider/index',
                    add_url: 'setting/trainrider/add',
                    edit_url: 'setting/trainrider/edit',
                    del_url: 'setting/trainrider/del',
                    multi_url: 'setting/trainrider/multi',
                    table: 'train_rider',
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
                        {field: 'trainname', title: __('Train_id')},
                        {field: 'ridername', title: __('Rider_id')},
                        {field: 'ridermobile', title: '手机号码'},
                        {field: 'time', title: __('Time'), operate:'RANGE', addclass:'datetimerange',datetimeFormat:'YYYY-MM-DD', formatter: Table.api.formatter.datetime},
                        {field: 'type', title: __('Type'),formatter:Controller.api.formatter.type},
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
            formatter:{
                type:function (value, row, index) {
                    return __('Type '+row.type)+' '+(row.type ? row.aftertime : row.morntime);
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});