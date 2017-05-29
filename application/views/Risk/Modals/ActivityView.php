<?php
$activity = $data['activity'];
$control = $data['control'];
$risk = $data['risk'];
$me_id = $me['user']['id'];
if (!am_user_type(array(1, 5)) and $control['owner'] != $me_id and $risk['risk_owner'] != $me_id and $activity['owner']['id'] != $me_id) {
    restricted_view();
    return false;
}
?>

<?= form_open_multipart("Risk/saveSelectRisk") ?>
<div class="modal-dialog modal-lg ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Control Activity : <small><?= $activity['name'] ?></small></h4>
        </div>
        <div class="modal-body">
            <?php // print_pre($data);?>
            <?php if ($activity['review_status'] == 'pending' and am_user_type(array(1, 5))): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Approve Control Control Activity</h4> <br>
                    <a <?= MODAL_AJAX ?> href="<?= base_url("index.php/Risk/activityApprove/{$activity['id']}/approved") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                    <a <?= MODAL_AJAX ?> href="<?= base_url("index.php/Risk/activityApprove/{$activity['id']}/rejected") ?>" class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-5">
                    <table class="table table-sm table-small ">
                        <tbody>
                            <tr>
                                <th style="width: 40%">Ref Code</th>
                                <td><?= $activity['ref_code'] ?></td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td><?= ucwords($activity['name']) ?></td>
                            </tr>
                            <tr>
                                <th>Control</th>
                                <td><a href="<?= base_url("index.php/Risk/control/{$data['control']['id']}") ?>"><?= ucwords($data['control']['title']) ?></a></td>
                            </tr>
                            <tr>
                                <th>Risk</th>
                                <td><a href="<?= base_url("index.php/Risk/control/{$data['risk']['id']}") ?>"><?= ucwords($data['risk']['title']) ?></a></td>
                            </tr>

                            <tr>
                                <th>Action Due Date</th>
                                <td><?= strftime("%b %d %Y", strtotime($activity['action_due_date'])) ?></td>
                            </tr>
                            <tr>
                                <th>Completion Status</th>
                                <td><span class="label label-pill label-<?= $activity['status'] == 'complete' ? 'success' : "warning" ?>"><?= ucwords($activity['status']) ?></span></td>
                            </tr>
                            <tr>
                                <th>Review Status</th>
                                <td><span class="label label-pill label-<?= $activity['review_status'] == 'approved' ? 'success' : "warning" ?>"><?= ucwords($activity['review_status']) ?></span></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?= ucwords($activity['type']) ?></td>
                            </tr>
                            <tr>
                                <th>Action By</th>
                                <td><?= is_array($activity['action_by']) ? $activity['action_by']['names'] : $activity['action_by']; ?></td>
                            </tr>
                            <tr>
                                <th>Owner</th>
                                <td><?= ucwords($activity['owner']['names']) ?></td>
                            </tr>
                            <tr>
                                <th>Criticality</th>
                                <td><span class="label label-pill label-<?=
                                    $activity['criticality'] == 'high' ? 'danger' :
                                            $activity['criticality'] == 'medium' ? 'warning' : 'default'
                                    ?>"><?= ucwords($activity['criticality']) ?></span></td>
                            </tr>
                            <tr>
                                <th>Late Review</th>
                                <td><?= strftime("%b %d %Y", strtotime($activity['last_review'])) ?></td>
                            </tr>
                            <tr>
                                <th>Next Review</th>
                                <td><?= strftime("%b %d %Y", strtotime($activity['next_review'])) ?></td>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <td><?= ucwords($activity['frequency']) ?></td>
                            </tr>   
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-7">
                    <h4>Description</h4>
                    <?= $activity['description'] ?>
                </div>
            </div>
            <?= NULL // show_comments("risk", "control_activity", $activity['id']);    ?>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <?php if (am_user_type(array(1, 5)) or $control['owner'] == $me_id or $risk['risk_owner'] == $me_id or $activity['owner']['id'] == $me_id): ?>
                    <a href="<?= base_url("index.php/Risk/activityForm/{$activity['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-pencil"></i> Edit</a>
                <?php endif; ?>
                <?php if (am_user_type(array(1, 5))): ?>
                    <a href="<?= base_url("index.php/Risk/activityDelete/{$activity['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-trash"></i> Delete</a>
                <?php endif; ?>
                <?php if (am_user_type(array(1, 5)) or $control['owner'] == $me_id or $risk['risk_owner'] == $me_id or $activity['owner']['id'] == $me_id): ?>
                    <a href="<?= base_url("index.php/Risk/activityForm/{$activity['id']}") ?>" <?= MODAL_AJAX ?> class="btn hidden btn-secondary waves-effect waves-light"><i class="icon icon-check"></i> Mark as Complete</a>
                <?php endif; ?>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>