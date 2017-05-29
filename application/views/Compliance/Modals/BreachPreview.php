<?php
$breaches = $data['breaches'];

//print_pre($data);
?>
<div class="modal-dialog  modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Breached Obligation</h4>
        </div>
        <div class="modal-body">

            <?php if ($data['breaches']['approved'] == 'pending'and am_user_type(array(5))): ?>
                <div class="alert alert-danger alert-dismissible" >
                    <div class="text-center">
                        <p>Approve this breach ?</p>
                        <a href="<?= base_url("index.php/Compliance/breachApprove/{$data['breaches'] ['id']}/approved"); ?>" <?= MODAL_AJAX ?> class="hide_onclick btn btn-success btn-rounded "><i class="icon icon-check"></i> Approve</a>
                        <a href="<?= base_url("index.php/Compliance/breachApprove/{$data['breaches'] ['id']}/rejected"); ?>" <?= MODAL_AJAX ?> class="hide_onclick btn btn-danger btn-rounded"><i class="icon icon-check"></i> Reject</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($data['breaches']['approved'] == 'approved'): ?>
                <div class="alert alert-danger alert-dismissible" >
                    <div class="text-center">
                        <p>Report Incident!</p>
                        <a href="<?= base_url("index.php/Compliance/breachToIncident/{$data['breaches']['id']}/"); ?>" class="btn btn-success btn-rounded "><i class="icon icon-energy"></i> Report Incident</a>
                    </div>
                </div>
            <?php endif; ?>
            <table class="table table-sm">
                <?php
                $approved_label = $data['breaches']['approved'] == "approved" ? "info" : (($data['breaches']['approved'] == "pending") ? "warning" : "danger");
                ?>
                <tbody>
                    <tr>
                        <th> Title</th>
                        <td><?= $data['breaches'] ['title'] ?> </th> 
                    </tr>
                    <tr>
                        <th> Period</th>
                        <td><?= $data['breaches'] ['period'] ?> <td> 
                    </tr>
                    <tr>
                        <th> Status</th>
                        <td><span class="label label-pill label-rounded label-default"><?= ucwords($data['breaches'] ['status']) ?></span>
                            <div class="pull-right">
                                <?php if (am_user_type(array(1, 5))): ?>
                                    <?php if ($data['breaches']['status'] == 'closed'): ?>

                                        <a class='btn btn-secondary btn-sm btn-small' <?= MODAL_AJAX ?> href="<?= base_url("index.php/Compliance/breachStatus/{$data['breaches']['id']}/open/") ?>"><i class='icon icon-'></i> Open</a>
                                    <?php else : ?>
                                        <a class='btn btn-secondary btn-sm btn-small' <?= MODAL_AJAX ?> href="<?= base_url("index.php/Compliance/breachStatus/{$data['breaches']['id']}/closed/") ?>"><i class='icon icon-'></i> Close</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <td> 
                    </tr>
                    <tr>
                        <th> Approval</th>
                        <td>
                            <span class="label label-pill label-<?= $approved_label ?>">
                                <?= ucwords($data['breaches']['approved']) ?>
                            </span>
                        <td> 
                    </tr>
                    <tr>
                        <th> Submission Deadline</th>
                        <td><?= strftime("%b %d %Y", strtotime($data['breaches']['submission_deadline'])) ?> <td> 
                    </tr>
                    <tr>
                        <th> Period</th>
                        <td><?= $data['breaches'] ['period_name'] ?>  </td>
                    </tr>
                    <tr>
                        <th> Description</th>
                        <td><?= $data['breaches'] ['description'] ?> <td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><!--end of card-->

