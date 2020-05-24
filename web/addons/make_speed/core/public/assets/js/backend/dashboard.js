define(['jquery', 'bootstrap', 'backend', 'addtabs', 'table', 'echarts', 'echarts-theme', 'template'], function ($, undefined, Backend, Datatable, Table, Echarts, undefined, Template) {

    var Controller = {
        index: function () {
            // 基于准备好的dom，初始化echarts实例
            var myChart = Echarts.init(document.getElementById('echart'), 'walden');

            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: '',
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: [__('Sales'), __('Orders')]
                },
                toolbox: {
                    show: false,
                    feature: {
                        magicType: {show: true, type: ['stack', 'tiled']},
                        saveAsImage: {show: true}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: Orderdata.column
                },
                yAxis: {},
                grid: [{
                    left: '2%',
                    top: '2%',
                    right: '2%',
                    bottom: 30
                }],
                series: [{
                    name: __('Sales'),
                    type: 'bar',
                    barGap:'1%',
                    smooth: true,
                    areaStyle: {
                        normal: {}
                    },
                    lineStyle: {
                        normal: {
                            width: 1.5
                        }
                    },
                    data: Orderdata.paydata
                },
                {
                    name: __('Orders'),
                    type: 'bar',
                    smooth: true,

                    barGap:'1%',

                    areaStyle: {
                        normal: {}
                    },
                    lineStyle: {
                        normal: {
                            width: 1.5
                        }
                    },
                    data: Orderdata.createdata
                }],

                animationEasing: function (k) {
                    var s;
                    var a = 0.1;
                    var p = 0.4;
                    if (k === 0) { return 0; }
                    if (k === 1) { return 1; }
                    if (!a || a < 1) { a = 1; s = p / 4; }
                    else { s = p * Math.asin(1 / a) / (2 * Math.PI); }
                    return -(a * Math.pow(2, 10 * (k -= 1)) * Math.sin((k - s) * (2 * Math.PI) / p));
                },
                animationDuration: 1000
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);


            $(window).resize(function () {
                myChart.resize();
            });

            $(document).on("click", ".btn-checkversion", function () {
                top.window.$("[data-toggle=checkupdate]").trigger("click");
            });

        }
    };

    return Controller;
});