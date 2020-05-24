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

            //Upload.config.previewtpl = '<li class="col-xs-8"><a href="<%=fullurl%>" data-url="<%=url%>" target="_blank" class="thumbnail"><img src="<%=fullurl%>" class="img-responsive"></a><a href="javascript:;" class="btn btn-danger btn-xs btn-trash"><i class="fa fa-trash"></i></a></li>';
            ////使用Plupload上传
            //Upload.api.plupload($(".plupload"), function(data, ret){
            //    Toastr.success("上传成功！");
            //}, function(data, ret){
            //    Toastr.success("上传失败");
            //});


            // 为表格绑定事件
            Table.api.bindevent(table);

            $("form.edit-form").data("validator-options", {
                display: function (elem) {
                    return $(elem).closest('tr').find("td:first").text();
                }
            });
            Form.api.bindevent($("form[role=form]"));

            //Form.api.bindevent($("form .edit-form"));

        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        program_icon:function(){
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
        var tpl = ['template_id','cancel_template_id','acceptorder_template_id','accepted_template_id','complete_template_id','audit_rider_tpl'];
        var type = $(this).attr("data-id");
        var that = $(this);
        Fast.api.ajax('general/config/startrider?type='+type,function(res){
            if( typeof res !== 'undefined' && typeof res.priTmplId !== 'undefined' && res.priTmplId !==''){
                $('input[name='+tpl[type]+']').val(res.priTmplId);
                that.addClass('').css({'opacity':'0.65','box-shadow':'none'}).html('已启用');
            }
        });
        return false;
    });

    var url   = 'make_speed/router/router';
    var type  = 0;
    $('.create_code').click(function(){
        type = $(this).data('type');
        var that = $(this);
        Fast.api.ajax({
            url:'general/config/createSmallProgramImg',
            data:{
                url  : url,
                type : type,
            },
            success:function(res){
                Layer.closeAll();
                if(res.code == 1){
                    that.parent().next().removeClass('hide');
                    var a = that.parent().next().find("a:first-child");
                    a.attr('href',res.data)
                    a.children().attr('src',res.data);
                    layer.msg('生成成功');
                }else{
                    layer.msg('小程序码生成失败');
                }
            },
            error:function(){
                Layer.closeAll();
            }
        })
    })




    return Controller;
});