<?php
$data['complies'];
if (am_user_type(array(7))) {
    restricted_view();
    return false;
}

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
                               role="tab" aria-controls="risk" aria-expanded="true">Pending Breach</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="control-tab" data-toggle="tab" href="#control"
                               role="tab" aria-controls="control" aria-expanded="true">  Pending Complied</a>
                        </li>


                    </ul>


                    <div class="tab-content" id="risk-tab">
                        <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                            <!-- <?= $risk['description'] ?> -->

                            <table id="datatable-buttons"  class="table table-small-font  table-small table-sm table  table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th> status</th>
                                        <th> Approved</th>
                                        <th> Type</th>


                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data['breaches'] as $key => $value):

                                        $status_label = $value['status'] == "open" ? "danger" : $value['status'] == "closed" ? "danger" : "warning";
                                        ?>

                                        <tr>
                                            <td> <a class="link" href="<?= base_url("index.php/Compliance/compliant/{$value['id']}"); ?>" <?= MODAL_LINK ?>><?= $value ['title'] ?></a> </td>
                                            <td> 
                                                <span class="label label-pill label-<?= $status_label ?>">
                                                    <?= $value ['status'] ?> </span></td>
                                            <td> <?= $value ['approved'] ?> </td>

                                            <td> <?= $value ['type'] ?> </td>




                                        </tr>
                                    <?php endforeach; ?> 

                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="control" aria-labelledby="control-tab">
                            <!-- <?= $risk['event_of_risk'] ?> -->

                            <table id="datatable-buttons"  class="table table-small-font  table-small table-sm table  table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th> status</th>
                                        <th> Approved</th>
                                        <th> Type</th>


                                </thead>
                                <tbody>
                                    <?php foreach ($data['complies'] as $key => $value):
                                        ?>

                                        <tr>
                                            <td> <a class="link" href="<?= base_url("index.php/Compliance/breach/{$value['id']}"); ?>" <?= MODAL_LINK ?>><?= $value ['title'] ?></a> </td>
                                            <td> 


                                            <td> <?= $value ['completion'] ?> </td>

                                            <td> <?= $value ['period_name'] ?> </td>




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


