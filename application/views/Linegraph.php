
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">

        <title>Line Chart Example</title>
    </head>
    <body>


        <!--  <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->

        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <h4 class="header-title m-t-0">Line Chart</h4>
            <p class="text-muted font-13 m-b-30">
                Display as Line Chart.

            <div class="p-20">
                <div id="linechart"></div>
            </div>
        </div>

    </body>
    <script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/d3/d3.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/c3/c3.min.js") ?>"></script>


    <script type="text/javascript">

        !function ($) {
            "use strict";

            var ChartC3 = function () {};

            ChartC3.prototype.init = function () {

                //generating chart 
                c3.generate({
                    bindto: '#linechart',
                    data: {
                        columns: [
                            ['data1', 40, 90, 60, 45, 80]
                        ],
                        types: {
                            data1: 'spline'
                        }
                        // onclick: function(e) { alert(e.value); }
                    },
                    colors: {
                        data1: '#ebeff2'    // Load Colors for each data
                    }

                });


            },
                    $.ChartC3 = new ChartC3, $.ChartC3.Constructor = ChartC3

        }(window.jQuery), function ($) {
            "use strict";
            $.ChartC3.init()
        }(window.jQuery);

    </script>
</html>
