define(['jquery', 'bootstrap', 'backend', 'table', 'form','upload'], function ($, undefined, Backend, Table, Form, Upload) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'setting/couponactivity/index',
                    add_url: 'setting/couponactivity/add',
                    edit_url: 'setting/couponactivity/edit',
                    del_url: 'setting/couponactivity/del',
                    multi_url: 'setting/couponactivity/multi',
                    table: 'coupon_activity',
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
                        {field: 'title', title: __('Title')},
                        {field: 'coupon_name', title: __('Coupon_id'), formatter:Controller.api.formatter.coupon},
                        {field: 'type', title: __('Type'),searchList:{0:__('Type 0'), 1:__('Type 1'),2:__('Type 2')},formatter:Table.api.formatter.flag},
                        {field: 'total_num', title: __('Total_num'),formatter:Controller.api.formatter.total},
                        {field: 'is_disabled', title: __('Is_disabled'),searchList:{0:__('Is_disabled 0'), 1:__('Is_disabled 1')},custom:{0:'success',1:'primary'},formatter:Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });


            Upload.config.previewtpl = '<li class="col-xs-8"><a href="<%=fullurl%>" data-url="<%=url%>" target="_blank" class="thumbnail"><img src="<%=fullurl%>" class="img-responsive"></a><a href="javascript:;" class="btn btn-danger btn-xs btn-trash"><i class="fa fa-trash"></i></a></li>';
            //使用Plupload上传
            Upload.api.plupload($(".plupload"), function(data, ret){
                Toastr.success("图片上传成功！");
            }, function(data, ret){
                Toastr.success("图片上传失败");
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
                coupon: function (value, row, index) {
                    return value + ' <span class="text-warning">' + row.money + '￥</span>';
                },
                total: function (value, row, index) {
                    return value ? value : '无';
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});