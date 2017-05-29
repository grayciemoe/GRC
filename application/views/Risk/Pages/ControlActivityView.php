<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php // $data['activities'];
//print_pre($data);
//die();
?>
<div class="container-fluid">
    <div class="card card-header bg-light">
        <h4 class="card-title">Risk Control Activities</h4>
    </div>
    <div class="card card-block">
   
            <table class="table table-striped table-control table-bordered table-small table-sm" id="datatable-buttons" >
                <thead>
                    <tr>
                        <th style="width:10px">No</th>
                        <th>Name</th>
                        <th>Control</th>
                        <th>Risk</th>
                        <th>Completion Status</th>
                        <th>Criticality</th>
                        <th>Owner</th>
                        <th>Action By</th>
                        <th>Type</th>
                        <th>Action Due Date</th>
                        <th>Frequency</th>
                        <th>Next Review</th>
                        <th>Last Review</th>
                        <th>Review Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($data['activities'] as $key => $value):
                        $count++;
                        ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><a href="<?= base_url("index.php/Risk/activity/{$value['id']}") ?>" <?= MODAL_LINK ?>><?= ucwords($value['name']) ?></a></td>
                            <td><a href="<?= base_url("index.php/Risk/control/{$value['control']['id']}") ?>"><?= ucwords($value['control']['title']) ?></a></td>
                            <td><a href="<?= base_url("index.php/Risk/risk/{$value['risk_details']['id']}") ?>"><?= ucwords($value['risk_details']['title']) ?></a></td>
                            
                            <td><span class="label label-pill label-<?=
                                $value['status'] == 'incomplete' ? "default" :
                                        "success"
                                ?>"><?= ucwords($value['status']) ?> </span></td>
                            <td>
                                <span class="label label-pill label-<?=
                                      $value['criticality'] == 'high' ? "danger" :
                                              ($value['criticality'] == 'medium' ? "warning" : "primary")
                                      ?>">
                                          <?= ucwords($value['criticality']) ?>
                                </span>
                            </td>
                            <td><?= ucwords($value['owner']['names']) ?></td>
                            <td><?= $value['action_by'] ?></td>
                            <td><?= ucwords($value['type']) ?></td>
                            <td><?= strftime("%b %d %Y",strtotime($value['action_due_date'])) ?></td>
                            <td><?= ucwords($value['frequency']) ?></td>
                            <td><?= strftime("%b %d %Y",strtotime($value['next_review'])) ?></td>
                            <td><?= strftime("%b %d %Y",strtotime($value['last_review'])) ?></td>
                            <td><span class="label label-pill label-<?=
                                $value['review_status'] == 'pending' ? "warning" : $value['review_status'] == 'approved' ? "success" :
                                        "danger"
                                    ?>"><?= ucwords($value['review_status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

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
