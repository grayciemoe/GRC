<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><div class="container-fluid">

    <div class="row">

        <div class="col-sm-3">
            <?= form_open_multipart("IncidentManagement/incidentFilter", array("id" => "frm_inc_repost_filter")); ?>
            <input type="hidden" id="active_tab" name="active_tab" value="incidentReportChartView" />
            
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_gross-risk" class="card-title h5 link collapse-cmd open">
                        Dates Filters
                        <div class="pull-right " id="card_gross-risk_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_gross-risk">
                        <hr>
                        <div class="radio radio-inline">
                            <input type="radio" id="inlineRadio2" checked="" name="filter_date" onchange="incidentFilter()"  value="resolution_date" />
                            <label for="inlineRadio2"> Resolution Date </label>
                        </div>
                        <div class="radio radio-info radio-inline">
                            <input type="radio" id="inlineRadio1" onchange="incidentFilter()"  name="filter_date" value="date_reported" />
                            <label for="inlineRadio1"> Date Reported </label>
                        </div>
                        <hr>    
                        <div class="form-group">
                            <label for="form-control-label">From</label>
                            <div>
                                <div class="input-group input-group-sm ">
                                    <input type="date" class="form-control" onchange="incidentFilter()" placeholder="dd/mm/yyyy" name="start_date" value="2015-01-01" >
                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                </div><!-- input-group -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">To</label>
                            <div>
                                <div class="input-group input-group-sm ">
                                    <input type="date" class="form-control" onchange="incidentFilter()"  placeholder="dd/mm/yyyy" name="end_date" value="2018-12-31" >
                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                </div><!-- input-group -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card collapse-grc">
                <div class="card-block">
                    <a href="#" data-target="#card_status" class="card-title h5 link collapse-cmd">
                        Status
                        <div class="pull-right " id="card_status_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_status">
                        <hr>

                        <div class="checkbox checkbox-primary">
                            <input id="checkbox_register_active" type="checkbox"  name="status[]" value="active" onchange="incidentFilter();"  >
                            <label for="checkbox_register_active">Active</label>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox_register_inactive" type="checkbox"  name="status[]" value="inactive" onchange="incidentFilter();"  >
                            <label for="checkbox_register_inactive">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_state" class="card-title h5 link collapse-cmd">
                        State
                        <div class="pull-right " id="card_state_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_state">
                        <hr>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox_state_open" type="checkbox"  name="state[]" value="open" onchange="incidentFilter();"  >
                            <label for="checkbox_state_open">Open</label>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox_state_closed" type="checkbox"  name="state[]" value="closed" onchange="incidentFilter();"  >
                            <label for="checkbox_state_closed">Closed</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_categories" class="card-title h5 link collapse-cmd">
                        Incident Category
                        <div class="pull-right " id="card_categories_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_categories">
                        <hr>
                        <?php foreach ($data['incident_categories'] as $key => $value): ?>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_category_of_incident_<?= $value['id'] ?>" type="checkbox"  name="category[]" value="<?= $value['id'] ?>" onchange="incidentFilter();"  >
                                <label for="checkbox_category_of_incident_<?= $value['id'] ?>"><small><?= $value['title'] ?></small></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_units" class="card-title h5 link collapse-cmd">
                        Risk Category
                        <div class="pull-right " id="card_units_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_units">
                        <hr>
                        <?php
                        foreach ($data['incidents'] as $key => $value) :
                            if ($value['risk_category']['title'] == "") {
                                continue;
                            }
                            ?>
                            <div class="checkbox checkbox-primary">
                                <input id="risk_category_<?= $key ?>" type="checkbox"  name="risk_category[]" value="<?= $key ?>" onchange="incidentFilter();"  >
                                <label for="risk_category_<?= $key ?>">
                                    <?= $value['risk_category']['title'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_risks" class="card-title h5 link collapse-cmd">
                        Risks
                        <div class="pull-right " id="card_risks_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_risks">
                        <hr>
                        <?php foreach ($data['incident_risks'] as $key => $value) : ?>
                            <div class="checkbox checkbox-primary">
                                <input id="risk_risk_<?= $value['id'] ?>" type="checkbox"  name="risk[]" value="<?= $value['id'] ?>" onchange="incidentFilter();"  >
                                <label for="risk_risk_<?= $value['id'] ?>">
                                    <?= $value['title'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php // print_pre($data['incident_risks']);  ?>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_risk_sources" class="card-title h5 link collapse-cmd">
                        Actual Loss
                        <div class="pull-right " id="card_risk_sources_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_risk_sources">
                        <hr>
                        <input type="text" id="total_cost" name="total_cost" value="0" onchange="incidentFilter();"  >
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>  
        <div class="col-sm-9">
            <div class="card">
                <div class="card-header bg-white">
                    <button type="button" data-target="incidentReportTableView" class="report_view pull-right btn btn-secondary btn-sm waves-effect waves-light "><i class="icon icon-list"></i> Table </button>
                    <button type="button" data-target="incidentReportChartView" class="report_view pull-right btn btn-secondary btn-sm waves-effect waves-light hidden"><i class="icon icon-chart"></i> Chart </button>
                    <h4 class="card-title">Filtered Report</h4>
                </div>
                <div id="incidentReportView"></div>
            </div>
        </div>
    </div>
</div><!--endof container-->
<script>
    $("#total_cost").ionRangeSlider({
        min: 0,
        max: <?php echo $data['max_total_cost']; ?>,
        from: <?php echo $data['max_total_cost']; ?>,
        step: 100

    });
    $("#total_cost").on("change", function () {
        var $this = $(this),
                value = $this.prop("value");
        incidentFilter();
    });
    function incidentFilter() {

        $("#incidentReportView").animate({opactity: 0.4}, "fast");
        var url = $("#frm_inc_repost_filter").attr("action");
        // $("#incidentReportView").html(url);
        //window.location(url)
        $.post(url, $("#frm_inc_repost_filter").serialize(), function (response) {
            //alert(response);
            $("#incidentReportView").html(response);
            $("#incidentReportView").animate({opactity: 1}, "fast");
        });
    }

    $(document).ready(function () {
        incidentFilter();
        $('#datepicker-autoclose0')
                .datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd",
                }).on("changeDate", function (e) {
            incidentFilter();
        });
        $('#datepicker-autoclose1')
                .datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd",
                }).on("changeDate", function (e) {
            incidentFilter();
        });
        $('#datepicker-autoclose2')
                .datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd",
                }).on("changeDate", function (e) {
            incidentFilter();
        });
        $('#datepicker-autoclose3')
                .datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd",
                }).on("changeDate", function (e) {
            incidentFilter();
        });
    })

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
            "columnDefs": [
                {"visible": false, "targets": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]}
            ]
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $('.cr_details_toggle').click(function (parameters) {
        $('#cr_details').slideToggle('fast');
        $('.cr_details_toggle').toggleClass('hidden');
    });

    $('.report_view').click(function () {
        $('.report_view').toggleClass('hidden');
        var tab = ($(this).data("target"));
        $('#active_tab').val(tab);
        incidentFilter();

    });
    $(document).ready(function () {
        $('#cr_details').hide(0);
    })

</script>