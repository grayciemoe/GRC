<?php
$audit = $data['audit'];


if($audit['published_board'] == 1){
    $disabled = "disabled";
}  else {
    $disabled = "";
}
if(count($data['issues']) > 0){
    $disable_delete = "disabled";
}  else {
    $disable_delete = "";
}
?>
<?php
if ((!am_user_type(array(1, 6, 8))) && ($audit['published_board'] == 0)) {
    restricted_view();
    return false;
}
?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12col-lg-4 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <?php if($audit['published_board'] == 1 ):?>
                    <span class="label label-success">Published To Board</span>
                    <?php endif; ?>
                    <div class="btn-group pull-right">
                        <button class="btn btn-sm btn-secondary hidden audit_details_toggle" ><i class="icon icon-arrow-up"></i> Less </button>
                        <button class="btn btn-sm btn-secondary  audit_details_toggle"><i class="icon icon-arrow-down"></i> More </button>
                        <?php if (am_user_type(array(8))): ?>
                        <a href="<?= base_url('index.php/audit/auditForm/' . $audit['id'] .'/'. $audit['corporate'] .'') ?>" <?= MODAL_LINK ?>  class="btn btn-primary-outline btn-sm <?= $disabled ?>"><i  class="icon icon-pencil"></i> Edit </a>
                        <a href="<?= base_url('index.php/audit/deleteAudit/' . $audit['id'] . '') ?>" <?= MODAL_LINK ?>  class="btn btn-danger-outline btn-sm <?= $disable_delete ?> <?= $disabled ?>"><i  class="icon icon-trash"></i> Delete</a>
                        <!--<a href="<?= $report_url ?>" class="btn btn-dark-outline btn-sm" ><i  class="icon icon-doc"></i> Generate Audit Report</a>-->
                        <a href="<?= base_url('index.php/audit/AuditReportSelectIssues/' . $audit['id']) ?>" <?= MODAL_LINK ?> class="btn btn-success-outline btn-sm <?= $disabled ?>" ><i  class="icon icon-doc"></i> Select Issues for Audit Report</a>
                        <a href="<?= base_url('index.php/audit/PreviewIssueInReport/0/' . $audit['id']) ?>" class="btn btn-dark-outline btn-sm <?= $disabled ?>" id="issues-on-report" ><i  class="icon icon-doc"></i> Prepare Report</a>
                        <a class="btn btn-sm btn-info-outline dropdown-toggle waves-effect <?= $disabled ?>" data-toggle="dropdown" aria-expanded="true"> Publish Audit <span class="caret"></span> </a>
                        <div class="dropdown-menu">
                            <a href="<?= base_url('index.php/audit/publishSelected/' . $audit['id'] . '/management') ?>" <?= MODAL_LINK ?>  class="dropdown-item <?= $disabled ?>">Publish To Management </a>
                            <a href="<?= base_url('index.php/audit/publishSelected/' . $audit['id'] . '/ceo') ?>" <?= MODAL_LINK ?> class="dropdown-item <?= $disabled ?>">Publish To CEO </a>
                            <a href="<?= base_url('index.php/audit/publishAuditReportToBoard/' . $audit['id']) ?>" <?= MODAL_LINK ?> class="dropdown-item <?= $disabled ?>">Publish To Board </a>

                        </div>
                        <?php endif; ?>


                    </div>
                    <div class="col-xs-1 text-center text-muted">
                        <i class="fa fa-history fa-2x "></i>
                    </div>
                    <h5 class="card-title"><?= ucwords($audit['audit_name']) ?></h5>

                    <div class="row" id="audit_details">
                        <div class="col-sm-12">
                            <div class="col-sm-6">

                                <table class="table table-small table-sm m-t-10">

                                    <tr>
                                        <th>Audit Name</th>
                                        <td><?= ucwords($audit['audit_name']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Audit Ref</th>
                                        <td><small><?= $audit['ref_code'] ?></small></td>
                                    </tr>

                                    <tr>
                                        <th>Audit Area</th>
                                        <td>
                                            <?php foreach ($data['audit_area'] as $key => $value): ?>
                                                <?= ucwords(strtolower($value['title'])) ?><br/>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Audit Type</th>
                                        <td><?= $audit['audit_type'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Audit As At</th>
                                        <td><?= strftime("%b-%d-%Y", strtotime($audit['audit_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Business Unit(s)</th>
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
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                <h5>Attachment(s)</h5>
                                <?php if($data['me']['user']['user_type'] == 6):?>
                                <?= show_documents('audit', 'audit', $audit['id'], FALSE, FALSE, array("read" => 1, "preview" => 1, "edit" => 0, "delete" => 0)) ?>
                                <?php else: ?>
                                <?= show_documents('audit', 'audit', $audit['id'], FALSE, FALSE, array("read" => 1, "preview" => 1, "edit" => 0, "delete" => 1)) ?>
                                <?php endif;?>
                                </div>
                            <?php if($audit['published_board'] == 1):?>
                                <div class="col-sm-12">
                                <h5>Audit Report</h5>
                                <?= show_documents('audit', 'audit_report', $audit['id']) ?>
                                </div>
                            <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <?php if (am_user_type(array(8))): ?>
                    <a href="<?= base_url("index.php/Audit/IssueForm/0/{$audit['id']}") ?>"  class="btn btn-secondary btn-sm pull-right <?= $disabled ?>"><i  class="icon icon-plus"></i> New Issue </a>
                    <?php endif; ?>
                    <h5 class="card-title">Issues</h5>
                    <table id="datatable-buttons" class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Issue Title</th>
                                <th>Audit Area</th>
                                <th>Issue Rating</th>
                                <th>Issue Owner</th>
                                <th>Issue Status</th>
                                <th>Implication Type</th>
                                <th>Publishing Status</th>
                            </tr>
                        </thead>


                        <tbody>

                            <?php
                            $num = 0;
                            foreach ($data['issues'] as $key => $value) :
                                $num++;
                                ?>
                                <tr>
                                    <td><?= $num ?></td>
                                    <td><a href="<?= base_url('index.php/Audit/issue/' . $value['id'] . '') ?>"><?= ucwords($value['title']) ?></a></td>
                                    <td><?= ucwords(strtolower($value['audit_area']['title'])) ?></td>
                                    <td>
                                        <?php
                                        if ($value['issue_rating'] == 'Low') {
                                            echo '<span class="label label-pill label-primary">';
                                        } elseif ($value['issue_rating'] == 'Moderate') {
                                            echo '<span class="label label-pill label-warning">';
                                        } elseif ($value['issue_rating'] == 'High') {
                                            echo '<span class="label label-pill label-danger">';
                                        } else {
                                            echo '<span class="label label-pill label-danger">';
                                        }
                                        ?>
                                        <?= $value['issue_rating'] ?>
                                        </span>
                                    </td>
                                    <td><?= ucwords($value['issue_owner']['names']) ?></td>
    <!--                                    <td class="<?php // ((strtotime($value['action_date']) < strtotime(date('Y-m-d'))) && ($value['issue_status'] == 'Open')) ? "text-danger" : "text-success"         ?>"><?php // strftime("%b-%d-%Y", strtotime($value['action_date']))          ?></td>
                                    <td class="<?php // ((strtotime($value['review_date']) < strtotime(date('Y-m-d'))) && ($value['issue_status'] == 'Open')) ? "text-danger" : "text-success"         ?>"><?php // strftime("%b-%d-%Y", strtotime($value['review_date']))          ?></td>-->
                                   
                                    <td>
                                        <?php
                                        if ($value['issue_status'] == 'Open') {
                                            echo '<span class="label label-pill label-danger">';
                                        } elseif ($value['issue_status'] == 'Closed') {
                                            echo '<span class="label label-pill label-info">';
                                        } else {
                                            
                                        }
                                        ?>
                                        <?= $value['issue_status'] ?>
                                        </span>
                                    </td>
                                    <td><?= $value['implication_type'] ?></td>
                                    <td>
                                        <?= $value['published_management'] == "1" ? "<span class=\"label label-pill label-info\">Management</span>" : "" ?> 
                                        <?= $value['published_ceo'] == "1" ? "<span class=\"label label-pill label-primary\">CEO</span>" : "" ?>
                                        <?php if(($value['published_board'] == "1") && ($audit['published_board'] == "0")){
                                            echo "<span class=\"label label-pill label-warning\">Draft</span>";
                                        }  elseif (($value['published_board'] == "1") && ($audit['published_board'] == "1")) {
                                            echo "<span class=\"label label-pill label-success\">Board</span>";
                                        }  else {
                                            echo "";
                                        } ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>

</div>



<script type="text/javascript">
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
    $('.audit_details_toggle').click(function (parameters) {
        $('#audit_details').slideToggle('fast');
        $('.audit_details_toggle').toggleClass('hidden');
    });
    $(document).ready(function () {
        $('#audit_details').hide(0);
    });




</script>