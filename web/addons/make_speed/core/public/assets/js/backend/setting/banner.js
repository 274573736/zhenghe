define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'setting/banner/index',
                    add_url: 'setting/banner/add',
                    edit_url: 'setting/banner/edit',
                    del_url: 'setting/banner/del',
                    multi_url: 'setting/banner/multi',
                    table: 'banner',
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
                        {field: 'img', title: __('Img'), formatter:Table.api.formatter.image},
                        {field: 'path', title: __('Path'),formatter:Table.api.formatter.flag},
                        {field: 'disabled', title: __('Disabled'),searchList:{0:__('Disabled 0'), 1:__('Disabled 1')}, custom:{yes:0,no:1},  formatter:Controller.api.formatter.toggle},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $("#select_app").click(function(e){
                $("#appid").removeClass('hide');
                $("#pages").removeClass('hide');
                $("#path").hide();
            })

            $("#page").click(function(e){
                $("#appid").addClass('hide');
                $("#pages").addClass('hide');
                $("#path").show();

            })
            Controller.api.bindevent();
        },
        edit: function () {
            $("#select_app").click(function(e){
                $("#appid").removeClass('hide');
                $("#pages").removeClass('hide');
                $("#path").hide();

            })

            $("#page").click(function(e){
                $("#appid").addClass('hide');
                $("#pages").addClass('hide');
                $("#path").removeClass('hide');
            })
            Controller.api.bindevent();
        },
        api: {
            formatter:{
                toggle:function(value,row,index){
                    var color = typeof this.color !== 'undefined' ? this.color : 'success';
                    var yes = typeof this.custom.yes !== 'undefined' ? this.custom.yes : 1;
                    var no = typeof this.custom.no !== 'undefined' ? this.custom.no : 0;
                    return "<a href='javascript:;' data-toggle='tooltip' title='" + __('Click to toggle') + "' class='btn-change' data-id='"
                        + row.id + "' data-params='" + this.field + "=" + (value==no ? yes : no) + "'><i class='fa fa-toggle-on " + (value == yes ? 'text-' + color : 'fa-flip-horizontal text-gray') + " fa-2x'></i></a>";
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});