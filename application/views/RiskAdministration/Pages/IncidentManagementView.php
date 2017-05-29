<?php
$data['incidents'];
?>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <ul class="nav nav-tabs m-b-10 unapproved-compliance-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risk"
                               role="tab" aria-controls="risk" aria-expanded="true">Incidents </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="risk-tab">
                        <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">

                            <table id="datatable-buttons"  class="table table-small-font  table-small table-sm table  table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th class="text-center "> status</th>
                                        <th> Experience type</th>
                                        <th> total_cost</th>
                                        <th class="text-center "> escalation_level</th>
                                        <th> Date of Incident</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['incidents'] as $key => $value):
                                        ?>
                                        <tr>
                                            <td> <a class="link" href="<?= base_url("index.php/IncidentManagement/incidentDetail/{$value['id']}"); ?>" ><?= $value ['title'] ?></a> 
                                            </td>
                                            <td class="text-center "> <span class="label label-pill label-rounded label-<?= $value['approved'] == 'approved' ? "success" : ($value['approved'] == 'pending' ? "warning" : "danger")?>"><?= ucwords($value['approved']) ?></span></td>
                                            <td ><?= $value['experience_type'] ?></td>
                                            <td ><?= $value['total_cost'] ?></td>
                                            <td class="text-center "><?= ucwords(str_replace("_", " ", $value['escalation_level'])) ?></td>
                                            <td><?= strftime("%b %d %Y", strtotime($value ['date_of_incident'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--block-->
            </div><!--card-->
        </div><!--col -->
    </div><!-- content-page -->

    <!-- ============================================================== -->
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
            buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>


<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
