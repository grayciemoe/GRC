<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><div class="container-fluid">
    <link href="<?= base_url("assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/plugins/bootstrap-daterangepicker/daterangepicker.css") ?>" rel="stylesheet">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="card">
        <div class="card-header bg-light">
            <a href="<?= base_url("index.php/IncidentManagement/incidentForm/"); ?>" class="btn btn-secondary btn-sm btn-small pull-right"><i class="icon icon-plus"></i> Create Incident Report</a>
            <h4 class="card-title">Dashboard</h4>
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label  for="txt-incident_management-compliance"  class='col-sm-4 form-control-label'>Filter Period</label>
                    <div class="input-daterange input-group" id="date-range">
                        <input type="text" class="form-control" name="start" />
                        <span class="input-group-addon bg-custom b-0">to</span>
                        <input type="text" class="form-control" name="end" />
                    </div>
                </div>

            </div>
        </div>
        <div class="row incident-charts ">
            <div class="col-sm-6 col-xs-12">
                <div class="card card-block">
                    <h4 class="card-title text-center">Closure Rate</h4>
                    <div class="p-20">

                        <canvas id="pie0" height="260"></canvas>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="card card-block">
                    <h4 class="card-title text-center">Exprience type</h4>
                    <div class="p-20">
                        <canvas id="pie1" height="260"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ">
                <div class="card card-block">
                    <h4 class="card-title text-center">Area of Occurence (No of Incidents)</h4>
                    <div class="p-20">
                        <canvas id="bar0" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="card card-block">
                    <h4 class="card-title text-center">Area of Occurence (Actual loss from Incidents)</h4>
                    <div class="p-20">
                        <canvas id="bar1" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- controlled scripts -->
<?php
$UPLON_SCRIPTS = objectToArray(json_decode(UPLON_SCRIPTS));
foreach ($scripts as $key => $value) {
    if (array_key_exists($value, $UPLON_SCRIPTS)) {
        echo "<script src=\"" . base_url($UPLON_SCRIPTS[$value]) . "\"></script> \n";
    }
}
?>

<script>
// Date Picker
    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: "dd/mm/yyyy",
    });
</script>
<script>
    /**
     Template Name: Uplon Dashboard
     Author: CoderThemes
     Email: coderthemes@gmail.com
     File: Chartjs
     */


    !function ($) {
        "use strict";

        var ChartJs = function () {};

        ChartJs.prototype.respChart = function (selector, type, data, options) {
            // get selector by context
            var ctx = selector.get(0).getContext("2d");
            // pointing parent container to make chart js inherit its width
            var container = $(selector).parent();

            // enable resizing matter
            $(window).resize(generateChart);

            // this function produce the responsive Chart JS
            function generateChart() {
                // make chart width fit with its container
                var ww = selector.attr('width', $(container).width());
                switch (type) {
                    case 'Pie':
                        new Chart(ctx, {type: 'pie', data: data, options: options});
                        break;
                    case 'Bar':
                        new Chart(ctx, {type: 'bar', data: data, options: options});
                        break;
                }
                // Initiate new chart or Redraw

            }
            ;
            // run function - render chart at first load
            generateChart();
        },
                //init
                ChartJs.prototype.init = function () {

                    //Pie1 chart
                    var pieChart1 = {
                        labels: [
                            "Open",
                            "Closed"
                        ],
                        datasets: [
                            {
                                data: [300, 50],
                                backgroundColor: [
                                    "#008000",
                                    "#FF0000"
                                ],
                                hoverBackgroundColor: [
                                    "#008000",
                                    "#FF0000"
                                ],
                                hoverBorderColor: "#fff"
                            }]
                    };
                    var pieChart2 = {
                        labels: [
                            "Estimate Financial loss",
                            "Near Miss",
                            "Opportunity cost",
                            "Actual financial loss"
                        ],
                        datasets: [
                            {
                                data: [30, 50, 60, 70],
                                backgroundColor: [
                                    "#008000",
                                    "#108070",
                                    "#66CBEA",
                                    "#FF0000"
                                ],
                                hoverBackgroundColor: [
                                    "#008000",
                                    "#108070",
                                    "#66CBEA",
                                    "#FF0000"
                                ],
                                hoverBorderColor: "#fff"
                            }]
                    };


                    this.respChart($("#pie0"), 'Pie', pieChart1);
                    this.respChart($("#pie1"), 'Pie', pieChart2);

                    //barchart
                    var barChart0 = {
                        labels: ["Kisumu", "Eldoret", "Nakuru", "Nairobi", "Thika", "Karatina", "Meru", "Kampala", "Vihiga", "Nyeri"],
                        datasets: [
                            {
                                label: "Number of Incidences",
                                backgroundColor: "rgba(27,185,154,0.3)",
                                borderColor: "#1bb99a",
                                borderWidth: 1,
                                hoverBackgroundColor: "rgba(27,185,154,0.6)",
                                hoverBorderColor: "#1bb99a",
                                data: [65, 59, 80, 81, 56, 55, 40, 55, 25, 58]
                            }
                        ]
                    };
                    //barchart
                    var barChart1 = {
                        labels: ["Kisumu", "Eldoret", "Nakuru", "Nairobi", "Thika", "Karatina", "Meru", "Kampala", "Vihiga", "Nyeri"],
                        datasets: [
                            {
                                label: "Actual Loss",
                                backgroundColor: "rgba(27,185,154,0.3)",
                                borderColor: "#1bb99a",
                                borderWidth: 1,
                                hoverBackgroundColor: "rgba(27,185,154,0.6)",
                                hoverBorderColor: "#1bb99a",
                                data: [65, 59, 80, 81, 56, 55, 40, 55, 25, 58]
                            }
                        ]
                    };
                    this.respChart($("#bar0"), 'Bar', barChart0);
                    this.respChart($("#bar1"), 'Bar', barChart1);

                },
                $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

    }(window.jQuery),
//initializing
            function ($) {
                "use strict";
                $.ChartJs.init()
            }(window.jQuery);


</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['excel', 'pdf', 'colvis']
        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>

<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
