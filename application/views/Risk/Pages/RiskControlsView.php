<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?>
<div class="container-fluid">
    <div class="card card-header bg-light">
        <h4 class="card-title">Risk Controls</h4>
    </div>
    <div class="card">
        <div class="card-block">

            <table class="table table-striped table-small table-sm table-control table-bordered  " id="datatable-buttons" >
                <thead>
                    <tr>
                        <th style="width:40px">No</th>
                        <th>Title</th>
                        <th>status</th>
                        <th>Control Category</th>
                        <th>criticality</th>
                        <th>Control owner</th>
                        <th>Type</th>
                        <th>Risk</th>                        
                        <th>Approval Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    //print_pre($data['controls']);
                    foreach ($data['controls'] as $key => $value):
                        $count++;
                        ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><a href="<?= base_url("index.php/Risk/control/{$value['id']}"); ?>"><?= ucwords($value['title']) ?></a></td>
                            <td><span class="label label-pill label-<?=
                                $value['status'] == 'incomplete' ? "default" :
                                        "success"
                                ?>" > 
                                    <?= ucwords($value['status']) ?> </span></td>
                            <td><?= $value['control_categories']['title'] ?></td>

                            <td><span class="label label-pill label-<?=
                                $value['criticality'] == 'high' ? "danger" :
                                        ($value['criticality'] == 'medium' ? "warning" : "primary")
                                ?>">
                                          <?= ucwords($value['criticality']) ?>
                                </span>
                            </td>
                            <td><?= $value['owner']['name'] ?></td>
                            <td><span class="label label-pill label-<?=
                                      $value['type'] == 'proposed' ? "default" :
                                              "success"
                                      ?>" >
                                    <?= ucwords($value['type']) ?> </span></td>
                            <td><?= $value['risk_details']['title'] ?></td>
                            
                            <td><span class="label label-pill label-<?=
                                $value['approval_status'] == 'rejected' ? "danger" :
                                        ($value['approval_status'] == 'pending' ? "warning" : "success")
                                ?>"><?= ucwords($value['approval_status'])?></td>

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
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>
