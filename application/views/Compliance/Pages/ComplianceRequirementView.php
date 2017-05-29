<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php $compliance_requirement = $data['compliance_requirement'] ?>
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="card card">
            <div class="card-block">
                <?php // print_pre($compliance_requirement) ?>
                <div class="row">
                    <div class="col-xs-1 text-center text-muted">
                        <i class="icon icon-pie-chart fa-3x "></i>
                    </div>
                    <div class="col-xs-11">
                        <div class="btn-group pull-right">
                            <button class="btn btn-sm btn-secondary hidden cr_details_toggle" ><i class="icon icon-arrow-up"></i> Less </button>
                            <button class="btn btn-sm btn-secondary  cr_details_toggle"><i class="icon icon-arrow-down"></i> More </button>
                            <?php if (am_user_type(array(1, 5)) and count($data['obligations']) == 0): ?>
                                <a href="<?= base_url("index.php/Compliance/deleteComplianceRequirement/{$compliance_requirement['id']}") ?>" class="btn btn-secondary btn-sm" <?= MODAL_LINK ?>><i class="icon icon-trash"></i> Delete</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a href="<?= base_url("index.php/Compliance/complianceRequirementForm/{$compliance_requirement['id']}") ?>" class="btn btn-secondary btn-sm" <?= MODAL_LINK ?>><i class="icon icon-pencil"></i> Edit</a>
                            <?php endif; ?>
                        </div>
                        <h4 class="card-title"> 
                            <?= $compliance_requirement['title'] ?>
                            <br>
                            <small style="font-size: 12px;">
                                <i class="fa fa-angle-double-right"></i> Compliance Requirement 
                                <i class="fa fa-angle-double-right"></i> <?= $compliance_requirement['type'] ?> 
                                <i class="fa fa-angle-double-right"></i> Version <?= $compliance_requirement['version']['version'] ?>

                            </small>
                        </h4> 
                    </div>
                </div>
                <hr class="row"/>
                <div class="row" id="cr_details">

                    <div class="row">
                        <?php // print_pre($compliance_requirement);?>
                        <div class="col-sm-5">
                            <dl class='dl-horizontal row' id="compliance_req">

                                <dt class='col-sm-3'> Title </dt>
                                <dd class='col-sm-9'> <?= $compliance_requirement['title'] ?> </dd>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Short Code </dt>
                                <dd class='col-sm-9'> <?= $compliance_requirement['short_code'] ?> </dd>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Repository </dt>
                                <dd class='col-sm-9'> <?= ucwords(str_replace("_", " ", $compliance_requirement['repository']['source'])); ?> </dd> 
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Source Document </dt>
                                <dd class='col-sm-9'> 
                                    <a <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryPreview/{$compliance_requirement['repository']['id']}") ?>">
                                        <?= $compliance_requirement['repository']['name'] ?>
                                    </a>
                                </dd> 
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Compliance Requirement Type </dt>
                                <dd class='col-sm-9'> <?= $compliance_requirement['type'] ?> </dd> 
                                <div class="clearfix"></div>

                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Environment </dt>
                                <dd class='col-sm-9'> <a href="<?= base_url("index.php/Home/dashboard/{$compliance_requirement['environment']['id']}") ?>"><?= $compliance_requirement['environment']['name'] ?></a> </dd>
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Priority Level </dt>
                                <dd class='col-sm-9'> <?= $compliance_requirement['priority'] ?> </dd>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Effective Date </dt>
                                <dd class='col-sm-9'> <?= strftime('%m/%d/%Y', strtotime($compliance_requirement['effective_date'])) ?> </dd>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Primary Owner </dt>
                                <dd class='col-sm-9'>  <i class="icon icon-user"></i> <a href="<?= base_url("index.php/Users/{$compliance_requirement['owner_0']['id']}") ?>"><?= $compliance_requirement['owner_0']['names'] ?> </a></dd>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Secondary Owner </dt>
                                <dd class='col-sm-9'>  <i class="icon icon-user"></i>  <a href="<?= base_url("index.php/Users/{$compliance_requirement['owner_1']['id']}") ?>"><?= $compliance_requirement['owner_1']['names'] ?> </a></dd>
                                <div class="clearfix"></div>
                                <dt class='col-sm-3'> Tertiary Owner </dt>
                                <dd class='col-sm-9'>  <i class="icon icon-user"></i>  <a href="<?= base_url("index.php/Users/{$compliance_requirement['owner_2']['id']}") ?>"><?= $compliance_requirement['owner_2']['names'] ?> </a></dd>
                                <div class="clearfix"></div>

                            </dl>
                        </div>
                        <div class="col-sm-7">
                            <h5>Summary</h5>
                            <?= $compliance_requirement['summary'] ?> 
                            <h5>List of Documents</h5>
                            <?= show_documents("Compliance", "compliance_requirement", $compliance_requirement['id']) ?>
                        </div>

                        <div class="col-sm-4 hidden">
                            <?php // print_pre($data);  ?>
                            <?php
                            $chart_id = "chart_name_variable_rules";
                            $chart_data = array(
                                array("name" => "Complete", "value" => $data['compliance_requirement']['completion'], "color" => "#55aa55"),
                                array("name" => "Incomplete", "value" => (100 - $data['compliance_requirement']['completion']), "color" => "#aa5555"),
                            );
                            ?>
                            <?= null; //pie_chart_cs($chart_id, $data) ?>

                            <?= NULL; //  pie_chart_cs("completion_chart", $chart_data, 400) ?>
                        </div>

                    </div>
                </div>
                <div class="text-center ">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block">
                <?php
                $add_obligation_link = base_url("index.php/Compliance/obligationForm/0/{$compliance_requirement['id']}");
                ?>
                <?php if (am_user_type(array(1, 5, 6, 10))): ?>
                    <a href="<?= $add_obligation_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small pull-right"><i class="icon icon-plus"></i> New Obligation</a>
                <?php endif; ?>
                <h4 class="card-title ">Obligations </h4>

                <table id="datatable-buttons" class=" table table-striped  table-small table-sm">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Approval Status</th>
                            <th>Authority</th>
                            <th>Primary Owner</th>
                            <th class="text-center"> Current Status </th>

                            <th  class="text-center">Next Submission </th>
                            <th class="text-center"> Comments </th>

                            <th style="width: 200px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($data['obligations'] as $key => $value):
                            $status2_label = $value['status'] == "active" ? "success" : "danger";
                            $approved_label = ($value['approved'] == "approved") ? "success" : (($value['approved'] == "pending") ? "warning" : "danger");
                            ?>
                            <tr id="obligation-<?= $value['id'] ?>">
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <a href="<?= base_url("index.php/Compliance/obligationPreview/{$value['id']}"); ?>" <?= MODAL_LINK ?>><i class="icon icon-share-alt"></i></a>
                                    <a href="<?= base_url("index.php/Compliance/obligation/{$value['id']}"); ?>"><?= $value['title'] ?></a>
                                </td>
                                <td>
                                    <span class="label label-pill label-<?= $status2_label ?>">
                                        <?= ucwords($value['status']) ?>
                                    </span></td>
                                <td>
                                    <span class="label label-pill label-<?= $approved_label ?>">
                                        <?= ucwords($value['approved']) ?>
                                    </span></td>
                                <td><a href="<?= base_url("index.php/Compliance/authority/{$value['authority']['id']}"); ?>" <?= MODAL_LINK ?>><?= $value['authority']['title'] ?></a></td>
                                <td><?= $value['responsible_manager_1']['names'] ?></td>
                                <td class="text-center">
                                    <span class="label label-pill label-<?=
                                    ($value['last_submission_status'] == "complied" or $value['last_submission_status'] == 'fully' or $value['last_submission_status'] == 'yes' ) ?
                                            "success" : ($value['last_submission_status'] == "partially") ? "warning" : "danger"
                                    ?>">

                                        <?= ucwords(str_replace("_", " ", $value['last_submission_status'])) ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-<?= strtotime($value['submission_deadline']) > time() ? "default" : "danger" ?>">
                                        <?= strftime(" %b %d %Y", strtotime($value['submission_deadline'])); ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="<?= base_url("index.php/Comments/PopupDisplay/compliance/obligation/{$value['id']}"); ?>">
                                        <i class="icon icon-bubbles"></i> <?= count_comments("compliance", "obligations", $value['id']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group pull-right">


                                        <?php if (am_user_type(array(1, 5)) and ( $value['pending_breaches'] > 0 or $value['pending_compliants'] > 0)) : ?>
                                            <a href="<?= base_url("index.php/Compliance/ObligationBulkActionApprove/{$value['id']}") ?>" 
                                            <?= MODAL_LINK ?>
                                               class="btn btn-danger btn-sm btn-small">
                                                <i class="icon icon-check"></i> Required Action
                                            </a>
                                        <?php endif; ?>


                                        <?php if (am_user_type(array(1, 5, 7)) and ( time() + (3600 * 24 * 7) ) > strtotime($value['notification_date'])): ?>
                                            <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$value['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-success btn-sm"><i class="icon icon-check"></i> Have you complied? </a>
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
<script>
    $('.cr_details_toggle').click(function (parameters) {
        $('#cr_details').slideToggle('fast');
        $('.cr_details_toggle').toggleClass('hidden');
    });
    $(document).ready(function () {
        $('#cr_details').hide(0);
    });

    var resizefunc = [];
    $('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],

    });

    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');


</script>