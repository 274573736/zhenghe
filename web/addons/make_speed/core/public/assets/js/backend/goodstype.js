define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'goodstype/index',
                    add_url: 'goodstype/add',
                    edit_url: 'goodstype/edit',
                    del_url: 'goodstype/del',
                    multi_url: 'goodstype/multi',
                    table: 'goods_type',
                }
            });

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索类目名称";};

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),width:80,operate:false},
                        {field: 'order_type', title: __('Order_type'),formatter:Table.api.formatter.flag,searchList:{0:__('Order_type 0'),1:__('Order_type 1'),2:__('Order_type 2')}},
                        {field: 'icon', title: '图标',formatter:Controller.api.formatter.imaget},
                        {field: 'name', title: __('Name')},
                        {field: 'weight', title: __('Weight'),width:150,operate:false},
                        {field: 'add_time', title: __('Add_time'),width:200, operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'),width:180, table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
                imaget: function (value, row, index) {
                    value = value ? value : '/assets/img/blank.gif';
                    var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                    var str = row.iconed==='' ? '' : '&nbsp;<i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<a href="' + Fast.api.cdnurl(row.iconed) + '" target="_blank"><img class="' + classname + '" src="' + Fast.api.cdnurl(row.iconed) + '" /></a>';
                    return '<a href="' + Fast.api.cdnurl(value) + '" target="_blank"><img class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" /></a>'+str;
                },
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});