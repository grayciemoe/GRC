<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <h4 class="card-title">Issues</h4>
        </div>

    </div>

    <div class="card">
        <div class="card-block">

            <div id="comp_req" class="table-responsive" >
                <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
                <div class="clearfix"></div>
                <table id="datatable-buttons" class="table table-sm table-small table-hover ">
                    <thead>
                        <tr>
                            <th>Risk Area</th>
                            <th>Title</th>
                            <th>Issue Subheading</th>
                            <th>Action Date</th>
                            <th class="text-center">Issue rating</th>
                            <th class="text-center">Issue Status</th>
                            <th class="text-center">Action Plan Status</th>
                            <th class="text-center">Implication Type</th>
                            <th class="text-center">Recommendations</th>
                            <th style="width: 220px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
//                        foreach ($data['audits'] as $key => $value):
//                            $delete_link = base_url("index.php/Audit/deleteAudit/{$value['id']}");
//                            $edit_link = base_url("index.php/Audit/AuditForm/{$value['id']}");
//                            $add_issue_link = base_url("index.php/Audit/IssueForm/0/{$value['id']}");
                            ?>
                            <tr>
                                <td><?php // $value['ref_code'] ?></td>
                                <td><a href="<?php // base_url("index.php/Audit/Audit/{$value['id']}") ?>"><?php // $value['title'] ?></a></td>
                                <td><?php // $value['environment'] ?></td>

                                <td><?php // $value['date'] ?></td>
                                <td><?php // $value['auditor'] ?></td>
                                <td><?php // $value['auditor'] ?></td>
                                <td><?php // $value['auditor'] ?></td>
                                <td><?php // $value['auditor'] ?></td>
                                <td class="text-center">
                                    <a href="<?php // base_url("index.php/Audit/AuditIssuesList/{$value['id']}") ?>" <?= MODAL_LINK ?> class="label label-pill label-info">
                                        <i class="icon icon-share-alt"></i>
                                        <span>  <?php // ($value['obligations']) ?></span> 
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group pull-right">
                                            <a href="<?php // $add_obligation_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="icon icon-plus"></i> Recommendation</a>
                                        
                                            <a href="<?php // $edit_link ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm"><i class="icon icon-pencil"></i></a>
                                       
                                            <a href="<?php // $delete_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="icon icon-trash"></i></a>
                                           
                                    </div>
                                </td>
                            </tr>
                        <?php // endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var resizefunc = [];
    $('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        
    });

    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');


    var doc = new jsPDF('landscape');
    $("#datatable-buttons").css('background', '#fff');
    $('#comp_table_report_export_btn').click(function () {
        $("#comp_req").removeClass('table-responsive');
        $("#comp_req").addClass('table');
        doc.addHTML($('#datatable-buttons')[0], function () {

            doc.save('Compliance_req_report_table.pdf');

        });
        $("#comp_req").addClass('table-responsive');
    });
</script>