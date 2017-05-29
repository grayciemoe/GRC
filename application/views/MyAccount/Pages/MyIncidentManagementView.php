<?php
$incident = $data['incidents'];
?>
<div class="container-fluid">
    <div class="card card-block">
        <div  class="report_details" id="incidentReportTableView">
            <div id="im_report" class="table-responsive card-block">
                <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
                <table id="datatable-buttons" class="table table-sm table-small table-hover " >
                    <thead>
                        <tr>

                            <th>Incident</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">State</th>
                            <th class="text-center">Date of Incident</th>
                            <th class="text-center">Incident Category</th>
                            <th class="text-center">Experience Type</th>
                            <th class="text-center">Total Cost</th>
                            <th class="text-center">Area of Occurrence  </th>
                            <th class="text-center">Responsible Manager</th>
                            <th class="text-center">Escalation</th>
                            <th class="text-center">Risk</th>
                            <th class="text-center">Risk Category</th>
                            <th class="text-center">Risk Capacity</th>
                            <th class="text-center">Incidents to Date</th>
                            <th style="width:80px">Edit/Delete</th>

                        </tr>
                    </thead>
                    <tbody><?php // print_pre($data['incidents'])                                           ?>

                        <?php
                        $count = 0;
                        foreach ($data['incidents'] as $key => $value):
                            $count++;
                            $edit_link = base_url("index.php/IncidentManagement/incidentForm/{$value['id']}");
                            $delete_link = base_url("index.php/IncidentManagement/actionDelete/{$value['id']}");
                            $preview_link = base_url("index.php/IncidentManagement/incidentPreview/{$value['id']}");
                            $status_label = $value['status'] == "inactive" ? "info" : $value['status'] == "active" ? "success" : "warning";
                            $incident_label = $value['incident'] == "closed" ? "info" : $value['status'] == "open" ? "success" : "warning";
                            ?>
                            <tr>

                                <td  >
                                    <a class="link" href=" <?= base_url("index.php/IncidentManagement/incidentDetail/{$value['id']}"); ?>"><?= $value['title'] ?></a></td>
                                <td class="text-center ">
                                    <span class="label label-pill label-<?= $status_label ?>">
                                        <?= $value['status'] ?>
                                    </span>
                                </td>
                                <td class="text-center ">
                                    <span class="label label-pill label-<?= $status_label ?>">
                                        <?= $value['incident'] ?>
                                    </span>
                                </td>
                                <td class="text-center " >
                                    <span class="text-<?= strtotime($value['date_of_incident']) ?>"> 
                                        <?= strftime(" %b %d %Y", strtotime($value['date_of_incident'])); ?>
                                    </span>
                                </td>
                                <td ><?= $value['category'] ?></td>
                                <td ><?= $value['experience_type'] ?></td>
                                <td ><?= $value['total_cost'] ?></td>
                                <td ><?= $value['environment']['name'] ?></td>
                                <td ><?= $value['responsible_manager']['names'] ?></td>
                                <td class="text-center "><?= ucwords(str_replace("_", " ", $value['escalation_level'])) ?></td>
                                <td ><?= $value['risk']['title'] ?></td>
                                <td ><?= $value['risk_category']['title'] ?></td>
                                <td ><?= $value['risk']['incident_capacity'] ?></td>
                                <td ><?= isset($value['risk']['incidents']) ? count($value['risk']['incidents']) : 0; ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a class="btn btn-secondary btn-sm"  href="<?= $edit_link ?>"><i class="icon icon-pencil"></i> </a>
                                        <a class="btn btn-secondary btn-sm"   href="<?= base_url("index.php/IncidentManagement/incidentDelete/{$value['id']}"); ?>" <?= MODAL_LINK ?>><i class="icon icon-trash"></i> </a>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: true,
            buttons: ['copy', 'excel', 'colvis'],
            "columnDefs": [
                {"visible": false, "targets": [8, 9, 10, 11]}
            ]
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

    var doc = new jsPDF('landscape');
    $("#datatable-buttons").css('background', '#fff');
    $('#comp_table_report_export_btn').click(function () {
        $("#im_report").removeClass('table-responsive');
        $("#im_report").addClass('table');
        doc.addHTML($('#datatable-buttons')[0], function () {

            doc.save('Compliance_report_table.pdf');

        });
        $("#im_report").addClass('table-responsive');
    });

</script>

