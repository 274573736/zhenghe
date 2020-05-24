define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/riderdriver/index',
                    add_url: 'person/riderdriver/add',
                    edit_url: 'person/riderdriver/edit',
                    del_url: 'person/riderdriver/del',
                    multi_url: 'person/riderdriver/multi',
                    table: 'rider_driver',
                }
            });

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 姓名/准驾类型";};

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
                        {field: 'ridername', title: __('Rider_id')},
                        {field: 'card_img1', title: __('Card_img1'), formatter:Table.api.formatter.image},
                        {field: 'card_img2', title: __('Card_img2'), formatter:Table.api.formatter.image},
                        {field: 'card_num', title: __('Card_num')},
                        {field: 'card_type', title: __('Card_type')},
                        {field: 'card_time', title: __('Card_time')},
                        {field: 'status', title: __('Status'),searchList:{0:__('Status 0'), 1:__('Status 1'), 2:__('Status 2')},  custom:{0:'primary',1:'danger',2:'success'},formatter: Table.api.formatter.status},
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
            $('#edit-form').validator({
                ignore: ':hidden'
            });
            var val = $("input[type='radio']:checked").val();
            if(val == 1){
                $("#pcau").removeClass('hide');
                $("#pcau").show();
            } var val = $("input[type='radio']:checked").val();

            $(':radio').click(function(){
                var value = $(this).val();
                if(value == 1){
                    $("#pcau").removeClass('hide');
                    $("#pcau").show();
                }else{
                    $("#pcau").hide();
                }
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