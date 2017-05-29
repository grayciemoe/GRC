<?php
$issueslist = $data['issueslist'];
?>
<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-2 ">
            <div class="card-box tilebox-two">
                <i class="icon-magnifier pull-xs-right text-muted"></i>
                <h6 class="text-success text-uppercase m-b-15 m-t-10">Total <br /> Audits </h6>
                <h2 class="m-b-10"><span data-plugin="counterup"></span><?= $data['audits'] > 0 ? $data['audits'] : 0 ?></h2>
            </div>


        </div><!--end of col-sm-2-->

        <div class="col-sm-2 ">
            <div class="card-box tilebox-two">
                <i class="fa fa-exclamation-triangle pull-xs-right text-muted"></i>
                <h6 class="text-primary text-uppercase m-b-15 m-t-10">Total <br /> Issues</h6>
                <h2 class="m-b-10"><span data-plugin="counterup"></span><?= $data['issues'] > 0 ? $data['issues'] : 0 ?></h2>
            </div>
        </div><!--end of col-sm-2-->
        <div class="col-sm-2 ">
            <div class="card-box tilebox-two">
                <i class="icon-layers pull-xs-right text-muted"></i>
                <h6 class="text-pink text-uppercase m-b-15 m-t-10">Unpublished issues</h6>
                <h2 class="m-b-10" data-plugin="counterup"><?= $data['issuesunpublished'] > 0 ? $data['issuesunpublished'] : 0 ?></h2>
            </div>
        </div><!--end of col-sm-2-->
        <div class="col-sm-2 ">
            <div class="card-box tilebox-two">
                <i class="fa fa-pencil-square-o pull-xs-right text-muted"></i>
                <h6 class="text-info text-uppercase m-b-15 m-t-10">Published to Management</h6>
                <h2 class="m-b-10"><span data-plugin="counterup"></span><?= $data['issuespublishedtoMgnt'] > 0 ? $data['issuespublishedtoMgnt'] : 0 ?></h2>
            </div>
        </div>

        <div class="col-sm-2 ">
            <div class="card-box tilebox-two">
                <i class="fa fa-sticky-note-o pull-xs-right text-muted"></i>
                <h6 class="text-success text-uppercase m-b-15 m-t-10">Published to CEO</h6>
                <h2 class="m-b-10"><span data-plugin="counterup"></span><?= $data['issuesunpublishedtoCEO'] > 0 ? $data['issuesunpublishedtoCEO'] : 0 ?></h2>
            </div>


        </div><!--end of col-sm-2-->

        <div class="col-sm-2 ">
            <div class="card-box tilebox-two">
                <i class="fa fa-paper-plane-o pull-xs-right text-muted"></i>
                <h6 class="text-info text-uppercase m-b-15 m-t-10">Published to Board</h6>
                <h2 class="m-b-10"><span data-plugin="counterup"></span><?= $data['issuesunpublishedtoBoard'] > 0 ? $data['issuesunpublishedtoBoard'] : 0 ?></h2>
            </div>


        </div><!--end of col-sm-2-->


    </div><!--end of main row-->

    <div class="row">
        <div class="col-sm-4">
            <div class="card">

                <div class="card-block">
                    <h5 class="card-title">Open vs Closed issues</h5>
                    <?php
                    $chart_id = "chart_name_variable_rules";
                    $data101 = array(
                        array("name" => "Open Issues", "value" => $data['openIssues'], "color" => "#992222"),
                        array("name" => "Closed Issues", "value" => $data['closedIssues'], "color" => "#55cc55"),
                    );
                    ?>
                    <?= pie_chart_cs($chart_id, $data101) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">

                <div class="card-block">
                    <h5 class="card-title">Issues per Audit Area</h5>

                    <table class="table table-small table-sm m-t-10">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Audit area</th>
                                <th class="text-center">Issues Count</th>
                            </tr>
                        </thead>
                        <?php $num = 0;
                        foreach ($data['audit_area'] as $key => $value): $num++; ?>
                            <tr>
                                <td><?= $num ?></td>
                                <td><?= ucwords(strtolower($value['title'])) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('index.php/Audit/AuditAreaIssuesList/'.$value['id'])?>" <?= MODAL_LINK ?>>
                                        <span class="label label-danger">
                                            <i class="icon icon-share-alt"></i>   <?= $value['issue_count'] ?>
                                        </span>
                                    </a>
                                </td>
                            </tr>
<?php endforeach; ?>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Issues</h4>
<?= form_open_multipart("Audit/issues_filter", array("id" => "frm_issues_filter", "class" => null)); ?>
                    <input hidden name="corpId" value="<?= $data['corpId']?>"/>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-audit">Audit</label>
                                        <select name="audit" id="txt-filter-audit" onchange="issues_filter()" class="form-control form-control-sm">
                                            <option value="0">Select Audit</option>
                                            <?php foreach ($data['auditslist'] as $key => $value): ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['audit_name'] ?></option>
<?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-issue_rating">Issue Rating</label>
                                        <select name="issue_rating" id="txt-filter-issue_rating" onchange="issues_filter()" class="form-control form-control-sm">
                                            <option value="">Select Issue Rating</option>
                                            <option value='Low'>Low</option>
                                            <option value='Moderate'>Moderate</option>
                                            <option value='High'>High</option>
                                            <option value='Critical'>Critical</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-implication_type">Implication Type</label>
                                        <select name="implication_type" id="txt-filter-implication_type" onchange="issues_filter()" class="form-control form-control-sm">
                                            <option value="">Select Implication Type</option>
                                            <option value="Loss of Opportunity">Loss of Opportunity</option>
                                            <option value="Risk Exposure">Risk Exposure</option>
                                            <option value="Actual Loss">Actual Loss</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-issue_status">Issue Status</label>
                                        <select name="issue_status" id="txt-filter-issue_status" onchange="issues_filter()" class="form-control form-control-sm">
                                            <option value="">Select Issue Status</option>
                                            <option value="Open">Open</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-auditArea">Audit Area</label>
                                        <select name="auditArea" id="txt-filter-auditArea" onchange="issues_filter()" class="form-control form-control-sm">
                                            <option value="0">Select Audit Area</option>
                                            <?php foreach ($data['auditArealist'] as $key => $value): ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
<?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
<?= form_close(); ?>
                </div>
            </div>
            <div class="" id="issues_filter_list">

            </div>


        </div>

    </div>


    <script>
        var resizefunc = [];
//        $('#datatable').DataTable();
//        //Buttons examples
//        var table = $('#datatable-buttons').DataTable({
//            lengthChange: false,
//            buttons: ['copy', 'excel', 'pdf', 'colvis'],
//        });
//
//        table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
//
//
//        var doc = new jsPDF('landscape');
//        $("#datatable-buttons").css('background', '#fff');
//        $('#comp_table_report_export_btn').click(function () {
//            $("#comp_req").removeClass('table-responsive');
//            $("#comp_req").addClass('table');
//            doc.addHTML($('#datatable-buttons')[0], function () {
//
//                doc.save('Compliance_req_report_table.pdf');
//
//            });
//            $("#comp_req").addClass('table-responsive');
//        });
    </script>
    <script>

        $(document).ready(function () {
            issues_filter();
        });

        //    function frequency_filter(value) {
        //        $('.filter-period').addClass('hidden');
        //        $('#period-' + value).removeClass('hidden');
        //        $('#txt-filter-period').focus();
        //        issues_filter();
        //    }



        function issues_filter() {
            var url = $("#frm_issues_filter").attr("action");
            $.post(url, $("#frm_issues_filter").serialize(), function (response) {
//                alert(response);
                $("#issues_filter_list").html(response);
            });
//            setTimeout((function () {
//                obligations_filter();
//            }), 1000);
        }

    </script>

