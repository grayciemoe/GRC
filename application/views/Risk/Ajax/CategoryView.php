<?php
$risk_category = $data['category'];
$risk = $data['risks'];
$risks = $risk;
//print_pre($risks);
//print_pre($risks);
?><?php if (count($data['category']) != 0): ?>
    <div class="card">
        <div class="panel panel-default">
            <div class="card-block">
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <?php if (count($data['root']) < 3): ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/categoryForm/0/{$data['category']['id']}"); ?>"><i class="icon icon-plus"></i> Add Sub Category</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/categoryForm/{$data['category']['id']}"); ?>"><i class="icon icon-pencil"></i> Edit</a>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/categoryDelete/{$data['category']['id']}"); ?>"><i class="icon icon-trash"></i> Delete</a>
                        <?php endif; ?>
                    </div>
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
                            <?= $risk_category['title'] ?>
                        </a>
                    </h4>
                    <p>
                        <?php foreach ($data['root'] as $key => $value): ?>
                            <em>
                                <?php if (count($data['root']) > ($key + 1)): ?> 
                                    <a href="<?= base_url("index.php/Risk/categoryAjax/{$value['id']}") ?>" <?= AJAX_LINK ?> data-target="categoryView"> 
                                        <?= $value['title'] ?> 
                                    </a> 
                                <?php else : ?>
                                    <?= $value['title'] ?> 
                                <?php endif; ?>
                                <?php if (count($data['root']) > ($key + 1)): ?> 
                                    <i class="fa fa-angle-right"></i>
                                <?php endif; ?>
                            </em>   

                        <?php endforeach; ?>
                    </p>
                </div>
                <div id="collapseOne2" class="panel-collapse collapse out">
                    <div class="panel-body">
                        <p> <?= null; // $risk_category['associated_business_goals']                     ?> </p>
                        <p> <?= null; // $risk_category['description']                     ?> </p>
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
                                <th>Name</th>
                                <th class="text-center">Gross Risk</th>
                                <th class="text-center">Control Ratings</th>
                                <th class="text-center">Net Risk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($risk as $key => $value): ?>
                                <tr>
                                    <td><a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a></td>
                                    <td class="gross_risk-<?= strtolower(heatmap_key("gross_risk", $value['gross_risk'])) ?>"><span></span> <?= heatmap_key("gross_risk", $value['gross_risk']); ?></td>
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
    <?= show_comments("risk", "risk_category", $data['category']['id'], 0); ?>
<?php else : ?>
    <div class="card">
        <div class="card-block">
            <div class="jumbotron text-center" style="background: none">
                <h1>No categories in the system</h1>
                <p><a class="btn btn-primary btn-lg" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/categoryForm/0"); ?>">Add Category</a></p>
            </div> 
        </div>
    </div>
<?php endif; ?>