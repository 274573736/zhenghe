define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'carhailing/vehicle_list/index' + location.search,
                    add_url: 'carhailing/vehicle_list/add',
                    edit_url: 'carhailing/vehicle_list/edit',
                    del_url: 'carhailing/vehicle_list/del',
                    multi_url: 'carhailing/vehicle_list/multi',
                    table: 'car_vehicle_detail',
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
                        {field: 'plate_no', title: __('Plate_no')},
                        {field: 'drivering_license', title: __('Drivering_license')},
                        {field: 'car_type_id', title: __('Car_type_id'),formatter:function(val,row,index){
                                if(row.type){
                                    return row.type.name;
                                }
                            }
                        },
                        {field: 'vehicle_brand_id', title: __('Vehicle_brand_id'),formatter:function(val,row,index){
                                if(row.brand){
                                    return row.brand.name;
                                }
                            }
                        },
                        {field: 'cc', title: __('Cc'), operate:'BETWEEN'},
                        {field: 'seat_no', title: __('Seat_no')},
                        {field: 'mileage', title: __('Mileage'), operate:'BETWEEN'},
                        {field: 'udid', title: __('Udid')},
                        {field: 'engline_no', title: __('Engline_no')},
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"0":__('Status 0')}, formatter: Table.api.formatter.status},
                        {field: 'drivering_license_exp', title: __('Drivering_license_exp')},
                        {field: 'operate_status', title: __('Operate_status'), searchList: {"0":__('Operate_status 0'),"1":__('Operate_status 1'),"2":__('Operate_status 2'),"3":__('Operate_status 3')}, formatter: Table.api.formatter.status},
                        {field: 'annual_exp', title: __('Annual_exp')},
                        {field: 'car_insurance_exp', title: __('Car_insurance_exp')},
                        {field: 'register_time', title: __('Register_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'online_time', title: __('Online_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'off_line_time', title: __('Off_line_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'drivering_license_image', title: __('Drivering_license_image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'vehicle_images', title: __('Vehicle_images'), events: Table.api.events.image, formatter: Table.api.formatter.images},
                        {field: 'createtime', title: '添加时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});