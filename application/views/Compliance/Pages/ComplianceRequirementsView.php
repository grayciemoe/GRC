<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <?php if (am_user_type(array(1, 5))): ?>
                <a href="<?= base_url("index.php/Compliance/complianceRequirementForm/0/") ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small pull-right"><i class="icon icon-plus"></i> New Compliance Requirement</a>
            <?php endif; ?>
            <h4 class="card-title">Compliance Requirement</h4>
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
                            <th>Title</th>
                            <th>Type</th>
                            <th>Repository</th>
                            <th>Area</th>
                            <th class="text-center">Priority</th>
                            <th class="text-center hidden">Completion </th>
                            <th class="text-center">Obligations</th>
                            <th style="width: 220px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data['compliance_requirements'] as $key => $value):
                            $priority_label = $value['priority'] == "Low" ? "info" : $value['priority'] == "Medium" ? "warning" : "danger";
                            $delete_link = base_url("index.php/Compliance/deleteComplianceRequirement/{$value['id']}");
                            $edit_link = base_url("index.php/Compliance/complianceRequirementForm/{$value['id']}");
                            $add_obligation_link = base_url("index.php/Compliance/obligationForm/0/{$value['id']}");
                            $chart_link = base_url("index.php/Compliance/ComplianceRequirementChart/{$value['id']}");
                            $source = isset($value['repository']['source']) ? $repository_sources[$value['repository']['source']] : "N/A";
                            $source_doc = isset($value['repository']['name']) ? $value['repository']['name'] : "N/A";
                            ?>
                            <tr>
                                <td><a href="<?= base_url("index.php/Compliance/complianceRequirement/{$value['id']}") ?>"><?= $value['title'] ?></a></td>
                                <td><?= $value['type'] ?></td>
                                <td><?= $source ?></td>
                                <td><?= $source_doc ?></td>

                                <td class="text-center">
                                    <span class="label label-pill label-<?= $priority_label ?>">
                                        <?= $value['priority'] ?>
                                    </span>
                                </td>
                                <td class="text-center hidden"><?= $value['completion'] != "N/A" ? $value['completion'] . " %" : "N/A"; ?> </td>
                                <td class="text-center">
                                    <a href="<?= base_url("index.php/Compliance/complianceObligationsList/{$value['id']}") ?>" <?= MODAL_LINK ?> class="label label-pill label-info">
                                        <i class="icon icon-share-alt"></i>
                                        <span>  <?= ($value['obligations']) ?></span> 
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <?php if (am_user_type(array(1, 5, 6, 10))): ?>
                                            <a href="<?= $add_obligation_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="icon icon-plus"></i> Obligation</a>
                                        <?php endif; ?>

                                        <?php if (am_user_type(array(1, 5))): ?>
                                            <a href="<?= $edit_link ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm"><i class="icon icon-pencil"></i></a>
                                        <?php endif; ?>
                                        <?php if (am_user_type(array(1, 5)) and ( $value['obligations']) == 0): ?>
                                            <a href="<?= $delete_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="icon icon-trash"></i></a>
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
