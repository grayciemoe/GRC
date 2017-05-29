<?php //print_pre($issueslist );                     ?>
<div class="card"> 
    <div id="table_issues" class="card-block table-responsive">
        <table class="table table-sm table-striped table-small " id="datatable-buttons1">
            <thead>
                <tr>
                    <th>No</th>
                    
                    <th>Issue Title</th>
                    <th>Audit Name</th>
                    <th>Audit Area</th>
                    <th>Issue Rating</th>
                    <th>Issue Owner</th>
                    <th>Action Plan Status</th>
                    <th>Issue Status</th>
                    <th>Implication Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 0;
                foreach ($issueslist as $key => $value) :
                    $num++;
                    $status_label = $value['issue_status'] == 'Open' ? "info" : $value['issue_status'] == 'Closed' ? "info" : "danger";
                    ?>
                    <tr>
                        <td><?= $num ?></td>
                        
                        <td><a href="<?= base_url('index.php/Audit/issue/' . $value['id'] . '') ?>"><?= ucwords($value['title']) ?></a></td>
                        <td><a href="<?= base_url('index.php/Audit/audit/' . $value['audit']['id'] . '') ?>"><?= ucwords($value['audit']['audit_name'])?></a></td>
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
                        <td><?= $value['issue_owner']['names'] ?></td>
                        <td><?= $value['action_plan_status'] ?></td>
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
                        <td><?= $value['implication_type'] ?></td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">

    $('#datatable').DataTable();
    //Buttons examples
//    var table = $('#datatable-issues').DataTable({
//        lengthChange: true,
//        buttons: ['copy', 'excel', 'pdf', 'colvis'],
//        "columnDefs": [
//            {"visible": false, "targets": [0, 4, 5, 6, 7, 8, 11, 13, 14]}
//        ]
//    });
    var table1 = $('#datatable-buttons1').DataTable({
        lengthChange: true,
        buttons: ['excel', 'pdf', 'colvis']
    });

    table1.buttons().container()
            .appendTo('#datatable-buttons1_wrapper .col-md-6:eq(0)');

    var doc = new jsPDF('landscape');
    $("#datatable-obligations").css('background', '#fff');
    $('#issue_table_report_export_btn').click(function () {
        $("#table_issues").removeClass('table-responsive');
        $("#table_issues").addClass('table');
        doc.addHTML($('#datatable-obligations')[0], function () {

            doc.save('Issue_report_table.pdf');

        });
        $("#table_issues").addClass('table-responsive');
    });

</script>
