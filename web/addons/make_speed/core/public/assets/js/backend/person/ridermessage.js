define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/ridermessage/index',
                    add_url: 'person/ridermessage/add',
                    edit_url: 'person/ridermessage/edit',
                    del_url: 'person/ridermessage/del',
                    multi_url: 'person/ridermessage/multi',
                    table: 'rider_message',
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
                        {field: 'type', title: __('Type'), searchList:{0:__('Type 0'),1:__('Type 1'),2:__('Type 2')}, formatter: Table.api.formatter.flag},
                        {field: 'ridername', title: __('Rider_id'),operate:false,formatter:Controller.api.formatter.rider},
                        {field: 'title', title: __('Title')},
                        {field: 'all', title: __('All'), searchList:{0:__('All 0'),1:__('All 1')}, custom:{0:'primary',1:'warning'}, formatter: Table.api.formatter.flag},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', datetimeFormat:"YYYY-MM-DD HH:mm", formatter: Table.api.formatter.datetime},
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
                rider:function(value,row,index){
                    if(value===null){
                        return '无';
                    }
                    return value+ (row.ridermobile ? ' / '+row.ridermobile : '');
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});