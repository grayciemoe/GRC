<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <?php if (am_user_type(array(1, 8))): ?>
                <a href="<?= base_url("index.php/Audit/AuditForm/0/". $data['corpId']) ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small pull-right"><i class="icon icon-plus"></i> New Audit</a>
            <?php endif; ?>
            <h4 class="card-title">Audits</h4>
        </div>

    </div>

    <div class="card">
        <div class="card-block">

            <div id="comp_req" class="table-responsive" >
                <div class="clearfix"></div>
                <table id="datatable-buttons" class="table table-sm table-small table-hover ">
                    <thead>
                        <tr>
                            <th>Ref Code</th>
                            <th>Audit Name</th>
                            <th>Audit As At</th>
                            <th class="text-center">Auditor</th>
                            <th class="text-center">Issues</th>
                            <th style="width: 220px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data['audits'] as $key => $value):
                            $delete_link = base_url("index.php/Audit/deleteAudit/{$value['id']}");
                            $edit_link = base_url("index.php/Audit/AuditForm/{$value['id']}/{$value['corporate']}");
                            $add_issue_link = base_url("index.php/Audit/IssueForm/0/{$value['id']}");
                            ?>
                            <tr>
                                <td><small><?= $value['ref_code'] ?></small></td>
                                <td><a href="<?= base_url("index.php/Audit/Audit/{$value['id']}") ?>"><?= ucwords($value['audit_name']) ?></a>
                                 <?php if ($value['published_board'] == 1): ?>
                                            <span class="label label-success">Published To Board</span>
    <?php endif; ?>
                                </td>

                                <td><?= strftime("%b-%d-%Y", strtotime($value['audit_date'])) ?></td>
                                <td><?= $value['auditor']['names'] ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url("index.php/Audit/AuditIssuesList/{$value['id']}") ?>" <?= MODAL_LINK ?> class="label label-pill label-info">
                                        <i class="icon icon-share-alt"></i>
                                        <span> <?= $value['issues'] ?></span> 
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <?php
                                        if ($value['published_board'] == 1) {
                                            $disable = "disabled";
                                        } else {
                                            $disable = "";
                                        }
                                        if($value['issues'] > 0){
                                            $disable2 = "disabled";
                                        }else{
                                            $disable2 = "";
                                        }
                                        ?>
                                       <?php if (am_user_type(array(8))): ?>
                                        <a href="<?= $add_issue_link ?>" class="btn btn-secondary btn-sm <?= $disable ?>"><i class="icon icon-plus"></i> Issue</a>

                                        <a href="<?= $edit_link ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm <?= $disable ?>"><i class="icon icon-pencil"></i></a>

                                        <a href="<?= $delete_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm <?= $disable2 ?> <?= $disable ?>"><i class="icon icon-trash"></i></a>
<?php endif; ?>
                                    </div>
                                </td>
                            </tr>
<?php endforeach; ?>
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