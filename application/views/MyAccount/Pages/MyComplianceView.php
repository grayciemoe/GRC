<?php $obligations = $data['obligation'];?>

<div class="container-fluid">
    

    
    
    <div class="card"> 

        <div id="table_compliance_report" class="card-block table-responsive">
            <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
            <table id="datatable-obligations"  class="table table-sm table-small table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>REF Code</th>
                        <th>Title</th>
                        <th class="hidden">Description</th>
                        <th>Register</th>
                        <th>Requirement</th>
                        <th>Authority</th>
                        <th>Source Repository</th>
                        <th>Source Document</th>
                        <th>Unit</th>
                        <th>Penalty</th>
                        <th>Responsible manager</th>
                        <th class="text-center">Priority</th>
                        <th>Frequency</th>
                        <th>Submission deadline</th>
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
                    ?>
                    <tr>
                        <td><?= $value['short_code'] ?></td>
                        <td><a  title="<?= strip_tags(($value['description'])) ?>" href="<?= base_url("index.php/Compliance/obligation/{$value['id']}") ?>"><?= $value['title'] ?></a> </td>
                        <td class="hidden"><?= $value['description'] ?> </td>
                        <td><?= $value['register']['title'] ?> </td>
                        <td><?= $value['compliance_requirement']['title'] ?> </td>
                        <td><a href="<?= base_url("index.php/Compliance/authority/{$value['authority']['id']}"); ?>" <?= MODAL_LINK ?>><?= $value['authority']['title'] ?></a></td>
                        <td><?= ucwords(str_replace("_", " ", $value['repository']['source'])) ?> </td>
                        <td><?= $value['repository']['name'] ?> </td>
                        <td><?= $value['environment']['name'] ?> </td>
                        <td><?= $value['noncompliance_penalty'] ?> </td>
                        <td><?= $value['responsible_manager_1'] ['names'] ?> </td>
                        <td class="text-center">
                            <span class="label label-pill label-<?= $priority_label ?>">
                                <?= ucwords($value['priority']) ?>
                            </span>
                        </td>
                        <td><?= ucwords($value['frequency']) ?> </td>
                        <td><?= strftime("%m/%d/%y", strtotime($value ['submission_deadline']));
                                ?></td>
                        <td>
                            <span class="label label-pill label-<?= $current_label ?>"><?= $value['last_submission_status'] ?></span> </td>

                        <td class="hidden"><span class="label label-pill label-<?= $status_label ?>">
                                <?= ucwords($value['complied']) ?></span></td>
                        <td>
                            <div class="btn-group pull-right">
                                <?php if ($value['last_submission_status'] == 'late_review' or $value['last_submission_status'] == 'breach') : ?>
                                    <?php if (am_user_type(array(1, 5, 6, 10))): ?>    
                                <a href="<?= base_url("index.php/Compliance/obligationAction/{$value['id']}") ?>" 
                                        <?= MODAL_LINK ?>
                                   class="btn btn-danger btn-sm btn-small">
                                    <i class="icon icon-check"></i> Take Action 
                                </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ((time() + (3600 * 24 * 7) ) > strtotime($value['submission_deadline']) and $value['last_submission_status'] == 'complied'): ?>
                                    <?php if (am_user_type(array(1, 5, 6, 10))): ?>    
                                <a href="<?= base_url("index.php/Compliance/obligationAction/{$value['id']}") ?>" 
                                        <?= MODAL_LINK ?>
                                   class="btn btn-secondary btn-sm btn-small ">
                                    Have you complied <i class="icon icon-question"></i>
                                </a>
                                    <?php endif; ?>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table = $('#datatable-obligations').DataTable({
            lengthChange: true,
            buttons: ['copy', 'excel', 'colvis'],
        });
        table.buttons().container()
                .appendTo('#datatable-obligations_wrapper .col-md-6:eq(0)');
    });
    var doc = new jsPDF('landscape');
    $("#datatable-obligations").css('background', '#fff');
    $('#comp_table_report_export_btn').click(function () {
        $("#table_compliance_report").removeClass('table-responsive');
        $("#table_compliance_report").addClass('table');
        doc.addHTML($('#datatable-obligations')[0], function () {

            doc.save('Comp_report_table.pdf');

        });
        $("#table_compliance_report").addClass('table-responsive');
    });
</script>
