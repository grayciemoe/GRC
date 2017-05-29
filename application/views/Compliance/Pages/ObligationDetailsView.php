
<?php
$priority_label = $data['obligation']['priority'] == "Low" ? "info" : $data['obligation']['priority'] == "Medium" ? "warning" : "danger";

$status = $data['obligation']['last_submission_status'];
$last_submission_status = ($status == "complied" or $status == 'complied' or $status == "partially" or $status == "fully") ? "success" : "danger";
$condition_2 = ($data['obligation']['responsible_manager_1'] == $me['user']['id']
        or $data['obligation']['responsible_manager_2'] == $me['user']['id']
        or ucwords($data['obligation']['escalation_person']) == $me['user']['id']
        or am_user_type(array(1, 5)));

if (!$condition_2):
    restricted_view();
    return false;
endif;
?>
<?php // print_pre($data);                                                                                                                            ?>
<div class="container-fluid">
    <div class="row">
        <?php
        ?>
        <div class="col-sm-4 col-lg-3 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Time</h5>
                    <table class="table table-small table-sm">
                        <?php if ($data['obligation']['repeat'] == "periodic"): ?>
                            <tr>
                                <th>Frequency</th>
                                <td><?= ucwords($data['obligation']['frequency']) ?></td>
                            </tr>

                            <tr>
                                <th>First Compliance Period</th>
                                <td><?= strftime("%b %d %Y", strtotime($data['obligation']['fcp'])) ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Notification Date</th>
                            <td><?= strftime("%b %d %Y", strtotime($data['obligation']['notification_date'])) ?></td>
                        </tr>
                        <tr>
                            <th><?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Review Date" ?></th>
                            <td><?= strftime("%b %d %Y", strtotime($data['obligation']['submission_deadline'])) ?></td>
                        </tr>
                        <tr>
                            <th>Repeat</th>
                            <td><?= ucwords($data['obligation']['repeat']) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Compliance Requirements</h5>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th> Title</th>  <td><a href="<?= base_url("index.php/Compliance/complianceRequirement/{$data['compliance_requirement']['id']}") ?>"><?= $data['compliance_requirement']['title'] ?></a></td>
                            </tr>
                            <tr>
                                <th>Obligation Type</th>  <td><?= $data['compliance_requirement']['type'] ?></td>
                            </tr>

                            <tr>
                                <th> Source Repository</th>  <td><?= ucwords(str_replace("_", " ", $data['repository']['source'])) ?></td>
                            </tr>
                            <tr>
                                <th> Source Document</th>  <td><?= $data['repository']['name'] ?></td>
                            </tr>
                            <tr>
                                <th> Environment</th>  <td><?= $data['environment']['name'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Required Activity</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th colspan="2"><?= ucwords($data['obligation']['activity']) ?></th>
                            </tr>
                        </thead>
                        <?php if ($data['obligation']['activity'] === 'document submission'): ?>

                            <tr><th>Document Name </th>  <td> <?= $data['obligation']['document_name'] ?></td></tr>
                            <tr><th>Person Name </th>  <td> <?= $data['obligation']['person_name'] ?></td></tr>
                            <tr><th>Person Phone </th>  <td> <?= $data['obligation']['person_phone'] ?></td></tr>
                            <tr><th>Person Address </th>  <td> <?= $data['obligation']['person_address'] ?></td></tr>
                            <tr><th>Person Email </th>  <td> <?= $data['obligation']['person_email'] ?></td></tr>

                        <?php endif; ?>

                        <?php if ($data['obligation']['activity'] === 'web entry'): ?>

                            <tr><th>Website Url </th>  <td> <?= $data['obligation']['url'] ?></td></tr>
                        <?php endif; ?>

                        <?php if ($data['obligation']['activity'] === 'Audit Pass'): ?>

                            <tr><th> </th>  <td>Verification Method</td></tr>
                        <?php endif; ?>

                    </table>

                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Assignment Information</h5>
                    <hr class="row">
                    <?php
                    foreach ($data['assignment'] as $key => $person):
                        if (!$person) {
                            continue;
                        }
                        ?>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object  img-rounded" src="<?= img_src($person['profile_pic'], 70, 70) ?>" alt="...">
                                </a>
                            </div>

                            <div class="media-body">
                                <h4 class="media-heading"><small><?= $person['names'] ?></small></h4>
                                <p><?= ucwords(str_replace("_", " ", $key)) ?> <small><br><?= $person['name'] ?></small></p>
                            </div>
                        </div>
                        <hr class="m-0">
                    <?php endforeach; ?>
                </div>
                <div class="card-block">
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-8 col-xs-12">
            <?php
            $condition_1 = (strtotime($data['obligation']['notification_date']) <
                    (time() + (24 * 3600))) or ( strtotime($data['obligation']['submission_deadline']) <
                    (time() + (24 * 3600)));
            $condition_2 = ($data['obligation']['responsible_manager_1'] == $me['user']['id']
                    or $data['obligation']['responsible_manager_2'] == $me['user']['id']
                    or $data['obligation']['escalation_person'] == $me['user']['id']
                    or am_user_type(array(5)));
            $condition_3 = ($data['obligation']['approved'] == 'approved' and $data['obligation']['status'] == 'active');


            if ($condition_1 and $condition_2 and $condition_3 and strtotime($data['obligation']['submission_deadline']) > time()
                    and ( $data['obligation']['repeat'] != "one off")):

                $alert = strtotime($data['obligation']['notification_date']) < time() + (24 * 3600) ? "info" : NULL;
                //$alert = strtotime($data['obligation']['submission_deadline']) < time() + (24 * 3600) ? "danger" : $alert;
                $d_date = strftime("%b %d %Y", strtotime($data['obligation']['submission_deadline']));
                ?>

                <div class="alert alert-<?= $alert ?> alert-dismissable text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h3 class="font-w300 push-15">Obligation Review Reminder </h3>
                    <p>Have you complied to this obligation for <strong><?= $d_date ?></strong> ? <br>
                        <a href="<?= base_url("index.php/Compliance/breachForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_LINK ?> class="hidden btn btn-danger btn-sm"><i class="si si-close"></i> NO</a>
                        <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-success btn-sm"><i class="icon icon-check"></i> YES</a>
                    </p>
                </div>

            <?php endif; ?>  
            <?php
            if ($condition_1 and $condition_2 and $condition_3):

                $alert = strtotime($data['obligation']['notification_date']) < time() + (24 * 3600) ? "info" : NULL;
                //$alert = strtotime($data['obligation']['submission_deadline']) < time() + (24 * 3600) ? "danger" : $alert;
                $d_date = strftime("%b %d %Y", strtotime($data['obligation']['submission_deadline']));
                ?>

                <div class="alert alert-<?= $alert ?> alert-dismissable text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h3 class="font-w300 push-15">Obligation Review Reminder </h3>
                    <p>Have you complied to this obligation for <strong><?= $d_date ?></strong> ? <br>
                        <a href="<?= base_url("index.php/Compliance/breachForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_LINK ?> class="hidden btn btn-danger btn-sm"><i class="si si-close"></i> NO</a>
                        <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-success btn-sm"><i class="icon icon-check"></i> YES</a>
                    </p>
                </div>

            <?php endif; ?>  
            <?php
            if (strtotime($data['obligation']['notification_date']) < time()
                    and $data['obligation']['approved'] == 'approved'
                    and $data['obligation']['complied'] == 'no'
            ):
                ?>
                <?php if (false): ?>
                    <div class="alert alert-danger alert-dismissable text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h3 class="font-w300 push-15">Report Breach </h3>
                        <p>This obligation was not complied, do you want to report breach <br>

                            <a href="<?= base_url("index.php/Compliance/breachForm/{$data['obligation']['id']}") ?>" class="btn btn-danger btn-sm"><i class="si si-close"></i> Report Breach</a>
                            <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$data['obligation']['id']}/yes") ?>" <?= MODAL_LINK ?> class="btn btn-success btn-sm"><i class="si si-check"></i> Resolve</a>

                        </p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <?php
            $all_pending = [];

            $pending_breach = false;
            foreach ($data['breaches'] as $key => $value) {
                if ($value['approved'] == 'pending') {
                    $pending_breach = $value;
                    $all_pending[] = $value;
                }
            }

            if ($pending_breach and is_array($pending_breach) and am_user_type(array(5))) :
                if (count($all_pending) == 1):
                    ?>
                    <div class="alert alert-danger alert-dismissable text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h3 class="font-w300 push-15"><?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? " Breach " : " Late Review " ?> Approval Required </h3>
                        <p>
                            Breach "<strong><?= $pending_breach['title'] ?></strong>" requires your approval
                        <hr>
                        <a href="<?= base_url("index.php/Compliance/breach/{$pending_breach['id']}"); ?>" <?= MODAL_LINK ?> class="btn  btn-success btn-sm btn-small "><i class="icon icon-check"></i> Take Action</a>


                        </p>
                    </div>


                <?php else: ?>

                    <div class="alert alert-danger alert-dismissable text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h3 class="font-w300 push-15"><?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? " Breach " : " Late Review " ?> Approval Required </h3>
                        <p>
                            You Have ( <?= count($all_pending) ?> ) Breaches that requires your approval
                        <hr>
                        <a href="<?= base_url("index.php/Compliance/ObligationBulkActionApprove/{$data['obligation']['id']}"); ?>" <?= MODAL_LINK ?> class="btn  btn-success btn-sm btn-small ">
                            <i class="icon icon-check"></i> Take Action
                        </a>


                        </p>
                    </div>

                <?php endif; ?>


            <?php endif; ?>

            <?php
            $pending_comply = false;
            foreach ($data['complies'] as $key => $value) {
                if ($value['approved'] == 'pending') {
                    $pending_comply = $value;
                }
            }

            if ($pending_comply and is_array($pending_comply) and am_user_type(array(5))) :
                ?>
                <div class="alert alert-danger alert-dismissable text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h3 class="font-w300 push-15">Compliant Approval Required </h3>
                    <p>
                        Comply "<strong><?= $pending_comply['title'] ?></strong>" requires your approval
                    <hr>
                    <a href="<?= base_url("index.php/Compliance/compliant/{$pending_comply['id']}"); ?>" <?= MODAL_LINK ?> class="btn  btn-success btn-sm btn-small "><i class="icon icon-check"></i> Take Action</a>


                    </p>
                </div>
            <?php endif; ?>

            <?php if ($data['obligation']['approved'] == 'pending'): ?>
                <?php if (am_user_type(array(1, 5))): ?>
                    <div class="alert alert-warning alert-dismissable text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h3 class="font-w300 push-15">Approve Obligation </h3>
                        <p>Do you want to approve this obligation  <br>
                            <a href="<?= base_url("index.php/Compliance/obligationApprove/{$data['obligation']['id']}/rejected") ?>" class="btn btn-danger btn-sm"><i class="si si-close"></i> NO</a>
                            <a href="<?= base_url("index.php/Compliance/obligationApprove/{$data['obligation']['id']}/approved") ?>" class="btn btn-success btn-sm"><i class="si si-check"></i> YES</a>
                        </p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (am_user_type(array(1, 5))): ?>
                <?php if ($data['obligation']['status'] == 'inactive' and $data['obligation']['repeat'] != 'continuous'): ?>
                    <div class="alert alert-warning alert-dismissable text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h3 class="font-w300 push-15">Inactive Obligation </h3>
                        <p>This obligation is inactive, Do you want to activate it? <br>
                            <a href="<?= base_url("index.php/Compliance/obligationActivate/{$data['obligation']['id']}/active") ?>" class="btn btn-success btn-sm"><i class="si si-close"></i> Activate</a>
                        </p>
                    </div>

                <?php elseif ($data['obligation']['status'] == 'inactive' and $data['obligation']['repeat'] == 'continuous') : ?>
                    <div class="alert alert-warning alert-dismissable text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h3 class="font-w300 push-15">Inactive Obligation </h3>
                        <p>This obligation is inactive because the <?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Review Date" ?> has passed. Set a new <?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Review Date" ?> to activate.<br>

                            <a href="<?= base_url("index.php/Compliance/resetSubmissionDeadline/{$data['obligation']['id']}/active") ?>" <?= MODAL_LINK ?> class="btn btn-success btn-sm"><i class="icon icon-calendar"></i> Reset <?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Review Date" ?></a>
                        </p>
                    </div>


                <?php endif; ?>

            <?php endif; ?>
            <div class="card collapse-grc">
                <div class="card-block">
                    <div class="btn-group pull-right">
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a href="<?= base_url("index.php/Compliance/obligationForm/{$data['obligation']['id']}"); ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm"><i  class="icon icon-pencil"></i> Edit </a>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a href="<?= base_url("index.php/Compliance/obligationDelete/{$data['obligation']['id']}"); ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm"><i  class="icon icon-trash"></i> Delete</a>
                        <?php endif; ?>
                    </div>
                    <h4 class="card-title"><?= $data['obligation']['title'] ?></h4>
                    <hr>
                    <div class="row ">

                        <div class="col-lg-4 col-sm-12">
                            <table class="table table-small table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Basic Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Short Code</th>
                                        <td><?= $data['obligation']['short_code'] ?></td>
                                    </tr>

                                    <tr>
                                        <th>Authority</th>
                                        <td><?= $data['obligation']['authority']['title'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="label label-pill label-<?= $data['obligation']['status'] == 'active' ? "success" : "default" ?>">
                                                <?= ucwords($data['obligation']['status']) ?>
                                            </span>


                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Current Status</th>
                                        <td><span class="label label-pill label-<?= $last_submission_status ?>">
                                                <?= ucwords($data['obligation']['last_submission_status']) ?>
                                            </span></td>
                                    </tr>
                                    <tr>
                                        <th>Priority Level</th>
                                        <td><span class="label label-pill label-<?= $priority_label ?>">
                                                <?= ucwords($data['obligation']['priority']) ?>
                                            </span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                        <div class="col-lg-8 col-sm-12">

                            <table class="table table-small table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="2"  class="text-center">Non Compliance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Consequence </th>
                                        <td><?= $data['obligation']['noncompliance_consequence'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Penalty</th>
                                        <td><?= $data['obligation']['noncompliance_penalty'] ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-sm-12">
                            <hr class="m-0 p-0">
                            <h4 class="card-title">Description</h4>
                            <?= $data['obligation']['description'] ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($data['obligation_dependent']) > 0): ?>
                <div class="card">
                    <div class="card-block">
                        <?php if (am_user_type(array(1, 5, 10))): ?>
                            <a href="<?= base_url("index.php/Compliance/obligation_dependentForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-secondary pull-right btn-small btn-sm"><i class="icon icon-plus"></i> Add Compliance Dependent</a>
                        <?php endif; ?>
                        <h3 class="card-title">Compliance Dependents </h3>
                        <div class="table-responsive"> 
                            <table class="table table-small table-hover" id="complianceDependentsTable">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th class="hidden-sm hidden-xs">Description</th>
                                        <th class="hidden-sm hidden-xs">What is needed</th>
                                        <th>Activities</th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['obligation_dependent'] as $key => $value): ?>
                                        <tr>
                                            <td><?= ucwords($value['type']) ?></td>
                                            <td><?= $value['title'] ?></td>
                                            <td><?= $value['desciption'] ?></td>
                                            <td><?= $value['what_is_needed'] ?></td>
                                            <td><?= $value['activities'] ?></td>
                                            <td><i class="icon icon-user"></i> <?= $value['contact_name'] ?></td>
                                            <td><a href="mailto:<?= $value['contact_email'] ?>" title="<?= $value['contact_email'] ?>"><i class="icon icon-envelope"></i> <?= $value['contact_email'] ?></a></td>
                                            <td><?= $value['contact_phone'] ?></td>
                                            <td>
                                                <div class="btn-group pull-right">
                                                    <?php if (am_user_type(array(1, 5, 10))): ?>
                                                        <a <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/obligation_dependentForm/{$value['id']}"); ?>" class="btn btn-secondary btn-small btn-sm"><i class="icon icon-pencil"> </i></a>
                                                    <?php endif; ?>
                                                    <?php if (am_user_type(array(1, 5, 10))): ?>
                                                        <a <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/obligation_dependentDelete/{$value['id']}"); ?>" class="btn btn-secondary btn-small btn-sm"><i class="icon icon-trash"> </i></a>
                                                    <?php endif; ?>

                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            <?php else : ?>
                <div class="card">
                    <div class="card-block text-center">
                        <?php if (am_user_type(array(1, 5, 10))): ?>
                            <a href="<?= base_url("index.php/Compliance/obligation_dependentForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-secondary "><i class="icon icon-plus"></i> Add Compliance Dependent</a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endif; ?>
            <div class="card text-center">
                <div class="card-block">
                    <h3 class="card-title text-muted">Obligations Activity</h3>

                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title">Compliance </h4>
                            <table class="table table-sm table-small table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th class="text-center">Completion</th>
                                        <th class="hidden">Year</th>
                                        <th class="hidden">Period</th>
                                        <th class="text-center">Approval Status</th>
                                        <th class="text-center">Submission Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    $months = array(
                                        'none',
                                        'January',
                                        'February',
                                        'March',
                                        'April',
                                        'May',
                                        'June',
                                        'July ',
                                        'August',
                                        'September',
                                        'October',
                                        'November',
                                        'December',
                                    );
                                    foreach ($data['complies'] as $key => $value):
                                        $approved_label = $value['approved'] == "approved" ? "info" : (($value['approved'] == "pending") ? "warning" : "danger");
                                        $count++;
                                        $period = $value['period'];
                                        $period = $value['period_name'] == 'Month' ? $months[$value['period']] : $period;
                                        $period = $value['period_name'] == 'semi annually' ? "Half" . $value['period'] : $period;
                                        $period = $value['period_name'] == 'quarterly' ? "Quarterly" . $value['period'] : $period;
                                        ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><a href="<?= base_url("index.php/Compliance/compliant/{$value['id']}"); ?>" <?= MODAL_LINK ?>><?= $value['title'] ?></a></td>
                                            <td class="text-center"><?= ucwords($value['completion']) ?></td>
                                            <td class="hidden"><?= strftime("%Y", strtotime($value['submission_deadline'])) ?></td>
                                            <td class="hidden"><?= $period ?></td>
                                            <td class="">
                                                <span class="label label-pill label-<?= $approved_label ?>">
                                                <?= ucwords(str_replace("_", " ", $value['approved'])) ?></td>
                                            </span>
                                            <td class="text-center"><?= str_replace(strftime("%Y", time()), "", strftime("%b %d %Y", strtotime($value['submission_deadline']))) ?></td>
                                            <td class="hidden">
                                                <div class="btn-group pull-right">
                                                    <?php if (am_user_type(array(1, 5))): ?>
                                                        <a href="<?= base_url("index.php/Compliance/compliantForm/{$value['id']}"); ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-pencil"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (am_user_type(array(1, 5))): ?>
                                                        <a href="<?= base_url("index.php/Compliance/compliantForm/{$value['id']}"); ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-trash"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (am_user_type(array(1, 5))): ?>
                                                        <?php if ($value['approved'] != 'approved'): ?>
                                                            <a href="<?= base_url("index.php/Compliance/compliantApprove/{$value['id']}/approved"); ?>" <?= MODAL_LINK ?> class="btn btn-success btn-small btn-sm "><i class="icon icon-check"></i> Approve</a>
                                                            <a href="<?= base_url("index.php/Compliance/compliantApprove/{$value['id']}/rejected"); ?>" <?= MODAL_LINK ?> class="btn btn-danger  btn-small btn-sm "><i class="icon icon-close"></i> Reject</a>
                                                        <?php endif; ?>  
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="card-title">Breaches </h4>
                            <table class="table table-sm table-small table-striped">
                                <?php //print_pre($data['breaches']);         ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th class="hidden">Year</th>
                                        <th class="hidden">Period</th>
                                        <th>Approval Status</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Submission Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    $months = array(
                                        'none',
                                        'January',
                                        'February',
                                        'March',
                                        'April',
                                        'May',
                                        'June',
                                        'July ',
                                        'August',
                                        'September',
                                        'October',
                                        'November',
                                        'December',
                                    );
                                    $period = NULL;
                                    foreach ($data['breaches'] as $key => $value):
                                        $count++;
                                        $month = $value['period'] % 12;
                                        $period = (isset($value['period_name']) and ( $value['period_name'] == 'Month')) ? $months[$month] : $period;
                                        $period = $value['period_name'] == 'semi annually' ? "Half" . $value['period'] : $period;
                                        $period = $value['period_name'] == 'quarterly' ? "Quarterly" . $value['period'] : $period;
                                        $approved_label = $value['approved'] == "pending" ? "warning" : (($value['approved'] == "approved") ? "danger" : "info");
                                        $status_label = $value['status'] == "closed" ? "info" : $value['status'] == "open" ? "warning" : "danger";
                                        ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><a href="<?= base_url("index.php/Compliance/breach/{$value['id']}"); ?>" <?= MODAL_LINK ?>><?= $value['title'] ?></a></td>
                                            <td class="hidden"><?= strftime("%Y", strtotime($value['submission_deadline'])) ?></td>
                                            <td class="hidden"><?= $period ?></td>
                                            <td class="">
                                                <span class="label label-pill label-<?= $approved_label ?>">
                                                    <?= ucwords(str_replace("_", " ", $value['approved'])) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?= ucwords(str_replace("_", " ", $value['status'] ? $value['status'] : "open" )) ?>
                                            </td>
                                            <td class="text-center"><?= str_replace(strftime("%Y", time()), "", strftime("%b %d %Y", strtotime($value['submission_deadline']))) ?></td>
                                            <td>
                                                <div class="btn-group pull-right hidden">
                                                    <?php if (am_user_type(array(1, 5)) and $value['approved'] == 'approved'): ?>
                                                        <a href="<?= base_url("index.php/Compliance/breachToIncident/{$value['id']}") ?>" class="btn btn-danger btn-sm btn-small"><i class='icon icon-energy'></i> Report Incident</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
    </div>

</div>
