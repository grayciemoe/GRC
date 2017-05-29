<?php 
if (am_user_type(array(7)) ) {
    restricted_view();
    return false;
}
?><div class='p-20'>
    <div class='text-xs-center'>
        <ul class='list-inline chart-detail-list'>
            <li class='list-inline-item'>
                <h6 style='color: #1bb99a;'><i class='zmdi zmdi-circle-o m-r-5'></i>Series A</h6>
            </li>
            <li class='list-inline-item'>
                <h6 style='color: #f1b53d;'><i class='zmdi zmdi-triangle-up m-r-5'></i>Series B</h6>
            </li>
        </ul>
    </div>

    <div id='morris-line-example' style='height: 300px;'></div>

</div>
<script>


    /**
     * Theme: Uplon Admin Template
     * Author: Coderthemes
     * Morris Chart
     */

    !function ($) {
        'use strict';

        var MorrisCharts = function () {};

        //creates line chart
        MorrisCharts.prototype.createLineChart = function (element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
            Morris.Line({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                fillOpacity: opacity,
                pointFillColors: Pfillcolor,
                pointStrokeColors: Pstockcolor,
                behaveLikeLine: true,
                gridLineColor: '#eef0f2',
                hideHover: 'auto',
                lineWidth: '3px',
                pointSize: 0,
                preUnits: '$',
                resize: true, //defaulted to true                        {y: '2011', a: 50, b: 50},

                lineColors: lineColors
            });
        },
                MorrisCharts.prototype.init = function () {

                    //create line chart
                    var $data = [
                        {y: '2008', a: 50, b: 0},
                        {y: '2009', a: 75, b: 50},
                        {y: '2010', a: 30, b: 80},
                        {y: '2011', a: 50, b: 50},
                        {y: '2012', a: 75, b: 10},
                        {y: '2013', a: 50, b: 40},
                        {y: '2014', a: 75, b: 50},
                        {y: '2015', a: 100, b: 70}
                    ];
                    this.createLineChart('morris-line-example', $data, 'y', ['a', 'b'], ['Series A', 'Series B'], ['0.1'], ['#ffffff'], ['#999999'], ['#1bb99a', '#f1b53d']);


                },
                //init
                $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
    }(window.jQuery),
//initializing 
            function ($) {
                'use strict';
                $.MorrisCharts.init();
            }(window.jQuery);
</script>
