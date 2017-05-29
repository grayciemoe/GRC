<?php
$action_plan = $data['action_plan'];
if ($data['audit']['published_board'] == 1) {
    $disabled = "disabled";
} else {
    $disabled = "";
}
if ((!am_user_type(array(1, 2, 6, 8))) && ($data['issue']['published_board'] == 0)) {
    restricted_view();
    return false;
}
?>
<div class='modal-dialog modal-lg'>

    <div class='modal-content'>
        <div class='modal-header'>
            <a class='close' href="<?= base_url('index.php/Audit/issue/' . $data['issue']['id'] . '') ?>" aria-hidden='true'>×</a>

        </div>
        <?php if ((strtotime($action_plan['action_by_date']) < strtotime(date('Y-m-d'))) && ($action_plan['verification_status'] == 'Unverified')): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>This Management Action Plan Is <b>Overdue</b></h4> <br>
            </div>
        <?php endif; ?> 
        <?php if (am_user_type(array(8))): ?>
            <?php if ($action_plan['approval_status'] == 'Pending'): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Approve Management Action Plan</h4> <br>
                    <a href="<?= base_url("index.php/Audit/actionPlanApprove/{$action_plan['id']}/Yes") ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                    <a href="<?= base_url("index.php/Audit/actionPlanApprove/{$action_plan['id']}/No") ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
                </div>
            <?php endif; ?> 
        <?php else: ?>
            <?php if ($action_plan['approval_status'] == 'Pending'): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Management Action Plan is pending Approval from the Auditor</h4> <br>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($action_plan['approval_status'] == 'No'): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Management Action Plan has Been Rejected would you like to <b>DELETE</b> it?</h4> <br>
                <a href="<?= base_url("index.php/Audit/deleteactionPlan/{$action_plan['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Delete</a>
            </div>
        <?php endif; ?> 

        <?php if ((am_user_type(array(8))) || ($data['action_plan_owner']['id'] == $data['me'])): ?>
            <?php if (($action_plan['implementation_status'] == 'Outstanding') && ($action_plan['approval_status'] == 'Yes')): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Has this Management Action Plan been Implemented?</h4> <br>
                    <a href="<?= base_url("index.php/Audit/actionPlanImplementVerify/{$action_plan['id']}/Implemented") ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Implemented</a>
                    <a href="<?= base_url("index.php/Audit/supersedeReason/" . $action_plan['id']) ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Superseded</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (am_user_type(array(8))): ?>
            <?php if ((($action_plan['implementation_status'] == 'Implemented') || ($action_plan['implementation_status'] == 'Superseded') ) && ($action_plan['verification_status'] == 'Unverified') && ($action_plan['approval_status'] == 'Yes')): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Verify that this Management Action Plan has been <?= ucwords($action_plan['implementation_status']) ?></h4> <br>
                    <a href="<?= base_url("index.php/Audit/actionPlanImplementVerify/{$action_plan['id']}/Verified") ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                    <a href="<?= base_url("index.php/Audit/actionPlanImplementVerify/{$action_plan['id']}/VerifyReject") ?>" <?= MODAL_AJAX ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
                </div>
            <?php endif; ?> 
        <?php endif; ?>
        <div class='modal-body'>
            <div class="card">
                <div class="card-block">
                    <?php if (am_user_type(array(8))): ?>
                        <div class="btn-group pull-right">
                            <?php
                            if ($action_plan['approval_status'] == 'Yes') {
                                $disable = "disabled";
                            } else {
                                $disable = "";
                            }
                            ?>

                            <a href="<?= base_url('index.php/audit/actionplanForm/' . $action_plan['id'] . '/' . $action_plan['issue']) ?>" <?= MODAL_AJAX ?>  class="btn btn-primary-outline btn-sm <?= $disabled ?> <?= $disable ?>"><i  class="icon icon-pencil"></i> Edit </a>


                            <a href="<?= base_url('index.php/audit/deleteactionPlan/' . $action_plan['id'] . '') ?>" <?= MODAL_AJAX ?>  class="btn btn-danger-outline btn-sm <?= $disabled ?> <?= $disable ?>"><i  class="icon icon-trash"></i> Delete</a>

                        </div>
                    <?php endif; ?>
                    <h5 class="card-title">Management Action Plan Details</h5>
                    <hr />
                    <table class="table table-small table-sm m-t-10">

                        <tr>
                            <th>Action Plan</th>
                            <td><?= $action_plan['action_plan'] ?></td>
                        </tr>
                        <tr>
                            <th>Action by Date</th>
                            <td class="<?= ((strtotime($action_plan['action_by_date']) < strtotime(date('Y-m-d'))) && ($action_plan['verification_status'] == 'Unverified')) ? "text-danger" : "text-success" ?>"><?= strftime("%Y-%m-%d", strtotime($action_plan['action_by_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Action Plan Owner</th>
                            <td><?= $data['action_plan_owner']['names'] ?></td>
                        </tr>
                        <tr>
                            <th>Assigned To</th>
                            <td><?= $action_plan['assigned_to'] ?></td>
                        </tr>
                        <tr>
                            <th>Review Date</th>
                            <td class="<?= ((strtotime($action_plan['review_date']) < strtotime(date('Y-m-d'))) && ($action_plan['verification_status'] == 'Unverified')) ? "text-danger" : "text-success" ?>"><?= strftime("%Y-%m-%d", strtotime($action_plan['review_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Verification Status</th>
                            <td><?php
                                if (empty($action_plan['verification_status'])) {
                                    echo "N/A";
                                } else {
                                    echo $action_plan['verification_status'];
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Implementation Status</th>
                            <td><?php
                                if (empty($action_plan['implementation_status'])) {
                                    echo "N/A";
                                } else {
                                    echo $action_plan['implementation_status'];
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Approval Status</th>
                            <td><?php
                                if ($action_plan['approval_status'] == 'Yes') {
                                    echo 'Approved';
                                } elseif ($action_plan['approval_status'] == 'No') {
                                    echo 'Rejected';
                                } else {
                                    echo $action_plan['approval_status'];
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Status of Action plan</th>
                            <td><?php
                                if (empty($action_plan['active_status'])) {
                                    echo "N/A";
                                } else {
                                    echo $action_plan['active_status'];
                                }
                                ?></td>
                        </tr>
                        <?php if (!empty($action_plan['superseded_reasons'])): ?>
                            <tr>
                                <th>Superseded Reasons</th>
                                <td><?= $action_plan['superseded_reasons'] ?></td>
                            </tr>
                        <?php endif; ?>
                            <tr>
                                <th>Attachments</th>
                                <th><?= show_documents("audit", "management_action_plan", $action_plan['id']); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

