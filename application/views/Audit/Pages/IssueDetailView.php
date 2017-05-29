<?php
//print_pre($data); exit;
$issue = $data['issue'];
$audit = $data['audit'];
$action_plans = $data['action_plans'];
$audit_comment = $data['audit_comment'];
$auditor_comment = $data['auditor_comment'];
if ($audit['published_board'] == 1) {
    $disabled = "disabled";
} else {
    $disabled = "";
}
    if ($issue['issue_status'] == "Open") {
        $disable_comment = "";
    } else {
        $disable_comment = "disabled";
    }
$issue_ownerId = $data['issue_owner']['id'];
//print_pre($me['user']['id']); 
//print_pre($issue_ownerId);
//exit;
?>
<?php
if ((!am_user_type(array(1, 8))) && ($issue['published_management'] == 0)) {
    restricted_view();
    return false;
} elseif ((!am_user_type(array(1, 8))) && ($issue['published_management'] == 1) && ($issue['published_ceo'] == 0) && ($me['user']['id'] != $issue_ownerId)) {
    restricted_view();
    return false;
} elseif ((!am_user_type(array(1, 8, 2))) && ($issue['published_ceo'] == 1) && ($issue['published_board'] == 0) && ($me['user']['id'] != $issue_ownerId)) {
    restricted_view();
    return false;
} elseif ((!am_user_type(array(1, 2, 4, 8))) && ($issue['published_board'] == 1) && ($me['user']['id'] != $issue_ownerId)) {
    restricted_view();
    return false;
}
?>
<div class="container-fluid">
    <?php if (!empty($data['issue_response_by_date'])): ?>
        <?php if ((strtotime($data['issue_response_by_date']['respond_by_date']) < strtotime(date('Y-m-d'))) && ($issue['issue_status'] == 'Open') && (empty($audit_comment))): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>This Issue Is <b>Overdue</b> and has not been responded to by Management</h4> <br>
            </div>
        <?php endif; ?> 
    <?php endif; ?>
    <?php if (!empty($data['ceo_issue_response_by_date'])): ?>
        <?php if ((strtotime($data['ceo_issue_response_by_date']['respond_by_date']) < strtotime(date('Y-m-d'))) && ($issue['issue_status'] == 'Open') && (empty($audit_comment))): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>This Issue Is <b>Overdue</b> and has not been responded to by CEO</h4> <br>
            </div>
        <?php endif; ?> 
    <?php endif; ?>
    <?php if (($issue['issue_status'] == 'Closed') && ($audit['published_board'] == 0)): ?>
        <div class="alert text-center alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>This Issue Is <b>Closed</b></h4> <br>
        </div>
    <?php endif; ?>
    <?php if (am_user_type(array(8))): ?>
        <?php if (($issue['issue_status'] == 'Open') && ($audit['published_board'] == 1)): ?>
            <div class="alert text-center alert-warning fade in" role="alert">

                <h4>This Issue Is <b><?= $issue['issue_status'] ?></b></h4>
                <h6>Would you like to Close this Issue</h6>
                <a href="<?= base_url('index.php/audit/issueToggleOpenClose/' . $issue['id'] . '/' . 'Closed') ?>" class="btn btn-info-outline btn-rounded waves-effect">Close</a>

            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ((empty($audit_comment)) && ($issue['published_management'] == 1) && (($issue['issue_status'] == 'Open'))): ?>
        <div class="alert text-center alert-warning fade in" role="alert">
            <h4>This issue requires a Management comment</h4>
            <a href="<?= base_url('index.php/AuditComment/auditComment/' . $issue['id'] . '/manager') ?>" <?= MODAL_LINK ?> class="btn btn-custom btn-sm">Add Management comment</a>
        </div>

    <?php endif; ?>
    <?php if ((!empty($audit_comment)) && ($issue['published_management'] == 1) && (empty($data['action_plans'])) && ($issue['action_plan_required'] == 'yes') && (($issue['issue_status'] == 'Open'))): ?>
        <div class="alert text-center alert-warning fade in" role="alert">
            <h4>This issue requires a Management action plan</h4>
            <a href="<?= base_url("index.php/Audit/actionplanForm/0/{$issue['id']}") ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm "><i  class="icon icon-plus"></i> Add Management Action Plan </a>  
        </div>

    <?php endif; ?>
    <?php
    if (($issue['published_management'] == 1) && (!empty($audit_comment)) && (empty($data['action_plans'])) && ($issue['action_plan_required'] == 'yes')) {
        $disable = "disabled";
    } else {
        $disable = "";
    }
    ?>
    
    <div class="row">
        <div class="col-sm-6 col-lg-4 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <?php if (am_user_type(array(8))): ?>
                        <div class="btn-group pull-right m-b-2">
                            <!--<a href="<?= base_url('index.php/audit/publish/' . $issue['id'] . '/board') ?>"  class="btn btn-danger-outline btn-sm <?= (($issue['published_management'] == 0) && (strtotime($issue['action_date']) < strtotime(date('Y-m-d')))) ? "" : "hidden" ?>"><i  class="fa fa-exclamation-circle"></i> Escalate To CEO </a>-->
                            <a href="<?= base_url('index.php/audit/publish/' . $issue['id'] . '/management') ?>" <?= MODAL_LINK ?>  class="btn btn-info-outline btn-sm <?= $disabled ?> <?= (($issue['published_management'] == 0) && ($issue['recommendation'] != NULL)) ? "" : "hidden" ?>"><i  class="icon icon-paper-plane"></i> Publish To Management </a>
                            <a href="<?= base_url('index.php/audit/publish/' . $issue['id'] . '/ceo') ?>" <?= MODAL_LINK ?> class="btn btn-info-outline btn-sm <?= $disabled ?> <?= $disable ?> <?= (($issue['published_management'] == 1) && (!empty($audit_comment)) && ($issue['published_ceo'] == 0)) ? "" : "hidden" ?>"><i  class="icon icon-paper-plane"></i> Publish To CEO </a>

                        </div>

                        <div class="clearfix"></div>
                        <div class="btn-group pull-right">



                            <a href="<?= base_url('index.php/audit/issueForm/' . $issue['id'] . '/' . $audit['id'] . '') ?>"  class="btn btn-secondary btn-sm <?= $disabled ?> <?= $disable ?>  " ><i  class="icon icon-pencil"></i> Edit </a>

                            <a href="<?= base_url('index.php/audit/deleteIssue/' . $issue['id'] . '') ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm <?= $disabled ?> <?= $disable ?>" ><i  class="icon icon-trash"></i> Delete</a>
                            <a href="<?= base_url('index.php/audit/issueForm/0/' . $audit['id'] . '') ?>"  class="btn btn-secondary btn-sm <?= $disabled ?> <?= $disable ?>  " ><i  class="icon icon-plus"></i> Add New Issue </a>
                        </div>
                    <?php endif; ?>

                    <h5 class="card-title"> Basic Details</h5>
                    <div class="row" id="issue_details">

                        <table class="table table-small table-sm">

                            <tr>
                                <th>Issue Title</th>
                                <td><?= ucwords($issue['title']) ?></td>
                            </tr>
                            <tr>
                                <th>Issue Owner</th>
                                <td><?= ucwords($data['issue_owner']['names']) ?></td>
                            </tr>
                            <tr>
                                <th>Audit Area</th>
                                <td><?= ucwords(strtolower($data['audit_area']['title'])) ?></td>
                            </tr>
                            <tr>
                                <th>Issue Subheading</th>
                                <td><?= $issue['issue_subheading'] ?></td>
                            </tr>
<!--                            <tr>
                                <th>Risk Category</th>
                                <td><?php // $data['risk_category']['title']                         ?></td>
                            </tr>
                            -->
                            <tr>
                                <th>Issue Rating</th>
                                <td><?= $issue['issue_rating'] ?></td>
                            </tr>
                            <tr>
                                <th>Issue Status</th>
                                <td><?= $issue['issue_status'] ?></td>
                            </tr>
                            <tr>
                                <th>Implication type</th>
                                <td><?= $issue['implication_type'] ?></td>
                            </tr>
                            <tr>
                                <th>Published To Management</th>
                                <td><?= $issue['published_management'] == 0 ? "<i class=\"fa fa-times-circle-o\" style =\" color: #D9534F\" ></i>" : "<i class=\"fa fa-check-square-o\" style =\" color: #5CB85C\"></i>" ?></td>
                            </tr>
                            <tr>
                                <th>Published To CEO</th>
                                <td><?= $issue['published_ceo'] == 0 ? "<i class=\"fa fa-times-circle-o\" style =\" color: #D9534F\"></i>" : "<i class=\"fa fa-check-square-o\" style =\" color: #5CB85C\"></i>" ?></td>
                            </tr>
                            <tr>
                                <th>Published To Board</th>
                                <td><?= $issue['published_board'] == 0 ? "<i class=\"fa fa-times-circle-o\" style =\" color: #D9534F\"></i>" : "<i class=\"fa fa-check-square-o\" style =\" color: #5CB85C\"></i>" ?></td>
                            </tr>
                            <?php if (!empty($data['riskIssues'])): ?>
                                <tr>
                                    <th>Risk Associated</th>
                                    <td>
                                        <ul class="list-unstyled">
                                            <?php foreach ($data['riskIssues'] as $key => $value): ?>
                                                <li><a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title'] ?> </a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
            <?php if (!empty($data['issue_response_by_date'])): ?>
                <div class="card">
                    <div class="card-block">
                        <div class="btn-group pull-right">
                            <button class="btn btn-sm btn-secondary hidden timeline_details_toggle" ><i class="icon icon-arrow-up" ></i> Less </button>
                            <button class="btn btn-sm btn-secondary  timeline_details_toggle"><i class="icon icon-arrow-down"></i> More </button>

                        </div>
                        <h5 class="card-title"> Action Timelines</h5>
                        <div class="row" id="timeline_details">
                            <table class="table table-small table-sm">
                                <tbody>
                                    <tr>
                                        <th>Management Respond By date</th>
                                        <td class="<?= (strtotime($data['issue_response_by_date']['respond_by_date']) < strtotime(date('Y-m-d'))) ? "text-danger" : "text-success" ?>"><?= strftime("%b-%d-%Y", strtotime($data['issue_response_by_date']['respond_by_date'])) ?></td>
                                    </tr>
                                    <?php if (!empty($data['ceo_issue_response_by_date'])): ?>
                                        <tr>
                                            <th>CEO Respond By date</th>
                                            <td class="<?= (strtotime($data['ceo_issue_response_by_date']['respond_by_date']) < strtotime(date('Y-m-d'))) ? "text-danger" : "text-success" ?>"><?= strftime("%b-%d-%Y", strtotime($data['ceo_issue_response_by_date']['respond_by_date'])) ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <div class="card">
                <div class="card-block">
                    <div class="btn-group pull-right">
                        <button class="btn btn-sm btn-secondary hidden audit_details_toggle" ><i class="icon icon-arrow-up"></i> Less </button>
                        <button class="btn btn-sm btn-secondary  audit_details_toggle"><i class="icon icon-arrow-down"></i> More </button>

                    </div>

                    <h5 class="card-title">Audit Details</h5>

                    <div class="row" id="audit_details">


                        <table class="table table-small table-sm">

                            <tr>
                                <th>Audit Name</th>
                                <td><a href="<?= base_url('index.php/Audit/audit/' . $audit['id']) ?>"><?= ucwords($audit['audit_name']) ?></a></td>
                            </tr>

                            <tr>
                                <th>Audit Ref</th>
                                <td><small><?= $audit['ref_code'] ?></small></td>
                            </tr>

                            <tr>
                                <th>Audit Type</th>
                                <td><?= $audit['audit_type'] ?></td>
                            </tr>
                            <tr>
                                <th>Audit Date</th>
                                <td><?= strftime("%b-%d-%Y", strtotime($audit['audit_date'])) ?></td>
                            </tr>
                            <tr>
                                <th>Business Units</th>
                                <td>
                                    <?php foreach ($data['environment'] as $key => $value): ?>
                                        <a href="<?= base_url("index.php/Home/Dashboard/{$value['id']}") ?>"><?= $value['name'] ?></a><br/>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Auditor</th>
                                <td><?= $data['auditor']['names'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-8 col-lg-8 col-xs-12">

            <div class="row">
                <div class="card card-block">
                    <h5 class="card-title">Observation</h5>
                    <div id="scroll-area" style="overflow-y:scroll; height: 180px;">

                        <?= $issue['observation'] ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card card-block">
                    <h5 class="card-title">Implication</h5>
                    <div id="scroll-area" style="overflow-y:scroll; height: 180px;">
                        <?= $issue['implication'] ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card card-block">
                    <h5 class="card-title">Recommendation</h5>
                    <div id="scroll-area" style="overflow-y:scroll; height: 180px;">
                        <?= $issue['recommendation'] ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Attachments</h5>
                    <?php if($data['me']['user']['user_type'] == 6):?>
                                <?= show_documents('audit', 'issue', $issue['id'], FALSE, FALSE, array("read" => 1, "preview" => 1, "edit" => 0, "delete" => 0)) ?>
                                <?php else: ?>
                                <?= show_documents('audit', 'issue', $issue['id'], FALSE, FALSE, array("read" => 1, "preview" => 1, "edit" => 0, "delete" => 1)) ?>
                                <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($issue['published_management'] == 1): ?>
        <div class="row">
            <div class="col-sm-12">
                <?php if (empty($audit_comment)): ?>
                    <div class="timeline">
                        <article class="timeline-item alt">
                            <div class="text-xs-center">
                                <div class="time-show first" style="margin-right: 0px;">

                                    <a href="<?= base_url('index.php/AuditComment/auditComment/' . $issue['id'] . '/manager') ?>" <?= MODAL_LINK ?> class="btn btn-custom w-lg <?= $disable_comment ?> <?= $disabled ?>">Add Management Comment</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php
                else :
                    foreach ($audit_comment as $key => $value) :
                        if ($value['user_type'] != 8):
                            ?>
                            <div class="timeline">
                                <article class="timeline-item alt">
                                    <div class="text-xs-right">
                                        <div class="time-show first">
                                            <a class="btn btn-primary w-lg waves-effect waves-light">Management comment</a>
                                        </div>
                                    </div>
                                </article>
                                <article class="timeline-item alt">
                                    <div class="timeline-desk">
                                        <div class="panel">
                                            <div class="timeline-box">
                                                <span class="arrow-alt"></span>
                                                <span class="timeline-icon bg-danger"><i class="zmdi zmdi-circle"></i></span>
                                                <div class="btn-group pull-left">
                                                    <?php
                                                    if ($issue['issue_status'] == "Open") {
                                                        $disable3 = "";
                                                    } else {
                                                        $disable3 = "disabled";
                                                    }
                                                    if (empty($auditor_comment)) {
                                                        $disable2 = "";
                                                    } else {
                                                        $disable2 = "disabled";
                                                    }
                                                    if ($data['me']['user']['user_type'] == 6) {
                                                        $disable4 = "disabled";
                                                    } else {
                                                        $disable4 = "";
                                                    }
                                                    if (($data['me']['user']['user_type'] == 8) && (empty($data['action_plans']))) {
                                                        $disable5 = "disabled";
                                                    } else {
                                                        $disable5 = "";
                                                    }
                                                    if ((empty($data['action_plans'])) && ($issue['action_plan_required'] == 'yes')) {
                                                        $disable6 = "disabled";
                                                    } else {
                                                        $disable6 = "";
                                                    }
                                                    ?>
                                                    <a href="<?= base_url('index.php/AuditComment/editAuditComment/' . $value['id'] . '/manager') ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm <?= $disabled ?> <?= $disable5 ?>" ><i  class="icon icon-pencil"></i> Edit </a>
                                                    <a href="<?= base_url('index.php/AuditComment/deleteAuditComment/' . $value['id']) ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm <?= $disabled ?> <?= $disable5 ?> <?= $disable4 ?> <?= $disable3 ?><?= $disable2 ?>" ><i  class="icon icon-trash"></i> Delete</a>

                                                </div>
                                                <h4 class="text-primary"><?= $value['user']['names'] ?></h4>
                                                <p class="timeline-date text-muted"><small><?= $value['time'] ?></small></p>
                                                <p><?= $value['comment'] ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                                <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                    <?php if (!empty($audit_comment)): ?>
                        <?php if (empty($auditor_comment)): ?>
                            <?php if (am_user_type(array(8))): ?>
                                <article class="timeline-item alt">
                                    <div class="text-xs-right">
                                        <div class="time-show first">
                                            <a href="<?= base_url('index.php/AuditComment/auditComment/' . $issue['id'] . '/auditor/8') ?>" <?= MODAL_LINK ?> class="btn btn-custom w-lg <?= $disable6 ?> <?= $disabled ?> <?= $disable_comment ?>">Add Auditor's comment</a>
                                        </div>
                                    </div>
                                </article>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <article class="timeline-item alt">
                            <div class="text-xs-right">
                                <div class="time-show first">
                                    <a class="btn btn-primary w-lg waves-effect waves-light">Auditor's comment</a>
                                </div>
                            </div>
                        </article>
                        <article class="timeline-item ">
                            <div class="timeline-desk">
                                <div class="panel">
                                    <div class="timeline-box">
                                        <span class="arrow"></span>
                                        <span class="timeline-icon bg-success"><i class="zmdi zmdi-circle"></i></span>
                                        <?php if (am_user_type(array(8))): ?>
                                            <div class="btn-group pull-right">
                                                <a href="<?= base_url('index.php/AuditComment/editAuditComment/' . $auditor_comment['id'] . '/auditor/8') ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm <?= $disabled ?>" ><i  class="icon icon-pencil"></i> Edit </a>

                                                <a href="<?= base_url('index.php/AuditComment/deleteAuditComment/' . $auditor_comment['id']) ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm <?= $disabled ?>" ><i  class="icon icon-trash"></i> Delete</a>

                                            </div>
                                        <?php endif; ?>
                                        <h4 class="text-primary"><?= $data['auditor_comment_name']['names'] ?></h4>
                                        <p class="timeline-date text-muted"><small><?= $auditor_comment['time'] ?></small></p>
                                        <p><?= $auditor_comment['comment'] ?> </p>

                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endif; ?>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        
                        <?php if ($issue['action_plan_required'] == 'no'): ?>
                            <h3 class="card-title text-center">No action plan is required</h3>
                        <?php else: ?>
                            <?php if ($issue['issue_status'] == 'Open') : ?>
                                <a href="<?= base_url("index.php/Audit/actionplanForm/0/{$issue['id']}") ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm pull-right <?= $disabled ?> "><i  class="icon icon-plus"></i> New Management Action Plan </a>
                            <?php endif; ?>
                            <h5 class="card-title">Management Action Plans</h5>
                            <table id="datatable-buttons" class="table  table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Action Plan</th>
                                        <th>Action by Date</th>
                                        <th>Action Plan Owner</th>
                                        <th>Assigned To</th>
                                        <th>Review Date</th>
                                        <th>Action Plan Approval Status</th>
                                        <th>Implementation Status</th>
                                        <th>Verification Status</th>
                                        <th>Status of Action plan</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    <?php
                                    $num = 0;
                                    foreach ($data['action_plans'] as $key => $value) :
                                        $num++;
                                        ?>
                                        <tr>
                                            <td><?= $num ?></td>
                                            <td><a href="<?= base_url('index.php/Audit/action_plan/' . $value['id'] . '') ?>" <?= MODAL_LINK ?>><?= ucwords($value['action_plan']) ?> </a></td>
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>




<script type="text/javascript">
    $('.audit_details_toggle').click(function (parameters) {
        $('#audit_details').slideToggle('fast');
        $('.audit_details_toggle').toggleClass('hidden');
    });
    $(document).ready(function () {
        $('#audit_details').hide(0);
    });


    $('.timeline_details_toggle').click(function (parameters) {
        $('#timeline_details').slideToggle('fast');
        $('.timeline_details_toggle').toggleClass('hidden');
    });
    $(document).ready(function () {
        $('#timeline_details').hide(0);
    });

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