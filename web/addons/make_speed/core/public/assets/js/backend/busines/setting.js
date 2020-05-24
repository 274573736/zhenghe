define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'upload'], function ($, undefined, Backend, Table, Form, Upload) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'general/config/index',
                    add_url: 'general/config/add',
                    edit_url: 'general/config/edit',
                    del_url: 'general/config/del',
                    multi_url: 'general/config/multi',
                    table: 'config',
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
                        {field: 'state', checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name')},
                        {field: 'intro', title: __('Intro')},
                        {field: 'group', title: __('Group')},
                        {field: 'type', title: __('Type')},
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        }
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

            $("form.edit-form").data("validator-options", {
                display: function (elem) {
                    return $(elem).closest('tr').find("td:first").text();
                }
            });
            Form.api.bindevent($("form.edit-form"));

            //不可见的元素不验证
            $("form#add-form").data("validator-options", {ignore: ':hidden'});
            Form.api.bindevent($("form#add-form"), null, function (ret) {
                location.reload();
            });


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

    $('.start_tpl').click(function(e){
        e.preventDefault();
        var tpl = ['template_id','cancel_template_id','acceptorder_template_id','accepted_template_id','complete_template_id'];
        var type = $(this).attr("data-id");
        Fast.api.ajax('general/config/startrider?type='+type,function(res){
            console.log(res);
            if( typeof res !== 'undefined' && typeof res.template_id !== 'undefined' && res.template_id !==''){
                $('input[name='+tpl[type]+']').val(res.template_id);
            }
        });
        return false;
    });

    return Controller;
});