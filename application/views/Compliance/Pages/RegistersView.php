<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php
$register = $data['register'];
//print_pre($register); exit;
?>
<div class="container-fluid">

    <div class="card card-header bg-light">
        <h4 class="card-title">Compliance Register</h4>
    </div>

    <div class="row">
        <div class="col-sm-3">

            <div class='card'>
                <div class="row">
                    <div class="card-block">
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a href="<?= base_url("index.php/Compliance/registerForm/0"); ?> " <?= MODAL_LINK ?> class="btn btn-secondary btn-sm pull-rig"><i class="fa fa-plus"></i> Add Register</a>
                        <?php endif; ?>
                    </div>
                </div>

                <hr /> 


                <div class="list-group list-registers" >
                    <?php foreach ($data['registers'] as $key => $value): ?>
                        <a href="<?= base_url("index.php/Compliance/register/{$value['id']}") ?>" class="list-group-item <?= $value['id'] == $data['register']['id'] ? "active" : NULL; ?> list_registers link"> <?= $value['title'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div> 
        </div><!--end of col registers-->
        <div class="col-sm-9 ">
            <?php // print_pre($data) ?>
            <?php if (count($data['register']) != 0): ?>

                <div class="card">
                    <div class="panel panel-default">
                        <div class="card-block">
                            <div class="panel-heading">
                                <div class="btn-group pull-right">
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?>  href="<?= base_url("index.php/Compliance/registerSelectCompliance/{$data['register']['id']}") ?>"><i class="icon icon-list"></i>  Select Compliance Requirements</a>
                                    <?php endif; ?>
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/registerForm/{$data['register']['id']}"); ?>"><i class="icon icon-pencil"></i> Edit</a>
                                    <?php endif; ?>
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/registerDelete/{$data['register']['id']}"); ?>"><i class="icon icon-trash"></i> Delete</a>
                                    <?php endif; ?>
                                    <a data-toggle="collapse" data-parent="#accordion2" onclick="toggle_hidden_class('reg_more_info_toggle')" href="#collapseOne2" class="btn btn-secondary reg_more_info_toggle btn-sm"> <i class="icon icon-arrow-down"></i> More</a>
                                    <a data-toggle="collapse" data-parent="#accordion2" onclick="toggle_hidden_class('reg_more_info_toggle')" href="#collapseOne2" class="btn btn-secondary reg_more_info_toggle hidden btn-sm"> <i class="icon icon-arrow-up"></i> Less</a>

                                </div>
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
                                        <?= $register['title'] ?>
                                    </a>

                                </h4>

                            </div>
                            <div id="collapseOne2" class="panel-collapse collapse out">
                                <div class="panel-body">
                                    <div class="">
                                        <hr class="row">
                                        <span class="pull-right"><i class="icon icon-calender"></i> Created : <small><?= strftime("%b %d %Y", strtotime($register['timestamp'])) ?></small></span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <h6 class="text-muted"><i class="icon icon-user"></i> Owner : <?= $register['register_owner']['names'] ?></h6>
                                    
                                    <div class=""><?= $register['summary'] ?></div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-block">

                        <div class="table-responsive" >
                            <table id="datatable-buttons" class="table table-sm table-small table-hover ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Repository</th>
                                        <th>Area</th>
                                        <th class="text-center">Priority</th>
                                        <th class="text-center">Completion </th>
                                        <th class="text-center">Obligations</th>
                                        <th style="width: 220px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data['compliance_requirements'] as $key => $value):
                                        $priority_label = $value['priority'] == "Low" ? "info" : $value['priority'] == "Medium" ? "warning" : "danger";
                                        $delete_link = base_url("index.php/Compliance/deleteComplianceRequirement/{$value['id']}");
                                        $edit_link = base_url("index.php/Compliance/complianceRequirementForm/{$value['id']}");
                                        $add_obligation_link = base_url("index.php/Compliance/obligationForm/0/{$value['id']}");
                                        $chart_link = base_url("index.php/Compliance/ComplianceRequirementChart/{$value['id']}");
                                        ?>
                                        <tr>
                                            <td><a href="<?= base_url("index.php/Compliance/complianceRequirement/{$value['id']}") ?>"><?= $value['title'] ?></a></td>
                                            <td><?= $value['type'] ?></td>
                                            <td><?= $repository_sources[$value['repository']['source']] ?></td>
                                            <td><?= $value['repository']['name'] ?></td>

                                            <td class="text-center">
                                                <span class="label label-pill label-<?= $priority_label ?>">
                                                    <?= $value['priority'] ?>
                                                </span>
                                            </td>
                                            <td class="text-center"><?= $value['completion']; ?> %</td>
                                            <td class="text-center">
                                                <a href="<?= base_url("index.php/Compliance/complianceObligationsList/{$value['id']}") ?>" <?= MODAL_LINK ?> class="label label-pill label-info">
                                                    <i class="icon icon-share-alt"></i>
                                                    <span>  <?= count($value['obligations']) ?></span> 
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group pull-right">
                                                    <?php if (am_user_type(array(1, 5, 6, 10))): ?>
                                                        <a href="<?= $add_obligation_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="icon icon-plus"></i> Obligation</a>
                                                    <?php endif; ?>

                                                    <?php if (am_user_type(array(1, 5))): ?>
                                                        <a href="<?= $edit_link ?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm"><i class="icon icon-pencil"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (am_user_type(array(1, 5)) and  count($value['obligations']) ): ?>
                                                        <a href="<?= $delete_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="icon icon-trash"></i></a>
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
                <?= show_comments("Compliance", "compliance_register", $register['id'], 0); ?>
            <?php else : ?>
                <div class="card">
                    <div class="card-block">
                        <div class="jumbotron text-center" style="background: none">
                            <h1>No registers in the system</h1>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <p><a class="btn btn-primary btn-lg" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/registerForm/0"); ?>">Add Register</a></p>
                            <?php endif; ?>
                        </div> 
                    </div>
                </div>
            <?php endif; ?>
        </div><!--end col-->
    </div>
</div>
