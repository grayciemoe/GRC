<?php
$control = $data['control']['control'];
if (!am_user_type(array(1, 5)) and !in_array($me['user']['id'], $control['can_see'])) {
    restricted_view();
    return false;
}

if ($control['owner']['id'] == $me['user']['id'] or $control['risk']['risk_owner']['id'] == $me['user']['id'] or am_user_type(array(1, 5))):
    ?>
    <div class="container-fluid">
        <?php if ($control['approval_status'] == 'pending' and $control['type'] == 'proposed'): ?>
            <?php if (am_user_type(array(1, 5))): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Review status: <small>Approve <?= ucwords($control['type']) ?> Control</small></h4> <br>
                    <a href="<?= base_url("index.php/Risk/controlApprove/{$control['id']}/approved") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                    <a href="<?= base_url("index.php/Risk/controlApprove/{$control['id']}/rejected") ?>" class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($control['approval_status'] == 'approved' and $control['type'] == 'proposed'): ?>
            <?php if (am_user_type(array(1, 5)) or $control['owner'] == $me['user']['id'] or $control['risk']['risk_owner'] == $me['user']['id']): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4>Review status:<small> Set Approved control to control in place</small> </h4> <br>
                    <a href="<?= base_url("index.php/Risk/controlSetInPlace/{$control['id']}") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Set as control in place</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($control['approval_status'] == 'pending' and $control['type'] == 'in place'): ?>
            <?php if (am_user_type(array(1, 5))): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Approve control in place</h4> <br>
                    <a href="<?= base_url("index.php/Risk/controlApprove/{$control['id']}/approved") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                    <a href="<?= base_url("index.php/Risk/controlApprove/{$control['id']}/rejected") ?>" class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($control['approval_status'] == 'rejected'): ?>
            <?php if (am_user_type(array(1, 5))): ?>
                <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>This is a rejected control, you can delete it.</h4> <br>
                    <a href="<?= base_url("index.php/Risk/controlDelete/{$control['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Delete Control</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-block">
                <div class="btn-group ">
                    <h5 class="card-title"><?= $control['title'] ?></h5>
                </div>
            </div>
        </div>
        <div class="row">
            <?php // print_pre($data);   ?>
            <div class="col-sm-4 ">
                <div class="card">
                    <div class="card-block">
                        <div class="btn-group pull-right">
                            <?php if (am_user_type(array(1, 5)) or $control['owner'] == $me['user']['id'] or $control['risk']['risk_owner'] == $me['user']['id']): ?>
                                <a href="<?= base_url("index.php/Risk/controlForm/{$control['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small "><i class="icon icon-pencil"></i> Edit</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a href="<?= base_url("index.php/Risk/controlDelete/{$control['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-trash"></i> Delete</a>
                            <?php endif; ?>
                        </div>
                        <h4 class="card-title"> Control Details </h4>
                        <table class="table table-small table-sm">
                            <tbody>
                                <tr>
                                    <td style="width: 120px;">Title</td>
                                    <td> <?= $control['title'] ?> </td>
                                </tr>
                                <?php if (isset($control['control_categories']['title'])): ?>
                                    <tr>
                                        <td style="">Category</td>
                                        <td> <?= $control['control_categories']['title'] ?> </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($control['owner']['id'])): ?>
                                    <tr>
                                        <td>Owner</td>
                                        <td><a href="<?= base_url("index.php/Home/users/" . $control['owner']['id']) ?>"><?= $control['owner']['names'] ?></a></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>Intention</td>
                                    <td><?= ucwords($control['intention']) ?></td>
                                </tr>
                                <tr>
                                    <td>Approval Status</td>
                                    <td><span class="label label-pill label-<?= $control['approval_status'] == 'approved' ? "success" : (($control['approval_status'] == 'rejected') ? "danger" : "warning") ?>"><?= ucwords($control['approval_status']) ?></span></td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td><span class="label label-pill label-<?= $control['type'] == 'proposed' ? "default" : "success" ?>"><?= ucwords($control['type']) ?></span></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <span class="pull-right"><?= ($control['status_completion']) . " %" ?></span> 

                                        <span class="label label-pill label-<?= $control['status'] == 'complete' ? "info" : "warning" ?>"><?= ucwords($control['status']) ?> </span> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>
                                        <span class="label label-pill label-<?= $control['state'] == 'sufficient' ? "info" : "warning" ?>"><?= ucwords($control['state']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Criticality </td>
                                    <td>
                                        <span class="label label-pill label-<?= $control['criticality'] == 'high' ? "danger" : ($control['criticality'] == 'medium' ? "warning" : "default") ?>"><?= ucwords($control['criticality']) ?></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">
                            Control Origin
                        </h4>
                        <hr class="m-0">
                        <table class="table table-small table-sm">
                            <tbody>
                                <?php if (isset($control['risk']['id'])): ?>
                                    <tr>
                                        <td style="width: 100px;">Risk</td>
                                        <td><a href="<?= base_url("index.php/Risk/risk/{$control['risk']['id']}") ?>"><?= $control['risk']['title'] ?></a></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($control['repository']['id'])): ?>
                                    <tr>
                                        <td>Risk Source</td>
                                        <td><?= ucwords(str_replace("_", " ", $control['repository']['source'])) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($control['repository']['id'])): ?>
                                    <tr>
                                        <td>Key Risk Area </td>
                                        <td><a <?= MODAL_LINK ?> href="<?= base_url("index.phpHome/repositoryPreview/{$control['repository']['id']}") ?>"><?= $control['repository']['name'] ?></a></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($control['environment']['id'])): ?>
                                    <tr>
                                        <td>Unit </td>
                                        <td><a href="<?= base_url("index.php/Home/dashboard/{$control['environment']['id']}"); ?>"><?= $control['environment']['name'] ?></a></td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (isset($control['owner']['id'])): ?>
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">
                                Control Activity Owner
                            </h4>
                            <hr class="m-0">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object  img-rounded" src="<?= img_src($control['owner']['profile_pic'], 70, 70) ?>" alt="...">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><small><?= $control['owner']['names'] ?></small></h4>
                                    <p><?= $control['owner']['name'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">
                                No Owner
                            </h4>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-8">
                <div class="card">

                    <div class="card-block">
                        <h4 class="card-title">
                            Description 
                        </h4>
                        <hr class="m-0">
                        <div class="wisywig"><?= $control['description'] ?></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <?php
//print_pre($me['user']);

                        if ($control['approval_status'] == 'approved'):
                            ?>
                            <?php
                            if (am_user_type(array(1, 5)) or
                                    $control['owner']['id'] == $me['user']['id'] or
                                    $control['risk']['risk_owner']['id'] == $me['user']['id']):
                                ?>
                                <a href="<?= base_url("index.php/Risk/activityForm/0/{$control['id']}") ?>" <?= MODAL_LINK ?> class="pull-right btn btn-secondary btn-sm btn-small waves-effect waves-light"><i class="icon icon-plus"></i> Control Activity</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <h4 class="card-title">
                            Control activity
                        </h4>
                        <hr class="m-0">
                        <table class="table table-striped table-sm table-small">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Control Activity</th>
                                    <th>Owner</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Approval</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Criticality</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $num = 0;
                                foreach ($control['activities'] as $key => $value):
                                    $num ++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $num ?></th>
                                        <td><a <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/activity/{$value['id']}") ?>" ><?= $value['name'] ?></a> </td>
                                        <td><?= ($value['user_owner']['names']) ?></td>
                                        <td class="text-center"><?= ucwords($value['type']) ?></td>
                                        <td class="text-center"> <span class="label label-pill label-<?= $value['review_status'] == 'pending' ? "warning" : (($value['review_status'] == 'approved') ? "success" : "danger") ?>"><?= ucwords($value['review_status']) ?></span></td>
                                        <td class="text-center"> <span class="label label-pill label-<?= $value['status'] == 'complete' ? "info" : "warning" ?>"><?= ucwords($value['status']) ?></span></td>
                                        <td class="text-center"> <span class="label label-pill label-<?= $value['criticality'] == 'high' ? "danger" : (($value['criticality'] == 'medium') ? "warning" : "default") ?>"><?= ucwords($value['criticality']) ?></span></td>
                                        <td>
                                            <?php if (am_user_type(array(1, 5)) or $control['owner'] == $me['user']['id'] or $control['risk']['risk_owner'] == $me['user']['id']): ?>
                                                <div class="btn-group pull-right">    
                                                    <a href="<?= base_url("index.php/Risk/activityForm/{$value['id']}") ?>" <?= MODAL_LINK ?>
                                                       class="btn btn-secondary btn-sm btn-small pull-right"><i class="icon icon-pencil"></i></a>
                                                    <a href="<?= base_url("index.php/Risk/activityDelete/{$value['id']}") ?>" <?= MODAL_LINK ?>
                                                       class="btn btn-secondary btn-sm btn-small pull-right"><i class="icon icon-trash"></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?= show_comments("Risk", "control", $control['id']) ?>
            </div>
        </div>
    </div>
    <?php
else :

    restricted_view();

endif;
?>