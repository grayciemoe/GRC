<?php
// $data['risks'];
// print_pre($data);
// die();
?>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <ul class="nav nav-tabs m-b-10 unapproved-details-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risk"
                               role="tab" aria-controls="risk" aria-expanded="true">Risk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="control-tab" data-toggle="tab" href="#control"
                               role="tab" aria-controls="control" aria-expanded="true">  Control</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="control_activity-tab" data-toggle="tab" href="#control_activity"
                               role="tab" aria-controls="control_activity">Control Activity</a>
                        </li>

                    </ul>


                    <div class="tab-content" id="risk-tab">
                        <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                            <!-- <?= $risk['description'] ?> -->
                            
                            <table id="datatable-buttons" class="table table-sm table-small ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th> status</th>
                                        <th> Approval Status</th>
                                        <th> risk Owner</th>
                                        <th>Date Created</th>

                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data['risks'] as $key => $value):
                                        $status_label = $value['status'] == "Open" ? "danger" : $value['status'] == "Closed" ? "danger" : "warning";
                                        ?>
                                        <tr>
                                            <td> <a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a> </td>
                                            <td>
                                                <span class="label label-pill label-<?= $status_label ?>">
                                                    <?= $value ['status'] ?> </span> </td>
                                            <td><span class="label label-pill label-<?=
                                                $value['approved'] == 'Pending' ? "warning" :
                                                        "success"
                                                ?>" > <?= $value ['approved'] ?> </span></td>


                                            <td> <?= $value ['risk_owner'] ['names'] ?> </td>

                                            <td> <?= strftime("%b %d %Y", strtotime($value ['date_created'])); ?> </td>



                                        </tr>
                                    <?php endforeach; ?> 

                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="control" aria-labelledby="control-tab">
                            <!-- <?= $risk['event_of_risk'] ?> -->
                            
                            <table id="datatable-buttons1" class="table table-sm table-small ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th><i class="icon icon-user"></i>&nbsp; Control Owner</th>
                                        <th>Risk</th>
                                        <th>Approval Status</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data['controls'] as $key => $value):
                                        $status_label = $value['status'] == "Open" ? "danger" : $value['status'] == "Closed" ? "danger" : "warning";
                                        ?> 
                                        <tr>
                                            <td><a class="link" href="<?= base_url("index.php/Risk/control/{$value['id']}") ?>"><?= $value['title'] ?></a></td>
                                            <td> <?= $value ['owner']['names'] ?> </td>
                                            <td> <?= $value ['risk']['title'] ?> </td>
                                            <td><span class="label label-pill label-<?=
                                $value['approval_status'] == "approved" ? "success" : (($value['approval_status'] == "pending") ? "warning" :
                                        "danger")
                                            ?>" > <?= ucwords($value ['approval_status']) ?>  </span></td>
                                            <td><span class="label label-pill label-<?= $status_label ?>"> 
                                                    <?= $value ['status'] ?> 
                                                </span></td>
                                            <td> <?= $value ['type'] ?> </td>
                                            <td> <?= strftime("%b %d %Y", strtotime($value ['created'])); ?> </td>

                                        </tr>
                                    <?php endforeach; ?> 

                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="control_activity" role="tabpanel" aria-labelledby="control_activity">
                            <!-- <?= $risk['effects_of_risk'] ?> -->
                            <table id="datatable-buttons2" class="table table-sm table-small ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th><i class="icon icon-user"></i>&nbsp; Control Owner</th>
                                        <th>Control</th>
                                        <th>Status</th>
                                        <th>Review status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data['activities'] as $key => $value):
                                        $status_label = $value['status'] == "Open" ? "danger" : $value['status'] == "Closed" ? "danger" : "warning";
                                        ?>
                                        <tr>
                                            <td><a class="link" href="<?= base_url("index.php/Risk/activity/{$value['id']}") ?>" <?= MODAL_LINK ?>><?= $value['name'] ?></a></td>
                                            <td> <?= $value ['owner']['names'] ?> </td>
                                            <td> <?= $value ['control']['title'] ?> </td>
                                            <td>
                                                <span class="label label-pill label-<?= $status_label ?>">
                                                    <?= $value ['status'] ?> </span></td>
                                            <td><span class="label label-pill label-<?=
                                                $value['review_status'] == "approved" ? "success" : (($value['review_status'] == "pending") ? "warning" :
                                                                "danger")
                                                ?>" > <?= ucwords($value ['review_status']) ?>  </span></td>

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



    <div class="row hidden">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="card-title">Risks Pending Approval</div>
                    <ul class="nav nav-tabs m-b-10 unapproved-details-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risk"
                               role="tab" aria-controls="risk" aria-expanded="true">Risk</a>
                        </li>
                    </ul>


                    <div class="tab-content" id="risk-tab">
                        <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                            <!-- <?= $risk['description'] ?> -->

                            <table id="datatable-buttons3" class="table table-sm table-small ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th> status</th>
                                        <th> Approved</th>
                                        <th> risk Owner</th>
                                        <th>Date Created</th>

                                </thead>
                                <tbody>
                                    <?php foreach ($data['undefined'] as $key => $value): ?>

                                        <tr>
                                            <td> <a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a> </td>
                                            <td> <?= $value ['status'] ?> </td>
                                            <td> <?= $value ['approved'] ?> </td>
                                            <td> <?= $value ['risk_owner'] ['names'] ?> </td> 
                                            <td> <?= strftime("%b %d %Y", strtotime($value ['date_created'])); ?> </td>



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
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });


    $(document).ready(function () {
        $('#datatable').DataTable();



        //Buttons examples
        var table = $('#datatable-buttons1').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons1_wrapper .col-md-6:eq(0)');
    });



    $(document).ready(function () {
        $('#datatable').DataTable();



        //Buttons examples
        var table = $('#datatable-buttons2').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons2_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function () {
        $('#datatable').DataTable();



        //Buttons examples
        var table = $('#datatable-buttons3').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons3_wrapper .col-md-6:eq(0)');
    });

</script>


<!-- App js -->
