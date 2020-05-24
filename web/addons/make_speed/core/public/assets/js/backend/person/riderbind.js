define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/riderbind/index',
                    add_url: 'person/riderbind/add',
                    edit_url: 'person/riderbind/edit',
                    del_url: 'person/riderbind/del',
                    multi_url: 'person/riderbind/multi',
                    table: 'rider_bind',
                }
            });

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 姓名/身份证号";};

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
                        {field: 'ridername', title: __('Rider_name')},
                        {field: 'real_name', title: __('Real_name')},
                        {field: 'card_code', title: __('Card_code')},
                        // {field: 'card1_img', title: __('Card1_img'),formatter:Table.api.formatter.image},
                        // {field: 'card2_img', title: __('Card2_img'),formatter:Table.api.formatter.image},
                        // {field: 'card3_img', title: __('Card3_img'),formatter:Table.api.formatter.image},
                        // {field: 'card4_img', title: __('Card4_img'),formatter:Table.api.formatter.image},
                        {field: 'status', title: __('Status'),searchList:{0:__('Status 0'), 1:__('Status 1'), 2:__('Status 2')},  custom:{0:'primary',1:'danger',2:'success'},formatter: Table.api.formatter.status},
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
            $('#c-status').change( function(){
               if($(this).val() == 1){
                   $(".remark").removeClass('hide')
               }else{
                   $(".remark").addClass('hide')
               };
            });
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