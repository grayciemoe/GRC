

<div class="container">

    <div class="col-sm-6 col-xs-12 m-t-20">
        <h4 class="header-title m-t-0">Pie Chart</h4>
        <p class="text-muted font-13 m-b-30">
            Pie chart is used to see the proprotion of each data groups, making Flot pie chart is pretty simple,
            in order to make pie chart you have to incldue jquery.flot.pie.js plugin. sss
        </p>

        <div class="p-20">
            <div id="pie-chart">
                <div id="pie-chart-container" class="flot-chart" style="height: 260px;">
                </div>
            </div>
        </div>
    </div>

</div>
<script> var resizefunc = [];</script>
<!-- jQuery  -->
<script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/js/tether.min.js") ?>"></script><!-- Tether for Bootstrap -->
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/js/waves.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
<script src="<?= base_url("assets/plugins/switchery/switchery.min.js") ?>"></script>
<!-- Flot chart js -->
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.time.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.tooltip.min.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.resize.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.pie.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.selection.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.stack.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.crosshair.js"); ?>"></script>
<script src="<?= base_url("assets/plugins/flot-chart/jquery.flot.axislabels.js"); ?>"></script>

<script>
    /**
     * Theme: Uplon Admin Template
     * Author: Coderthemes
     * Module/App: Flot-Chart
     */

    !function ($) {
        "use strict";
        var FlotChart = function () {
            this.$body = $("body")
            this.$realData = []
        };
        //creates plot graph        FlotChart.prototype.createPlotGraph = function (selector, data1, data2, data3, labels, colors, borderColor, bgColor) {
        //shows tooltip

        $.plot($(selector), [{
                data: data1,
                label: labels[0],
                color: colors[0]
            }, {
                data: data2,
                label: labels[1],
                color: colors[1]
            }, {
                data: data3,
                label: labels[2],
                color: colors[2]
            }], {
            series: {
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 2,
                    fillColor: {
                        colors: [{
                                opacity: 0
                            }, {
                                opacity: 0.5
                            }, {
                                opacity: 0.6
                            }]
                    }
                },
                points: {
                    show: false
                },
                shadowSize: 0
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderColor: borderColor,
                tickColor: "#f9f9f9",
                borderWidth: 1,
                labelMargin: 10,
                backgroundColor: bgColor
            },
            legend: {
                position: "ne",
                margin: [0, -24],
                noColumns: 0,
                labelBoxBorderColor: null,
                labelFormatter: function (label, series) {
                    // just add some space to labes
                    return '' + label + '&nbsp;&nbsp;';
                },
                width: 30,
                height: 2
            },
            yaxis: {
                axisLabel: "Daily Visits",
                tickColor: '#f5f5f5',
                font: {
                    color: '#bdbdbd'
                }
            },
            xaxis: {
                axisLabel: "Last Days",
                tickColor: '#f5f5f5',
                font: {
                    color: '#bdbdbd'
                }
            },
            tooltip: true,
            tooltipOpts: {
                content: '%s: Value of %x is %y',
                shifts: {
                    x: -60,
                    y: 25
                },
                defaultTheme: false
            }
        });
    },
            //end plot graph


            //creates Pie Chart
            FlotChart.prototype.createPieGraph = function (selector, labels, datas, colors) {
                var data = [{
                        label: labels[0],
                        data: datas[0]
                    }, {
                        label: labels[1],
                        data: datas[1]
                    }, {
                        label: labels[2],
                        data: datas[2]
                    }];
                var options = {
                    series: {
                        pie: {
                            show: true
                        }
                    },
                    legend: {
                        show: true
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    },
                    colors: colors,
                    tooltip: true,
                    tooltipOpts: {
                        content: "%s, %p.0%"
                    }
                };

                $.plot($(selector), data, options);
            },
            //returns some random data
            FlotChart.prototype.init = function () {

                //Pie graph data
                var pielabels = ["Series 1", "Series 2", "Series 3"];
                var datas = [20, 30, 15];
                var colors = ['#3db9dc', '#ff7aa3', "#2b3d51"];
                this.createPieGraph("#pie-chart #pie-chart-container", pielabels, datas, colors);

            },
            //init flotchart
            $.FlotChart = new FlotChart, $.FlotChart.Constructor =
            FlotChart

    }(window.jQuery),
            //initializing flotchart
                    function ($) {
                        "use strict";
                        $.FlotChart.init()
                    }(window.jQuery);

            $(document).ready(function () {




            });


</script>


<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>