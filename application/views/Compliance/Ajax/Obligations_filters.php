<?php //print_pre($data);                 ?>
<div class="card"> 
    <div id="table_compliance" class="card-block table-responsive">
        <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
        <table id="datatable-obligations"  class="table table-sm table-small table-striped" cellspacing="0" width="100%">
            <thead>

                <tr>
                    <th>REF Code</th>
                    <th>Title</th>
                    <th class="hidden">Description</th>
                    <th>Status</th>
                    <th>Approval Status</th>
                    <th>Register</th>
                    <th>Requirement</th>
                    <th>Authority</th>
                    <th>Source Repository</th>
                    <th>Source Document</th>
                    <th>Unit</th>
                    <th>Penalty</th>
                    <th>Primary Owner</th>
                    <th>Secondary Owner</th>
                    <th>Escalation Person</th>
                    <th class="text-center">Priority</th>
                    <th>Frequency</th>
                    <th><?= $data['cr_title'] ?></th>
                    <th>Current Status</th>
                    <th class="hidden"> Complied Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 0;
                foreach ($obligations as $key => $value): $num++;
                    $priority_label = $value['priority'] == "high" ? "warning" : $value['priority'] == "Medium" ? "danger" : "success";
                    $status_label = $value['complied'] == "yes" ? "success" : $value['complied'] == "no" ? "danger" : "warning";
                    $current_label = $value['last_submission_status'] == "complied" ? "danger" : $value['last_submission_status'] == "breach" ? "warning" : "success";
                    $status2_label = $value['status'] == "active" ? "success" : "danger";
                    $approved_label = ($value['approved'] == "approved") ? "success" : (($value['approved'] == "pending") ? "warning" : "danger");
                    ?>
                    <tr>
                        <td><?= $value['short_code'] ?></td>
                        <td><a  title="<?= strip_tags(($value['description'])) ?>" href="<?= base_url("index.php/Compliance/obligation/{$value['id']}") ?>"><?= $value['title'] ?></a> </td>
                        <td class="hidden"><?= $value['description'] ?> </td>
                        <td>
                            <span class="label label-pill label-<?= $status2_label ?>">
                                <?= ucwords($value['status']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="label label-pill label-<?= $approved_label ?>">
                                <?= ucwords($value['approved']) ?>
                            </span></td>
                        <td><?= $value['register']['title'] ?> </td>
                        <td><?= $value['compliance_requirement']['title'] ?> </td>
                        <td><a href="<?= base_url("index.php/Compliance/authority/{$value['authority']['id']}"); ?>" <?= MODAL_LINK ?>><?= $value['authority']['title'] ?></a></td>
                        <td><?= ucwords(str_replace("_", " ", $value['repository']['source'])) ?> </td>
                        <td><?= $value['repository']['name'] ?> </td>
                        <td><?= $value['environment']['name'] ?> </td>
                        <td><?= $value['noncompliance_penalty'] ?> </td>
                        <td><?= isset($value['responsible_manager_1']['names']) ? $value['responsible_manager_1']['names'] : NULL; ?> </td>
                        <td><?= isset($value['responsible_manager_2']['names']) ? $value['responsible_manager_2']['names'] : NULL; ?> </td>
                        <td><?= isset($value['escalation_person']['names']) ? $value['escalation_person']['names'] : NULL; ?> </td>
                        <td class="text-center">
                            <span class="label label-pill label-<?= $priority_label ?>">
                                <?= ucwords($value['priority']) ?>
                            </span>
                        </td>
                        <td><?= $value['repeat'] == 'periodic' ? ucwords($value['frequency']) : "N/A" ?> </td>
                        <td><?= strftime("%b %d %Y", strtotime($value ['submission_deadline'])); ?></td>
                        <td><span class="label label-pill label-<?= $current_label ?>"><?= ucwords(str_replace("_", " ", $value['last_submission_status'])) ?></span> </td>
                        <td class="hidden"><span class="label label-pill label-<?= $status_label ?>">
                                <?= ucwords($value['complied']) ?></span></td>
                        <td>
                            <div class="btn-group pull-right">

                                <?php if (am_user_type(array(1, 5)) and ( $value['pending_breaches'] > 0 or $value['pending_compliants'] > 0)) : ?>
                                    <a href="<?= base_url("index.php/Compliance/ObligationBulkActionApprove/{$value['id']}") ?>" 
                                    <?= MODAL_LINK ?>
                                       class="btn btn-danger btn-sm btn-small">
                                        <i class="icon icon-check"></i> Required Action
                                    </a>
                                <?php endif; ?>


                                <?php if (am_user_type(array(1, 5, 7)) and ( time() + (3600 * 24 * 7) ) > strtotime($value['notification_date'])): ?>
                                    <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$value['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-success btn-sm"><i class="icon icon-check"></i> Have you complied?</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">

    $('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatable-obligations').DataTable({
        lengthChange: true,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        "columnDefs": [
            {"visible": false, "targets": [0, 4, 5, 6, 7, 8, 11, 13, 14]}
        ]
    });

    table.buttons().container()
            .appendTo('#datatable-obligations_wrapper .col-md-6:eq(0)');

//    var doc = new jsPDF('landscape');
//    $("#datatable-obligations").css('background', '#fff');
//    $('#comp_table_report_export_btn').click(function () {
//        $("#table_compliance").removeClass('table-responsive');
//        $("#table_compliance").addClass('table');
//        doc.addHTML($('#datatable-obligations')[0], function () {
//
//            doc.save('Compliance_report_table.pdf');
//
//        });
//        $("#table_compliance").addClass('table-responsive');

</script>
