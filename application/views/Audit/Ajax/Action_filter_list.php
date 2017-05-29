<?php //print_pre($actionlist );                     
?>
<div class="card"> 
    <div id="table_action" class="card-block table-responsive">
        <table class="table table-sm table-striped table-small " id="datatable-buttons1">
            <thead>
                <tr>
                    <th>No</th>

                    <th>Action Plan</th>
                    <th>Issue</th>
                    <th>Action by Date</th>
                    <th>Action Plan Owner</th>
                    <th>Assigned To</th>
                    <th>Review Date</th>
                    <th>Verification Status</th>
                    <th>Implementation Status</th>
                    <th>Approval Status</th>
                    <th>Active Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 0;
                foreach ($actionlist as $key => $value) :
                    $num++;
                    //$status_label = $value['issue_status'] == 'Open' ? "info" : $value['issue_status'] == 'Closed' ? "info" : "danger";
                    ?>
                    <tr>
                        <td><?= $num ?></td>

                        <td><a href="<?= base_url('index.php/Audit/action_plan/' . $value['id'] . '') ?>" <?= MODAL_LINK ?>><?= ucwords($value['action_plan']) ?> </a></td>
                        <td><a href="<?= base_url('index.php/Audit/issue/'.$value['issue']['id'])?>"><?= ucwords($value['issue']['title'])?></a></td>
                        <td class="<?= ((strtotime($value['action_by_date']) < strtotime(date('Y-m-d'))) && ($value['verification_status'] == 'Unverified')) ? "text-danger" : "text-success" ?>"><?= strftime("%b-%d-%Y", strtotime($value['action_by_date'])) ?></td>
                        <td><?= $value['action_plan_owner']['names'] ?></td>
                        <td><?= $value['assigned_to'] ?></td>
                        <td class="<?= ((strtotime($value['review_date']) < strtotime(date('Y-m-d'))) && ($value['verification_status'] == 'Unverified')) ? "text-danger" : "text-success" ?>"><?= strftime("%b-%d-%Y", strtotime($value['review_date'])) ?></td>
                        <td>
                            <span class="label label-pill label-<?php
                                  if ($value['approval_status'] == 'Yes') {
                                      echo 'success';
                                  } elseif ($value['approval_status'] == 'No') {
                                      echo 'danger';
                                  } else {
                                      echo 'warning';
                                  }
                                  ?>">
                                      <?php
                                      if ($value['approval_status'] == 'Yes') {
                                          echo 'Approved';
                                      } elseif ($value['approval_status'] == 'No') {
                                          echo 'Rejected';
                                      } else {
                                          echo $value['approval_status'];
                                      }
                                      ?>
                            </span>
                        </td>
                        <td><?php
                            if (empty($value['implementation_status'])) {
                                echo 'N/A';
                            } else {
                                echo $value['implementation_status'];
                            }
                            ?></td>
                        <td><?php
                            if (empty($value['verification_status'])) {
                                echo 'N/A';
                            } else {
                                echo $value['verification_status'];
                            }
                            ?></td>                                         
                        <td><?php
                            if (empty($value['active_status'])) {
                                echo 'N/A';
                            } else {
                                echo $value['active_status'];
                            }
                            ?></td>


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
        $("#table_action").addClass('table-responsive');
    });

</script>
