<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php
$risk_register = $data['register'];
$risk = $data['risks'];
$risks = $risk;
?>
<div class="container-fluid">

    <div class="card card-header bg-light">
        <h4 class="card-title">Risk Register</h4>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class='card'>
                <div class="card-block">
                    <div class="card-title">
                        <div class="center ">
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a href="<?= base_url("index.php/Risk/registerForm/0"); ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> Add Risk Register</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="list-group list-registers" >
                    <?php foreach ($data['registers'] as $key => $value): ?>
                        <a href="<?= base_url("index.php/Risk/register/{$value['id']}") ?>" class="list-group-item <?= $value['id'] == $data['register']['id'] ? "active" : NULL; ?> list_registers link"> <?= $value['title'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div> 
        </div><!--end of col registers-->
        <div class="col-sm-9 ">
            <?php if (count($data['register']) != 0): ?>
                <div class="card">
                    <div class="panel panel-default">
                        <div class="card-block">
                            <div class="panel-heading">
                                <div class="btn-group pull-right">
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?>  href="<?= base_url("index.php/Risk/registerSelectRisk/{$data['register']['id']}") ?>"><i class="icon icon-list"></i>  Select Risks</a>
                                    <?php endif; ?>
                                    <?php if ($data['register']['published'] == 0): ?>
                                        <?php if (am_user_type(array(1, 5))): ?>
                                            <a class="btn btn-secondary btn-sm" href="<?= base_url("index.php/Risk/registerPublish/{$data['register']['id']}") ?>"><i class="icon icon-check"></i> Publish</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/registerForm/{$data['register']['id']}"); ?>"><i class="icon icon-pencil"></i> Edit</a>
                                    <?php endif; ?>
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/registerDelete/{$data['register']['id']}"); ?>"><i class="icon icon-trash"></i> Delete</a>
                                    <?php endif; ?>

                                    <a data-toggle="collapse" data-parent="#accordion2" onclick="toggle_hidden_class('reg_more_info_toggle')" href="#collapseOne2" class="btn btn-secondary reg_more_info_toggle btn-sm"> <i class="icon icon-arrow-down"></i> More</a>
                                    <a data-toggle="collapse" data-parent="#accordion2" onclick="toggle_hidden_class('reg_more_info_toggle')" href="#collapseOne2" class="btn btn-secondary reg_more_info_toggle hidden btn-sm"> <i class="icon icon-arrow-up"></i> Less</a>

                                </div>

                                <h4 class="panel-title">

                                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
                                        <?= $risk_register['title'] ?>
                                    </a>


                                </h4>
                            </div>
                            <div id="collapseOne2" class="panel-collapse collapse out">
                                <div class="panel-body">

                                    <p> <label> Associated Business goals</label><?= $risk_register['associated_business_goals'] ?> </p>

                                    <p> <label> Description</label><?= $risk_register['description'] ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">
                        <ul class="nav nav-tabs tabs-risk" id="myTab" role="tablist">
                            <li class="nav-item nav-risk">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                   role="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-list"></i> List</a>
                            </li>
                            <li class="nav-item nav-risk">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                   role="tab" aria-controls="profile"><i class="fa fa-fire"></i> Gross Risk</a>
                            </li>
                            <li class="nav-item nav-risk">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dropdown1"
                                   role="tab" aria-controls="profile"><i class="fa fa-fire-extinguisher"></i> Control Ratings</a>
                            </li>
                            <li class="nav-item nav-risk">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dropdown2"
                                   role="tab" aria-controls="profile"><i class="fa fa-fire"></i> Net Risk</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content card-block" id="myTabContent">
                        <div role="tabpanel" class="tab-pane fade in active" id="home"
                             aria-labelledby="home-tab">
                            <div class="">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width:80px">Ref Code</th>
                                            <th>Name</th>
                                            <th class="text-center">Gross Risk</th>
                                            <th class="text-center">Control Ratings</th>
                                            <th class="text-center">Net Risk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($risk as $key => $value): ?>
                                            <tr>
                                                <td><?= $value['heat_map_ref'] ?></td>
                                                <td><a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a></td>
                                                <td  class="gross_risk-<?= strtolower(heatmap_key("gross_risk", $value['gross_risk'])) ?>"><span></span> <?= heatmap_key("gross_risk", $value['gross_risk']); ?></td>
                                                <td class="control_ratings-<?= strtolower(heatmap_key("control_ratings", $value['control_ratings'])) ?>"><?= heatmap_key("control_ratings", $value['control_ratings']); ?></td>
                                                <td class="net_risk-<?= strtolower(heatmap_key("net_risk", $value['net_risk'])) ?>"><?= heatmap_key("net_risk", $value['net_risk']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel"
                             aria-labelledby="profile-tab">
                                 <?= gross_risk($risks) ?>
                        </div>
                        <div class="tab-pane fade" id="dropdown1" role="tabpanel"
                             aria-labelledby="dropdown1-tab">
                                 <?= control_ratings($risks) ?>
                        </div>
                        <div class="tab-pane fade" id="dropdown2" role="tabpanel"
                             aria-labelledby="dropdown2-tab">
                                 <?= net_risk($risks) ?>
                        </div>
                    </div>
                </div>
                <?= show_comments("risk", "risk_register", $data['register']['id'], 0); ?>
            <?php else : ?>
                <div class="card">
                    <div class="card-block">
                        <div class="jumbotron text-center" style="background: none">
                            <h1>No registers in the system</h1>
                            <?php if (am_user_type(array(1, 5))): ?>    
                                <p><a class="btn btn-primary btn-lg" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/registerForm/0"); ?>">Add Register</a></p>
                            <?php endif; ?>
                        </div> 
                    </div>
                </div>
            <?php endif; ?>
        </div><!--end col-->
    </div>
</div>