<?php
if (!am_user_type(array(1, 5, 9))) {
    restricted_view();
    return false;
}
//print_pre($data);
$user = $data['user'];
$user_type = $data['user_types'];
$me = $data['me'];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">

            <div class="card">
                <div class="card-block">
                    <?php if (am_user_type(array(1, 9))): ?>
                        <a class="btn btn-secondary btn-sm pull-right" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/UsersForm/0"); ?>" ><i class="icon icon-plus"></i> New</a>
                    <?php endif; ?>
                    <h3 class="card-title">All Users</h3>
                </div>
                <div class="card-block">

                    <table id="datatable-buttons" class="table table-sm table-small table-hover " >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Names</th>
                                <th class="text-right">User Type</th>
                                <th class="text-center"> 
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1 ?>
                            <tr class="bg-primary">
                                <td><?= $count ?></td>
                                <td><a href="<?= base_url("index.php/Home/users/{$data['user']['id']} "); ?>" class="text-white"><?= $data['user']['names'] ?></a></td>
                                <td class="text-right"><?= $data['user']['name'] ?></td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <?php if (am_user_type(array(1, 9))): ?>
                                            <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/UsersForm/{$data['user']['id']}"); ?>" ><i class="icon icon-pencil"></i> </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            foreach ($data['users'] as $key => $value):

                                if ($value['id'] == $me['user']['id'] or $value['id'] == $data['user']['id']) {
                                    continue;
                                }
                                $count++;
                                ?>
                                <tr class="<?= $data['user']['id'] == $value['id'] ? "bg-primary" : NULL ?>">
                                    <td><?= $count ?></td>
                                    <td><a href="<?= base_url("index.php/Home/users/{$value['id']} "); ?>" class="<?= $data['user']['id'] == $value['id'] ? "text-white" : NULL ?>"><?= $value['names'] ?></a></td>
                                    <td class="text-right"><?= $value['user_type']['initials'] ?></td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <?php if (am_user_type(array(1, 9))): ?>
                                                <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/UsersForm/{$value['id']}"); ?>" ><i class="icon icon-pencil"></i> </a>
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
        <div class="col-sm-8">

            <div class=" row">
                <div class="col-sm-4 col-lg-3 col-xs-12 ">
                    <div class="card " id="p_card">
                        <div class="card-block">
                            <h6 class="card-title m-0 p-0 "><?= $user['names'] ?></h6>
                        </div>
                        <img class="img-responsive" style="width: 100%" src="<?= img_src($user['profile_pic']); ?>" alt="Card image cap">
                        <div class="card-block m-0 ">
                            <?php if (am_user_type(array(1, 9))): ?>
                                <a href="<?= base_url("index.php/Account/changePic/{$user['id']}"); ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-block btn-sm btn-small waves-effect waves-light"><i class="icon icon-pencil"></i> Change Picture</a>
                            <?php endif; ?> 
                        </div>
                    </div>

                </div>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <div class="card" id="d_card">
                        <table class="table "> 
                            <thead >
                                <tr>
                                    <th style="border-top: none !important;">User Details</th>
                                    <th class="text-right"  style="border-top: none !important;">
                                        <div class="btn-group pull-right">
                                            <?php if (am_user_type(array(1, 9))): ?>
                                                <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/UsersForm/{$user['id']}"); ?>" ><i class="icon icon-pencil"></i> Edit </a>
                                            <?php endif; ?>
                                            <?php
                                            $duties = $user['duties'];
                                            $total_duties = 0;
                                            foreach ($duties as $key => $value) {
                                                $total_duties += count($value);
                                            }
                                            ?>
                                            <?php if (am_user_type(array(1, 9)) and $total_duties == 0): ?>
                                                <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/usersDelete/{$user['id']}"); ?>"><i class="icon icon-trash"></i> Delete </a>
                                            <?php endif; ?>
                                        </div>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Email </td>
                                    <td><?= $user['username'] ?> </td>
                                </tr>
                                <tr>
                                    <td>Names </td>
                                    <td><?= $user['names'] ?> </td>
                                </tr>
                                <tr>
                                    <td>Phone </td>
                                    <td><?= $user['phone'] ?> </td>
                                </tr>
                                <tr>
                                    <td>Type </td>
                                    <td><?= $user['name'] ?> </td>
                                </tr>
                                
                                <?php if(!empty($data['user_corporate']['id'])):?>
                                <tr>
                                    <td>Corporate </td>
                                    <td><?= $data['user_corporate']['name'] ?> </td>
                                </tr>
                                <?php endif;?>
                                <tr>
                                    <td>Created </td>
                                    <td><?= strftime("%b %d %Y %H:%M", strtotime($user['created'])) ?> </td>
                                </tr>
                                <?php if($user['accessed'] != '0000-00-00 00:00:00'):?>
                                <tr>
                                    <td>Last Login </td>
                                    <td><?= strftime("%b %d %Y %H:%M", strtotime($user['accessed'])) ?> </td>
                                </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($total_duties > 0): ?>
                <div class="card">
                    <table class="table "> 
                        <thead >
                            <tr >
                                <th colspan="2" style="border-top: none !important;">
                                    <?php if (am_user_type(array(1, 9))): ?>
                                        <a class="btn btn-secondary pull-right btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/userHundover/{$user['id']}"); ?>"><i class="icon  icon-vector"></i> Hand Over </a>
                                    <?php endif; ?>
                                    <?= $user['names'] ?>'s Responsibilities</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($user['duties']['units']) > 0) : ?>
                                <tr>
                                    <td>Units </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['units']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['risks']) > 0) : ?>
                                <tr>
                                    <td>Risks </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['risks']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['controls']) > 0) : ?>
                                <tr>
                                    <td>Controls  </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['controls']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['control_activities']) > 0) : ?>
                                <tr>
                                    <td>Control Activities </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['control_activities']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['complaince_requirements']) > 0) : ?>
                                <tr>
                                    <td>Compliance Requirements </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['complaince_requirements']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['compliance_registers']) > 0) : ?>
                                <tr>
                                    <td>Compliance Registers </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['compliance_registers']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['obligations']) > 0) : ?>
                                <tr>
                                    <td>Obligations </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['obligations']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['incidents']) > 0) : ?>
                                <tr>
                                    <td>Incidents </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['incidents']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (count($user['duties']['incident_actions']) > 0) : ?>
                                <tr>
                                    <td>Incident Actions </td>
                                    <td class="text-right"><span class="label label-success label-pill label-rounded"><?= count($user['duties']['incident_actions']) ?></span> </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="card hidden">
        <div class="card-block">
            <h4 class="card-title">Users </h4> 
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <div class=" row card ">
                        <ul class="nav nav-tabs nav-tabs-alt nav-justified " id="myTab" role="tablist">
                            <li class="nav-item ">
                                <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risks"
                                   role="tab" aria-controls="risk" aria-expanded="true"><i class="fa fa-dashboard "></i> Risks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="compliance-tab" data-toggle="tab" href="#compliance"
                                   role="tab" aria-controls="compliance"><i class="fa fa-dashboard "></i> Compliance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="incident_management-tab" data-toggle="tab" href="#incident_management"
                                   role="tab" aria-controls="incident_management"> <i class="fa fa-dashboard"></i> Incident Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="audit-tab" data-toggle="tab" href="#audit"
                                   role="tab" aria-controls="audit"><i class="fa fa-dashboard "></i> Audit</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div role="tabpanel" class="tab-pane fade in active" id="all_risks"
                                 aria-labelledby="home-tab">
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>

</div>


<script>
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: true,
            buttons: [],
            "columnDefs": [
            ]
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        if ($('#d_card').height() < $("#p_card").height()) {
            $('#d_card').height($("#p_card").height());
        } else {
            $('#p_card').height($("#d_card").height());
        }

    });
</script>