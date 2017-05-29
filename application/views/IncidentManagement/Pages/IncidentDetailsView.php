<?php
$incident_management = $data["incident"];
$actions = $data["actions"];
?> 
<?php
$myID = $me['user']['id'];
if (!am_user_type(array(1, 2, 3, 4, 5)) and $incident_management['user'] != $myID and $incident_management['responsible_manager'] != $myID) {
    restricted_view();
    return false;
}


//print_pre($actions);
$sum = 0;
$complete = 0;
foreach ($actions as $key => $value) {
    $sum++;
    if ($value['status'] == "complete") {
        $complete++;
    }
}
$incident_management['state'] = ($sum > 0 and $complete == $sum) ? "Complete" : "In Progress";
?>

<div class="container-fluid">
    <?php if ($incident_management['draft'] == 0): ?>
        <?php if ($incident_management['approved'] == 'pending' and am_user_type(array(1, 5)) and $data['risk']['approved'] == 'Approved'): ?>
            <div class="alert alert-warning" role="alert">
                <p class="text-center"><strong>Approve Incident</strong></p>
                <p class="text-center">This incident has been reported, Approve or Reject it</p>
                <div class="col-lg-offset-5">
                    <a href="<?= base_url("index.php/IncidentManagement/incidentApprove/{$incident_management['id']}/approved") ?>" class="btn btn-success waves-effect waves-light">
                        <span class="btn-label"><i class="fa fa-check"></i>
                        </span>Approve</a>
                    <a href="<?= base_url("index.php/IncidentManagement/incidentApprove/{$incident_management['id']}/rejected") ?>" class="btn btn-danger waves-effect waves-light">
                        <span class="btn-label"><i class="fa fa-times"></i>
                        </span>Reject</a>
                </div>
            </div>
        <?php elseif ($data['risk']['approved'] == 'Proposed' and $incident_management['approved'] == 'pending' and am_user_type(array(1, 5))): ?>
            <div class="alert alert-danger" role="alert">
                <p class="text-center"><strong>Approve Proposed Risk</strong></p>
                <p class="text-center">Risk <strong><?= $data['risk']['title'] ?></strong> was proposed and has not yet been approved.</p>
                <p class="text-center">Approve the risk in order to approve/reject this incident</p>

                <p class="text-center"><a href="<?= base_url("index.php/Risk/risk/{$data['risk']['id']}") ?>" target="_blank" class="btn btn-secondary ">Go to Risk</a></p>
            </div>
        <?php elseif ($data['risk']['approved'] == 'Rejected' and $incident_management['approved'] == 'pending' and am_user_type(array(1, 5))): ?>
            <div class="alert alert-warning" role="alert">
                <p class="text-center"><strong>Reject Incident</strong></p>
                <p class="text-center">This incident resulted from a rejected risk. </p>
                <div class="text-center">
                    <a href="<?= base_url("index.php/IncidentManagement/incidentApprove/{$incident_management['id']}/rejected") ?>" class="btn btn-danger waves-effect waves-light">
                        <span class="btn-label"><i class="fa fa-times"></i>
                        </span>Reject Incident</a>
                </div>
            </div>

        <?php endif; ?>

        <?php if ($data['risk']['evaluate'] == 'yes' and $incident_management['approved'] == 'approved' and am_user_type(array(1, 5))): ?>
            <div class="alert alert-danger" role="alert">
                <p class="text-center"><strong>Evaluate Risk</strong></p>
                <p class="text-center">Risk <strong><?= $data['risk']['title'] ?></strong> has not yet been evaluated, Please evaluate the risk</p>
                <p class="text-center"><a href="<?= base_url("index.php/Risk/risk/{$data['risk']['id']}") ?>" class="btn btn-secondary ">Go to Risk</a></p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            <p class="text-center"><strong>Draft Report</strong></p>
            <p class="text-center">This is a draft Incident Management report. Please click edit to finsh creating the draft</p>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-4 incident-detail">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group pull-right ">

                        <?php if (( am_user_type(array(1, 5))) or ( $incident_management['user'] == $myID and $incident_management['approved'] == 'pending')): ?>
                            <a href="<?= base_url("index.php/IncidentManagement/incidentDelete/{$incident_management['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-secondary "><i class="fa fa-trash"></i>&nbsp;Delete</a>
                        <?php endif; ?>
                        <?php if (( am_user_type(array(1, 5))) or ( $incident_management['user'] == $myID and $incident_management['approved'] == 'pending')): ?>
                            <a href="<?= base_url("index.php/IncidentManagement/incidentForm/{$incident_management['id']}") ?>" class="btn btn-secondary"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-block"></div>
                <table class="table  table-small table-sm">
                    <tbody>
                        <?php
                        $status_label = $incident_management['status'] == "active" ? "info" : $incident_management['status'] == "open" ? "success" : "warning";
                        $state_label = $incident_management['incident'] == "complete" ? "success" : "warning";
                        ?>
                        <tr>
                            <th class="text-right">Title</th>
                            <td><?= $incident_management['title'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Risk Category </th>
                            <td><?= $data['risk_category']['title'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">Category of Incident</th>
                            <td><?= $data['category']['title'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Associated Risk</th>
                            <td><?= $data['risk']['title'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right ">Business Unit</th>
                            <td><?= $data['unit']['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right ">Where the Risk Occurred</th>
                            <td><?= $incident_management['location'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Status</th>
                            <td><span class="label label-pill label-<?= $status_label ?>">
                                    <?= ucwords($incident_management['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right">Approval Status</th>
                            <td><span class="label label-pill label-<?= $incident_management['approved'] == 'approved' ? "success" : ($incident_management['approved'] == 'pending' ? "warning" : "danger") ?>">
                                    <?= ucwords($incident_management['approved']) ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-right">Experience Type</th>
                            <td><?= $incident_management['experience_type'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">State</th>
                            <td>
                                <span class="label label-pill label-<?= $state_label ?>">
                                    <?= ucwords($incident_management['state']) ?>
                                </span></td>
                        </tr>
                        <tr>
                            <th class="text-right">Escalation Level</th>
                            <td><?= $incident_management['escalation_level'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Cause Category</th>
                            <td><?= $incident_management['cause_category'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">Source</th>
                            <td><?= $incident_management['source'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">Responsible Manager</th>
                            <td><?= $data['responsible_manager']['names'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">Reported by</th>
                            <td><?= $incident_management['reported_by'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Reported category</th>
                            <td><?= $incident_management['reporter_category'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">Detection Method</th>
                            <td><?= $incident_management['detection_method'] ?></td>
                        </tr>

                        <tr>
                            <th class="text-right">Action due date</th>
                            <td><?= $incident_management['action_due_date'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Experience Type Level</th>
                            <td><?= $incident_management['experience_type_level'] ?></td>
                        </tr>

                        <?php if ($incident_management['experience_type_level'] == 'Actual Loss'): ?>
                            <tr>
                                <th class="text-right">Total Cost</th>
                                <td><?= $incident_management['total_cost'] ?></td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <th class="text-right">Maximum Potential Loss</th>
                                <td><?= $incident_management['maximum_potential_loss'] ?></td>
                            </tr>
                            <tr>
                                <th class="text-right">Expected Loss</th>
                                <td><?= $incident_management['expected_loss'] ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th class="text-right">Date Reported</th>
                            <td><?= $incident_management['date_reported'] ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Date of Incident</th>
                            <td><?= $incident_management['date_of_incident'] ?></td>
                        </tr>


                    </tbody>
                </table>


            </div>


        </div><!--end of col sm 4-->
        <div class="col-sm-8 incident-detail">
            <div class="card">

                <ul class="nav nav-tabs incident-tabs m-b-10 text-center" id="myTab" role="tablist">
                    <li class="nav-item">

                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                           role="tab" aria-controls="home" aria-expanded="true"> <i class="icon  icon-info "></i> <br>Description</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                           role="tab" aria-controls="profile"> <i class="icon-compass"></i> <br> Cause</a>
                    </li>

                </ul>
                <div class="card-block">
                    <div class="tab-content" id="myTabContent">
                        <div role="tabpanel" class="tab-pane fade in active" id="home"
                             aria-labelledby="home-tab">

                            <?= $incident_management['description'] ?>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel"
                             aria-labelledby="profile-tab">
                                 <?= $incident_management['cause'] ?>
                        </div>
                    </div>

                </div>


            </div>


            <div class="card">
                <div class="card-block">
                    <?php if (am_user_type(array(1, 5))): ?>
                        <a class="btn btn-sm btn-secondary waves-effect waves-light pull-right" href="<?= base_url("index.php/IncidentManagement/actionForm/0/{$incident_management['id']}"); ?>" <?= MODAL_LINK ?> ><i class="icon-plus"></i> Add Action </a>
                    <?php endif; ?>
                    <h5 class="card-title">Actions to be taken</h5>
                    <br />
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Owner</th>
                                <th>Due Date</th>
                                <th>Completion Status</th>
                                <th style="width:80px">Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($actions as $key => $value):
                                $edit_link = base_url("index.php/IncidentManagement/actionForm/{$value['id']}");
                                $delete_link = base_url("index.php/IncidentManagement/actionDelete/{$value['id']}");


                                //$date = NULL;
                                $date = strftime("%b %d %Y", strtotime($value['due_date']));
                                $timestamp = strtotime($value['due_date']);
                                ?>
                                <tr>                               
                                    <td> <a href="<?= base_url("index.php/IncidentManagement/previewAction/"); ?>" class="hidden" <?= MODAL_LINK ?>> <?= $value['title'] ?> </a> 
                                        <?= $value['title'] ?> </td>
                                    <td><a href="mailto:<?= $value['owner'] ?>"><?= $value['owner'] ?></a></td>
                                    <td>
                                        <span class="text-<?= ($timestamp < time() and ( $value['status'] != 'complete')) ? "danger" : "default" ?>">
                                            <?= $date ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label label-<?= $value['status'] == 'complete' ? "success" : "danger" ?>">
                                            <?= ucwords($value['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <?php if (am_user_type(array(1, 5)) or ( $incident_management['responsible_manager'] == my_id())): ?>
                                                <a class="btn btn-secondary btn-sm"  <?= MODAL_LINK ?> href="<?= $edit_link ?>"><i class="icon icon-pencil"></i> </a>
                                            <?php endif; ?>
                                            <?php if (am_user_type(array(1, 5))): ?>
                                                <a class="btn btn-secondary btn-sm"  <?= MODAL_LINK ?> href="<?= $delete_link ?>"><i class="icon icon-trash"></i> </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-block">
                    <h3 class="card-title">Documents</h3>
                    <?= show_documents("incident_management", "incident_management", $incident_management['id']); ?>
                </div>

            </div>
            <?= show_comments("incident_management", "incident_management", $incident_management['id']); ?>
        </div>
    </div>

</div><!-- End of conatiner-->



