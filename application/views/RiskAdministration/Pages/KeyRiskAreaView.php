<?php
$kra = $data['kra'];

//print_pre($data);
//die();
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
                               role="tab" aria-controls="risk" aria-expanded="true">Key Risk Areas</a>
                        </li>


                    </ul>


                    <div class="tab-content" id="risk-tab">
                        <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                            <!-- <?= $risk['description'] ?> -->

                            <table  id="datatable-buttons" class="table table-sm table-small  " >
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Approval status</th>
                                        <th>Source</th>
                                        <th>Environment</th>
                                        <th>Date Created</th>
                                        <th></th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($kra as $key => $value):
                                        $preview_link = base_url("index.php/Home/repositoryPreview/{$value['id']}");
                                        $delete_link = base_url("index.php/Home/repositoryDelete/{$value['id']}");
                                        ?>
                                        <tr id="repository-<?= $value['id'] ?>">
                                            <td><a href="<?= $preview_link ?>" <?= MODAL_LINK ?>> <?= $value ['name'] ?> </a></td>
                                            <td><span class="label label-pill label-<?=
                                                $value['approved'] == "approved" ? "success" : (($value['approved'] == "pending") ? "warning" :
                                                                "danger")
                                                ?>" > <?= ucwords($value ['approved']) ?>  </span></td> 
                                            <td> <?= ucwords(str_replace("_", " ", $value ['source'])) ?>  </td> 
                                            <td> <?= isset($value['environment']['name']) ? $value['environment']['name'] : "Not Set" ?>  </td> 
                                            <td> <?= strftime("%b %d %Y", strtotime($value ['created'])); ?> </td>
                                            <td>
                                                <?php if (am_user_type(array(1, 5)) and $value['approved'] == 'rejected'): ?>
                                                    <a class="btn btn-secondary pull-right btn-sm" <?= MODAL_LINK ?> href="<?= $delete_link ?>"><?php
                                                        echo '<i class="icon icon-close"></i> DELETE';
                                                        ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
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

</script>


<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
