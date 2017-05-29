<?php
$action_plan = $data['action_plan'];
?>
<div class="container-fluid">
    <?php if ((strtotime($action_plan['action_by_date']) < strtotime(date('Y-m-d'))) && ($action_plan['verification_status'] == 'Unverified')): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>This Management Action Plan Is <b>Overdue</b></h4> <br>
               </div>
    <?php endif; ?> 
    <?php if ($action_plan['approval_status'] == 'Pending'): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Approve Management Action Plan</h4> <br>
                <a href="<?= base_url("index.php/Audit/actionPlanApprove/{$action_plan['id']}/Yes") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                <a href="<?= base_url("index.php/Audit/actionPlanApprove/{$action_plan['id']}/No") ?>" class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
            </div>
    <?php endif; ?> 
    <?php if ($action_plan['approval_status'] == 'No'): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Management Action Plan has Been Rejected would you like to <b>DELETE</b> it?</h4> <br>
                <a href="<?= base_url("index.php/Audit/deleteactionPlan/{$action_plan['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Delete</a>
            </div>
    <?php endif; ?> 
    <?php if (($action_plan['implementation_status'] == 'Outstanding') && ($action_plan['approval_status'] == 'Yes')): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Has this Management Action Plan been Implemented?</h4> <br>
                <a href="<?= base_url("index.php/Audit/actionPlanImplementVerify/{$action_plan['id']}/Complete") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Implemented</a>
             </div>
    <?php endif; ?> 
    <?php if (($action_plan['implementation_status'] == 'Complete') && ($action_plan['verification_status'] == 'Unverified')): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Has this Management Action Plan been Verified?</h4> <br>
                <a href="<?= base_url("index.php/Audit/actionPlanImplementVerify/{$action_plan['id']}/Implemented") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
            </div>
    <?php endif; ?> 
    
    
    <div class="row">
        <div class="col-sm-6 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <div class="btn-group pull-right">

                        <a href="<?= base_url('index.php/audit/actionplanForm/' . $action_plan['id'] . '/' . $action_plan['issue']) ?>" <?= MODAL_LINK ?>  class="btn btn-primary-outline btn-sm"><i  class="icon icon-pencil"></i> Edit </a>


                        <a href="<?= base_url('index.php/audit/deleteactionPlan/' . $action_plan['id'] . '') ?>" <?= MODAL_LINK ?>  class="btn btn-danger-outline btn-sm"><i  class="icon icon-trash"></i> Delete</a>

                    </div>
                    <h5 class="card-title">Management Action Plan Details</h5>
                    <hr />
                    <table class="table table-small table-sm m-t-10">

                        <tr>
                            <th>Action Plan</th>
                            <td><?= $action_plan['action_plan'] ?></td>
                        </tr>
                        <tr>
                            <th>Action by Date</th>
                            <td class="<?= ((strtotime($action_plan['action_by_date']) < strtotime(date('Y-m-d'))) && ($action_plan['verification_status'] == 'Unverified')) ? "text-danger" : "text-success"?>"><?= strftime("%Y-%m-%d", strtotime($action_plan['action_by_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Action Plan Owner</th>
                            <td><?= $action_plan['action_plan_owner'] ?></td>
                        </tr>
                        <tr>
                            <th>Assigned To</th>
                            <td><?= $action_plan['assigned_to'] ?></td>
                        </tr>
                        <tr>
                            <th>Review Date</th>
                            <td class="<?= ((strtotime($action_plan['review_date']) < strtotime(date('Y-m-d'))) && ($action_plan['verification_status'] == 'Unverified')) ? "text-danger" : "text-success"?>"><?= strftime("%Y-%m-%d", strtotime($action_plan['review_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Verification Status</th>
                            <td><?= $action_plan['verification_status'] ?></td>
                        </tr>
                        <tr>
                            <th>Implementation Status</th>
                            <td><?= $action_plan['implementation_status'] ?></td>
                        </tr>
                        <tr>
                            <th>Approval Status</th>
                            <td><?= $action_plan['approval_status'] ?></td>
                        </tr>
                        <tr>
                            <th>Active Status</th>
                            <td><?= $action_plan['active_status'] ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xs-12">
            <div class="card">

                
                
            </div>
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