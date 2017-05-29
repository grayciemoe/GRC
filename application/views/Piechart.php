
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">

        <title>Pie Chart Example</title>
    </head>
    <body>


       <!--  <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->

       <div class="col-sm-6 col-xs-12 m-t-20">
            <h4 class="header-title m-t-0">Pie Chart</h4>
            <p class="text-muted font-13 m-b-30">
                Display as Pie Chart.
            </p>

            <div class="p-20">
                <div id="pie-chart"></div>
            </div>
        </div>

    </body>
    <script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/d3/d3.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/c3/c3.min.js") ?>"></script>
    <script type="text/javascript">

    !function($) {
    "use strict";

    var ChartC3 = function() {};

    ChartC3.prototype.init = function () {

        //Pie Chart
        c3.generate({
             bindto: '#pie-chart',
            data: {
                columns: [
                    ['Item 1', 46],
                    ['Item 2', 24],
                    ['Item 3', 30]
                ],
                type : 'pie'
                // onclick: function (d, i) { alert("onclick " + d.value, d, i); } // Load Data Here
                
            },
            color: {
                pattern: ["#008000", "#ff5d48", "#3db9dc"]  // Load Colors Here
            },
            pie: {
                label: {
                  show: false
                }
            }
        });

        },
        $.ChartC3 = new ChartC3, $.ChartC3.Constructor = ChartC3

    }(window.jQuery),

    //initializing 
    function($) {
        "use strict";
        $.ChartC3.init()
    }(window.jQuery);

    </script>
</html>
