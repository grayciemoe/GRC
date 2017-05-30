<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><link rel="stylesheet" href="<?= base_url("assets/plugins/fullcalendar/dist/fullcalendar.min.css") ?>">
<?php
$obligations = $data['obligations'];
//$breach = $data['breaches'];
//$complies = $data['complies'];
//$comp_req = $data['comp_req'];
//    $comply_count = $data['total_comp'];
//$total_obl = $data['total_obligations'];
//$ov_compliance = $data['overall compliance'];
//$penalty = $data['total_penalties'];
//$total_breaches = $data['total_breaches'];
$approved_breaches = ( $data['breaches_approved']);

$stat_fully = $data['stat_fully'];
$stat_part = $data['stat_part'];
$stat_non_comp = $data['stat_non_comp'];

$business_fully = $data['business_fully'];
$business_part = $data['business_part'];
$business_non_comp = $data['business_non_comp'];

$legal_fully = $data['legal_fully'];
$legal_part = $data['legal_part'];
$legal_non_comp = $data['legal_non_comp'];
//    print_pre($obligations);
//        die();
?>
<link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">

<title>Pie Chart Example</title>
<div class="container-fluid">

    <!-- Start right Content here -->
    <!-- ============================================================== -->


    <div class="row card-box content-chart-dashboard">
        <div class="col-sm-3 col-xs-12">
            <div class="card-box tilebox-one">
                <i class="zmdi zmdi-shield-check pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Overall Compliance</h6>
                <h2 class="m-b-20" data-plugin="counterup"><?= $data['overall compliance'] ?>%</h2>
                <span class="label label-info"> <?= ($data['obligations_approved']) ?> </span> <span class="text-muted"> Total Obligations</span>
            </div>
            <div class="card-box tilebox-one">
                <i class="icon-lock-open pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Penalties</h6>
                <h2 class="m-b-20" data-plugin="counterup">KES <?= number_format($data['breaches_penalty'], $decimals = "2", $dec_point = ".", $thousands_sep = ",") ?></h2>
                <span class="label label-info"> <?= $approved_breaches ?> </span> <span class="text-muted"> No. of Breaches</span>
            </div>
        </div>
        <!-- pie chart -->
        <div class="col-sm-4 col-xs-12">
            <div class="card card-block">
                <div id="obligation_type">

                    <?php //print_pre($data); ?>
                </div>
            </div>
        </div>
        <!-- stacked column chart-->
        <div class="col-sm-5 col-xs-12 third-pie">
            <div class="card card-block">
                <div id="stacked_bar">



                </div>
            </div>
        </div>
        <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
    </div>

    <div class="row  content-chart-dashboard1">

        <div class="col-sm-5 ">

            <h3 class="card-title card-block card">Calendar</h3>
            <div id="calendar" class="card"></div>

        </div>

        <!-- end row -->

        <div class="col-sm-7 card  card-block ">


            <ul class="card-title nav nav-tabs nav-tabs-alt compliance-item tabs-comp m-b-10" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-center" id="home-tab" data-toggle="tab" href="#home"
                       role="tab" aria-controls="home" aria-expanded="true">Obligation</a>
                </li>

            </ul>

            <div class="tab-content" id="myTabContent">
                <div role="tabpanel" class="tab-pane fade in active" id="home"
                     aria-labelledby="home-tab">
                         <?php // print_pre($obligations);  ?>
                    <table id="datatable-buttons" class="table table-striped  table-responsive table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Compliance Requirement</th>
                                <th>Complied</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Frequency</th>
                                <th></th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php
                            $num = 0;

                            foreach ($obligations as $key => $value): $num++;
                                $priority_label = $value['priority'] == "Low" ? "primary" : $value['priority'] == "Medium" ? "danger" : "warning";
                                $status_label = $value['status'] == "inactive" ? "primary" : $value['status'] == "active" ? "danger" : "warning";
                                $submission_status_label = ($value['last_submission_status'] == "complied" or $value['last_submission_status'] == "fully") ? "success" : (($value['last_submission_status'] == "breach") ? "danger" : (($value['last_submission_status'] == "none") ? "default" : "warning"));
                                $edit_link = base_url("index.php/Compliance/obligationForm/{$value['id']}");
                                $delete_link = base_url("index.php/Compliance/obligationDelete/{$value['id']}");
                                $preview_link = base_url("index.php/Compliance/obligationPreview/{$value['id']}");
                                ?>

                                <tr>
                                    <td><?= $value['short_code'] ?></td>
                                    <td><a class="link" href="<?= $preview_link ?>"<?= MODAL_LINK ?>><?= ucwords($value['title']) ?></a></td>
                                    <td><?= ucwords($value['compliance']['type']) ?></td>
                                    <td><?= ucwords($value['compliance']['title']) ?></td>
                                    <td>
                                        <span class="label label-pill label-<?= $submission_status_label ?>">
                                            <?= ucwords(str_replace("_", " ", $value['last_submission_status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label label-pill label-<?= $status_label ?>">
                                        <?= ucwords($value ['status']) ?></td>
                                    </span>
                                    <td>
                                        <span class="label label-pill label-<?= $priority_label ?>">
                                            <?= ucwords($value['priority']) ?>
                                        </span>   
                                    </td>
                                    <td><?= ucwords($value['frequency']) ?></td>
                                    <td><div class="btn-group">
                                            <?php if (am_user_type(array(1, 5))): ?>
                                                <a href="<?= $edit_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-pencil"></i></a>
                                                <?php endif; ?>
                                                <?php if (am_user_type(array(1, 5))): ?>
                                                <!--<a href="<?= $delete_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-trash"></i></a></div></td>-->
                                            <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
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




<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });</script>

<!-- Highcharts Pie Chart No of obligations per type -->
<script type="text/javascript">
<?php
$data = json_encode(array(
    array("Statutory", $data['Stat_returns']),
    array("Legal", $data['Legal_req']),
    array("Business", $data['Business_req'])
        ));
?>
    $(function () {
        var myChart = Highcharts.chart('obligation_type', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'No. of Obligations by Type'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    innerSize: 100,
                    depth: 45,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>:<br/> {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }

                }
            },
            series: [{
                    name: 'Number of Obligations',
                    data: <?= $data ?>
                }]
        });
    });</script>
<!-- Highcharts Stacked bar graph Obligations by status -->
<script type="text/javascript">
<?php
$statutory =  json_encode( array($stat_fully ? $stat_fully : 0, $stat_part ? $stat_part : 0, $stat_non_comp ? $stat_non_comp : 0));
$legal =  json_encode( array($legal_fully ? $legal_fully : 0, $legal_part ? $legal_part : 0, $legal_non_comp ? $legal_non_comp : 0));
$business = json_encode(array($business_fully ? $business_fully : 0, $business_part ? $business_part : 0, $business_non_comp ? $business_non_comp : 0));
?>
    Highcharts.chart('stacked_bar', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Obligations Status'
        },
        xAxis: {
            categories: ['Fully Compliant', 'Partially Compliant', 'Not Compliant']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'No of obligations'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'gray'
                }
            }
        },
        series: [{
                name: 'Statutory',
                data: <?= $statutory?>
            }, {
                name: 'Legal',
                data: <?= $legal?>
            }, {
                name: 'Business Compliance',
                data: <?= $business?>
            }]
    });
</script>
<!-- DataTables init Script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table0 = $('#datatable-buttons0').DataTable({
            lengthChange: true
                    //buttons: ['excel', 'pdf', 'colvis']
        });
        var table1 = $('#datatable-buttons1').DataTable({
            lengthChange: true
                    // buttons: ['excel', 'pdf', 'colvis']
        });
        var table2 = $('#datatable-buttons2').DataTable({
            lengthChange: true
                    // buttons: ['excel', 'pdf', 'colvis']
        });
        // table0.buttons().container()
        //         .appendTo('#datatable-buttons0_wrapper .col-md-6:eq(0)');
        // table1.buttons().container()
        //         .appendTo('#datatable-buttons1_wrapper .col-md-6:eq(0)');
        // table2.buttons().container()
        //         .appendTo('#datatable-buttons2_wrapper .col-md-6:eq(0)');
    });</script>
<!-- Calendar Jquery Script -->
<script type="text/javascript">



    !function ($) {
        "use strict";
        var CalendarApp = function () {
            this.$calendar = $('#calendar'),
                    this.$calendarObj = null
        };
        /* Initializing */
        CalendarApp.prototype.init = function () {
            /*  Initialize the calendar  */
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var form = '';
            var today = new Date($.now());
            var Events = [
<?php foreach ($obligations as $key => $value):
    ?>
                    {
                        title: "<?= addslashes($value['title']); ?>",
                        start: '<?= $value['submission_deadline']; ?>',
                        id: '<?= $value['id']; ?>',
                        color: "<?php
    if ($value['submission_deadline'] < date("Y-m-d h:i:sa")) {
        echo "#ff6666";
    } else {
        echo "#99CCff";
    }
    ?>"     //select which color to pass to calendar

                    },<?php endforeach; ?>
            ];
            var $this = this;
            $this.$calendarObj = $this.$calendar.fullCalendar({
                slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
                minTime: '08:00:00',
                maxTime: '19:00:00',
                defaultView: 'month',
                handleWindowResize: true,
                //   height: $(window).height() - 20,   
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: Events,
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar !!!
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                eventClick: function (event) {
                    if (event.id) {
                        window.open("<?php echo site_url('compliance/obligation/'); ?>" + event.id);
                        return false;
                    }
                }

            });
        },
                //init CalendarApp
                $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

    }(window.jQuery),
            //initializing CalendarApp
                    function ($) {
                        "use strict";
                        $.CalendarApp.init()
                    }(window.jQuery);
            var doc = new jsPDF('landscape');
            $(".content-chart-dashboard").css('background', '#fff');
            $('#comp_table_report_export_btn').click(function () {
                doc.addHTML($('.content-chart-dashboard')[0], function () {

                    doc.save('Compliance_report_table.pdf');
                });
            });</script>
<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
