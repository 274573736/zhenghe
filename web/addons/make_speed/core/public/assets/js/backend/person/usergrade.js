define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/usergrade/index',
                    add_url: 'person/usergrade/add',
                    edit_url: 'person/usergrade/edit',
                    del_url: 'person/usergrade/del',
                    multi_url: 'person/usergrade/multi',
                    table: 'user_grade',
                }
            });

            var table = $("#table");
            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 等级名称";};

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'grade', title: __('Grade')},
                        {field: 'icon', title: __('Icon'), formatter: Controller.api.formatter.image},
                        {field: 'name', title: __('Name')},
                        {field: 'grow', title: __('Grow')},
                        {field: 'discount', title: __('Discount'), formatter:Controller.api.formatter.discount, operate:'BETWEEN'},
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
                discount:function(value, row, index){
                    return value*100 + '%';
                },
                image:function(value, row, index){
                    if(value=='') return '无';
                    value = value ? value : '/assets/img/blank.gif';
                    var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                    return '<a href="' + Fast.api.cdnurl(value) + '" target="_blank"><img class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" /></a>';
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});