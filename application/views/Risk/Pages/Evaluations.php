
<link class="include" rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/jqplot/jquery.jqplot.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/jqplot/examples/examples.min.css"); ?>" />

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?= base_url("assets/plugins/jqplot/excanvas.js"); ?>"></script><![endif]-->

<div class="container">

    <div class="example-nav">


        <!-- Example scripts go here -->


        <style type="text/css">

            .plot {
                margin-bottom: 30px;
                margin-left: auto;
                margin-right: auto;
            }



            #chart4 .jqplot-meterGauge-tick, #chart4 .jqplot-meterGauge-label {
                font-size: 12pt;
            }
        </style>


        <div id="chart4" class="plot" style="width:500px;height:300px;"></div>


        <script type="text/javascript" class="code">
            $(document).ready(function () {

                s1 = [52200];

                plot4 = $.jqplot('chart4', [s1], {
                    seriesDefaults: {
                        renderer: $.jqplot.MeterGaugeRenderer,
                        rendererOptions: {
                            label: 'Metric Tons per Year',
                            labelPosition: 'bottom',
                            labelHeightAdjust: -5,
                            intervalOuterRadius: 85,
                            ticks: [10000, 30000, 50000, 70000],
                            intervals: [22000, 55000, 70000],
                            intervalColors: ['#66cc66', '#E7E658', '#cc6666']
                        }
                    }
                });

            });
        </script>
        <!-- End example scripts -->

        <!-- Don't touch this! -->
        <script class="include" type="text/javascript" src="<?= base_url("assets/plugins/jqplot/jquery.jqplot.min.js"); ?>"></script>
        <!-- End Don't touch this! -->

        <!-- Additional plugins go here -->
        <script class="include" type="text/javascript" src="<?= base_url("assets/plugins/jqplot/plugins/jqplot.meterGaugeRenderer.min.js"); ?>"></script>
        <script type="text/javascript" src="<?= base_url("assets/plugins/jqplot/examples/example.min.js"); ?>"></script>

        <!-- End additional plugins -->


    </div>	
</div>