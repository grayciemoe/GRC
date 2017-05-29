<?php
$issue = $data['issues'];

//print_pre($data);exit;
//if (!am_user_type(array(1, 9, 6, 5))) {
//    restricted_view();
//    return false;
//}
//
?>  <div class="container-fluid">
    <div class="card card-header bg-light">
        <h4 class="card-title">Associate Audit Issues to Risk(s)</h4>
    </div>
    <div class="card">
        <hr class="m-0">
        <div class="card-block">
            <table class="table table-striped table-sm table-small" id="datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Issue Title</th>
                        <th>Audit Name</th>
                        <th>Issue Owner</th>
                        <th>Audit Area</th>
                        <th>Issue Rating</th>
                        <th>Issue Status</th>
                        <th>Select Risks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0;
                    foreach ($issue as $key => $value): $count++; ?>
                        <tr>
                            <td scope="row">
    <?= $count ?>
                            </td>
                            <td><a href="<?= base_url('index.php/Audit/issue/' . $value['id']) ?>"><?= ucwords($value['title']) ?></a></td>
                            <td><a href="<?= base_url('index.php/Audit/audit/' . $value['audit']['id'] . '') ?>"><?= ucwords($value['audit']['audit_name']) ?></a></td>
                            <td><?= $value['issue_owner']['names'] ?></td>
                            <td><?= ucwords(strtolower($value['audit_area']['title'])) ?></td>
                            <td>
                                <?php
                                if ($value['issue_rating'] == 'Low') {
                                    echo '<span class="label label-pill label-primary">';
                                } elseif ($value['issue_rating'] == 'Moderate') {
                                    echo '<span class="label label-pill label-warning">';
                                } elseif ($value['issue_rating'] == 'High') {
                                    echo '<span class="label label-pill label-danger">';
                                } else {
                                    echo '<span class="label label-pill label-danger">';
                                }
                                ?>
    <?= $value['issue_rating'] ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                if ($value['issue_status'] == 'Open') {
                                    echo '<span class="label label-pill label-danger">';
                                } elseif ($value['issue_status'] == 'Closed') {
                                    echo '<span class="label label-pill label-info">';
                                } else {
                                    
                                }
                                ?>
    <?= $value['issue_status'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url("index.php/Risk/selectRiskstoIssues/{$value['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-info-outline btn-sm waves-effect waves-light">
                                    <span class="btn-label"><i class="icon icon-list"></i>
                                    </span>Select</a></td>
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
                lengthChange: true,
                scrollX: false,
                buttons: ['copy', 'excel'],
            });

            table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        //tooltip 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>


