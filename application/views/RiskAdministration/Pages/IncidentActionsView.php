<?php
?>
<div class="container-fluid">
    <div class="card card-block">
        <div  class="report_details" id="incidentReportTableView">
            <div id="im_report" class="table-responsive card-block">
                <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
                <table id="datatable-buttons" class="table table-sm table-small table-hover " >
                    <thead>
                        <tr>

                            <th>Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Owner</th>
                            <th class="text-center">Incident</th>
                            <th class="text-center">Due Date</th>

                        </tr>
                    </thead>
                    <tbody><?php // print_pre($data['incidents'])                                           ?>

                        <?php
                        $count = 0;
                        foreach ($data['incidentActions'] as $key => $value):
                            $count++;
                            $status_label = $value['status'] == "complete" ? "success" : "danger";
                            ?>
                            <tr>

                                <td><?= $value['title'] ?></td>
                                <td class="text-center ">
                                    <span class="label label-pill label-<?= $status_label ?>">
                                        <?= $value['status'] ?>
                                    </span>
                                </td>
                                <td class="text-center ">
                                        <?= $value['owner'] ?>
                                </td>
                                <td ><?= $value['incident']['title'] ?></td>
                                <td ><?= $value['due_date'] ?></td>
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

