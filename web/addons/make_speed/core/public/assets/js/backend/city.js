define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'city/index',
                    add_url: 'city/add',
                    edit_url: 'city/edit',
                    del_url: 'city/del',
                    multi_url: 'city/multi',
                    table: 'city',
                }
            });

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索城市名/首字母";};

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),width:80, operate: false},
                        {field: 'name', title: __('Name'), operate:'LIKE'},
                        {field: 'key', title: __('Key'), width:80},
                        {field: 'is_hot', title: __('Is_hot'), searchList: {0: __('Is_hot 0'), 1: __('Is_hot 1')}, width:150, formatter: Controller.api.formatter.isHot},
                        {field: 'is_disabled', title: __('Is_disabled'),width:180,searchList: {0: __('Is_disabled 0'), 1: __('Is_disabled 1')},formatter:Table.api.formatter.status, custom:{0:"success",1:"gray"}},
                        {field: 'operate', title: __('Operate'),width:150, table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
                isHot:function(value, row, index){
                    value = value ? '<span class="text-info">是</span>' : '<span class="text-primary">否</span>';
                    return value;
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});