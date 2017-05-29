<?php
$action_plans = $data['action_plans'];
$issue = $data['issue'];
?>
<?= form_open_multipart("Audit/ActionPlanPost", array('id' => 'frm_actionplan_form', 'class' => 'form-vertical')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-issue-id' value='<?= $action_plans['id'] ?>' />

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Management Action Plan </h4>
        </div>
        <div class="clearfix"></div>
        <div class='modal-body'>
            <div class="row">
                <input type='hidden' class='form-control'  name='issue' id='txt-recommendation-id' value='<?= $issue['id'] ?>' />
                <div class="alert alert-danger hidden" id="js_response"></div>
                <div class="col-sm-12">
                    <div class='form-group'>
                        <label  for="txt-issue-title"  class='col-sm-12 form-control-label'>Title</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'   name='action_plan'  required=''  id='txt-issue-title' value='<?= $action_plans['action_plan'] ?>' placeholder='Title' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-description"  class='col-sm-12 form-control-label'>Description</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control'   name='description'  required=''  id='txt-issue-description'><?= $action_plans['description'] ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group col-sm-4'>
                            <label  for="txt-issue-plan_owner"  class='col-sm-12 form-control-label'>Action Plan Owner</label>
                            <div class='col-sm-12'>
                                <select disabled class='form-control' name='action_plan_owner' required  onchange="draftSystem();"  id='txt-issue-plan_owner'> 
                                        <option value=''>SELECT</option>
                                        <?php
                                        foreach ($data['unit_owners'] as $key => $value):
                                            $select = $value['id'] == $action_plans['action_plan_owner'] ? "selected='selected'" : NULL;
                                            ?>   
                                            <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['names'] ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div class='form-group col-sm-4'>
                            <label  for="txt-issue-action_by_date"  class='col-sm-12 form-control-label'>Action By Date</label>
                            <div class='col-sm-12'>
                                <input type='date' class='form-control'   name='action_by_date'  id='txt-issue-action_by_date' 
                                       value='<?= strftime("%Y-%m-%d", strtotime($action_plans['action_by_date'])) ?>' />
                            </div>
                        </div>

                        <div class='form-group col-sm-4'>
                            <label  for="txt-issue-assigned_to"  class='col-sm-12 form-control-label'>Assigned_to</label>
                            <div class='col-sm-12'>
                                <input type='text' class='form-control' required name='assigned_to' id='txt-issue-assigned_to' value='<?= $action_plans['assigned_to'] ?>' placeholder='user@email.com' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group col-sm-6'>
                            <label  for="txt-issue-review_date"  class='col-sm-12 form-control-label'>Review Date</label>
                            <div class='col-sm-12'>
                                <input type='date' class='form-control'     
                                       name='review_date'   id='txt-issue-review_date' 
                                       value='<?= strftime("%Y-%m-%d", strtotime($action_plans['review_date'])) ?>' />
                            </div>
                        </div>
                        <div class='form-group col-sm-6'>
                            <label  for="txt-issue-active_status"  class='col-sm-12 form-control-label'>Status of Action plan</label>
                            <div class='col-sm-12'>
                                <select <?= $action_plans['draft'] != 0 ? "disabled" : "" ?> class='form-control' required=""  name='active_status' id='txt-issue-active_status'>
                                    <option value=''>SELECT</option>
                                    <option <?= $action_plans['active_status'] == 'Active' ? "selected='selected'" : NULL; ?> value='Active'>Active</option>
                                    <option <?= $action_plans['active_status'] == 'Not Adopted' ? "selected='selected'" : NULL; ?> value='Not Adopted'>Not Adopted</option>
                                    <option <?= $action_plans['active_status'] == 'Superceded' ? "selected='selected'" : NULL; ?> value='Superceded'>Superceded</option>
                                </select>
                            </div>
                        </div> 
                    </div>


                </div>
            </div>
            <div class="clearfix"></div>
            <?= files_upload("audit", "management_action_plan", $action_plans['id']); ?>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Cancel</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save Changes</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    CKEDITOR.replace('txt-issue-description');
</script>
<?= form_close(); ?>