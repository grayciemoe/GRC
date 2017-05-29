<?php
$reciepient = $data['reciepient'];
//print_pre($data); exit;
?>
<?= form_open("Audit/publishSelectedIssues", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Publish Selected Issues to <?= ($reciepient == 'ceo') ? 'CEO': ucwords($reciepient)  ?> </h4>
        </div>
        <div class="clearfix"></div>
        <div class='modal-body'>
            <?php if(empty($data['unpub_issues'])): ?>
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                <h2 class="text-center">No issues are available to publish to <?= ($reciepient == 'ceo') ? 'CEO': ucwords($reciepient)  ?></h2>
                <p class="text-center">Please check if there are issues published to <?= ($reciepient == 'ceo') ? 'CEO': ucwords($reciepient)  ?></p>
                    <?php if ($reciepient != 'management'): ?>
                    <a href="<?= base_url('index.php/audit/publishSelected/' . $data['audit']['id'].'/management') ?>" <?= MODAL_AJAX ?> class="btn btn-block btn-info-outline" ><i  class="icon icon-login"></i> Check Issues published to CEO</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" class="hidden" name="reciepient" value="<?= $reciepient ?>"/>
                    <input type="text" class="hidden" name="audit" value="<?= $data['audit']['id'] ?>"/>
                    <?php if ($reciepient == 'management'): ?>
                        <div class='form-group'>
                            <label  for="txt-audit-respond_by_date"  class='col-sm-12 form-control-label'>Respond By Date</label>
                            <div class='col-sm-12 m-b-10'>
                                <input type='date' min="<?php echo date("Y-m-d"); ?>" required class='form-control' name='respond_by_date'  id='txt-audit-respond_by_date' 
                                       value='' />
                            </div>

                        </div>
                    <?php endif; ?>
                    <?php if ($reciepient == 'ceo'): ?>
                        <div class='form-group'>
                            <label  for="txt-audit-respond_by_date"  class='col-sm-12 form-control-label'>Respond By Date <small class="text-muted">(Optional)</small></label>
                            <div class='col-sm-12 m-b-10'>
                                <input type='date' min="<?php echo date("Y-m-d"); ?>" class='form-control' name='respond_by_date'  id='txt-audit-respond_by_date' 
                                       value='' />
                            </div>

                        </div>
                    <?php endif; ?>
                    <table class="table table-striped table-sm table-small" id="datatable1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Issue Title</th>
                                <th>Issue Owner</th>
                                <th>Audit Area</th>
                                <th>Issue Rating</th>
                                <th>Issue Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['unpub_issues'] as $key => $value): 
                                if(($reciepient == 'ceo') && ($value['action_plan_required'] == 'yes') && (empty($value['issueActionPlans']))){
                                   $disable_checkbox = "disabled";
                                }  else {
                                    $disable_checkbox = "";
                                }
                                ?>
                            
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" <?= in_array($value['id'], $data['pub_issues']) ? "checked" : NULL ?> class="m-0" id="risk-<?= $value['id'] ?>" <?= $disable_checkbox ?> name="issues[]" value="<?= $value['id'] ?>">
                                    </td>
                                    <td><label  class="m-0" for="risk-<?= $value['id'] ?>"><?= $value['title'] ?></label></td>
                                    <td><?= $value['issue_owner']['names'] ?></td>
                                    <td><?= $value['audit_area']['title']?></td>
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
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>                
            </div>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' id="checkBtn" class='btn btn-secondary waves-effect' >Save</button>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= form_close(); ?>