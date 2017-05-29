<?php
$incident_management = $data['incidents'];
?>

<?= form_open_multipart("IncidentManagement/postIncident", array('id' => '', 'class' => '')) ?>
<link href="<?= base_url("assets/plugins/jquery.filer/css/jquery.filer.css") ?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />

<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $incident['draft'] == 0 ? "Edit" : "Add" ?> Incident </h4>
        </div>
        <div class="modal-body">
            <input type='hidden' class='form-control'  name='id' id='txt-incident_management-id' value='<?= $incident_management['id'] ?>' />
            <input type='hidden' class='form-control'  name='environment' id='txt-incident_management-environment' value='<?= $incident_management['environment'] ?>' placeholder='environment' />
            <div class='form-group row'>
                <label  for="txt-incident_management-compliance"  class='col-sm-2 form-control-label'>Compliance</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='compliance' id='txt-incident_management-compliance' value='<?= $incident_management['compliance'] ?>' placeholder='compliance' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-obligation"  class='col-sm-2 form-control-label'>Obligation</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='obligation' id='txt-incident_management-obligation' value='<?= $incident_management['obligation'] ?>' placeholder='obligation' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-breach"  class='col-sm-2 form-control-label'>Breach</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='breach' id='txt-incident_management-breach' value='<?= $incident_management['breach'] ?>' placeholder='breach' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-risk_level"  class='col-sm-2 form-control-label'>Risk Level</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='risk_level' id='txt-incident_management-risk_level'> 
                        <option value='breach' <?= $incident_management['risk_level'] == 'breach' ? "selected='selected'" : NULL; ?> > Breach </option>
                        <option value='Risk Category' <?= $incident_management['risk_level'] == 'Risk Category' ? "selected='selected'" : NULL; ?> > Risk Category </option>
                        <option value='Materialized Risk' <?= $incident_management['risk_level'] == 'Materialized Risk' ? "selected='selected'" : NULL; ?> > Materialized Risk </option>
                        <option value='Undefined Risk' <?= $incident_management['risk_level'] == 'Undefined Risk' ? "selected='selected'" : NULL; ?> > Undefined Risk </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-risk_category"  class='col-sm-2 form-control-label'>Risk Category</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='risk_category' id='txt-incident_management-risk_category' value='<?= $incident_management['risk_category'] ?>' placeholder='risk_category' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-undefined_risk_title"  class='col-sm-2 form-control-label'>Undefined Risk Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='undefined_risk_title' id='txt-incident_management-undefined_risk_title' value='<?= $incident_management['undefined_risk_title'] ?>' placeholder='undefined_risk_title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='status' id='txt-incident_management-status'> 
                        <option value='active' <?= $incident_management['status'] == 'active' ? "selected='selected'" : NULL; ?> > Active </option>
                        <option value='inactive' <?= $incident_management['status'] == 'inactive' ? "selected='selected'" : NULL; ?> > Inactive </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-incident_management-title' value='<?= $incident_management['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-incident_management-description' placeholder='description' ><?= $incident_management['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-incident_management-created' value='<?= $incident_management['created'] ?>' placeholder='created' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-date_of_incident"  class='col-sm-2 form-control-label'>Date Of Incident</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='date_of_incident' id='txt-incident_management-date_of_incident' value='<?= $incident_management['date_of_incident'] ?>' placeholder='date_of_incident' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-escalation_level"  class='col-sm-2 form-control-label'>Escalation Level</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='escalation_level' id='txt-incident_management-escalation_level'> 
                        <option value='Management' <?= $incident_management['escalation_level'] == 'Management' ? "selected='selected'" : NULL; ?> > Management </option>
                        <option value='CEO' <?= $incident_management['escalation_level'] == 'CEO' ? "selected='selected'" : NULL; ?> > CEO </option>
                        <option value='Board' <?= $incident_management['escalation_level'] == 'Board' ? "selected='selected'" : NULL; ?> > Board </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-responsible_manager"  class='col-sm-2 form-control-label'>Responsible Manager</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='responsible_manager' id='txt-incident_management-responsible_manager' value='<?= $incident_management['responsible_manager'] ?>' placeholder='responsible_manager' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-reported_by"  class='col-sm-2 form-control-label'>Reported By</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='reported_by' id='txt-incident_management-reported_by' value='<?= $incident_management['reported_by'] ?>' placeholder='reported_by' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-reporter_category"  class='col-sm-2 form-control-label'>Reporter Category</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='reporter_category' id='txt-incident_management-reporter_category'> 
                        <option value='Employee' <?= $incident_management['reporter_category'] == 'Employee' ? "selected='selected'" : NULL; ?> > Employee </option>
                        <option value='Agent' <?= $incident_management['reporter_category'] == 'Agent' ? "selected='selected'" : NULL; ?> > Agent </option>
                        <option value='Supplier' <?= $incident_management['reporter_category'] == 'Supplier' ? "selected='selected'" : NULL; ?> > Supplier </option>
                        <option value='Customer' <?= $incident_management['reporter_category'] == 'Customer' ? "selected='selected'" : NULL; ?> > Customer </option>
                        <option value='Public' <?= $incident_management['reporter_category'] == 'Public' ? "selected='selected'" : NULL; ?> > Public </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-incident_owner"  class='col-sm-2 form-control-label'>Incident Owner</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='incident_owner' id='txt-incident_management-incident_owner' value='<?= $incident_management['incident_owner'] ?>' placeholder='incident_owner' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-line_of_business"  class='col-sm-2 form-control-label'>Line Of Business</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='line_of_business' id='txt-incident_management-line_of_business' value='<?= $incident_management['line_of_business'] ?>' placeholder='line_of_business' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-branch"  class='col-sm-2 form-control-label'>Branch</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='branch' id='txt-incident_management-branch' value='<?= $incident_management['branch'] ?>' placeholder='branch' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-department"  class='col-sm-2 form-control-label'>Department</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='department' id='txt-incident_management-department' value='<?= $incident_management['department'] ?>' placeholder='department' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-risk_code"  class='col-sm-2 form-control-label'>Risk Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='risk_code' id='txt-incident_management-risk_code' value='<?= $incident_management['risk_code'] ?>' placeholder='risk_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-start_date"  class='col-sm-2 form-control-label'>Start Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='start_date' id='txt-incident_management-start_date' value='<?= $incident_management['start_date'] ?>' placeholder='start_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-end_date"  class='col-sm-2 form-control-label'>End Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='end_date' id='txt-incident_management-end_date' value='<?= $incident_management['end_date'] ?>' placeholder='end_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-detection_method"  class='col-sm-2 form-control-label'>Detection Method</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='detection_method' id='txt-incident_management-detection_method' value='<?= $incident_management['detection_method'] ?>' placeholder='detection_method' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-experience_type"  class='col-sm-2 form-control-label'>Experience Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='experience_type' id='txt-incident_management-experience_type'> 
                        <option value='Actual Loss' <?= $incident_management['experience_type'] == 'Actual Loss' ? "selected='selected'" : NULL; ?> > Actual Loss </option>
                        <option value='Potential Loss' <?= $incident_management['experience_type'] == 'Potential Loss' ? "selected='selected'" : NULL; ?> > Potential Loss </option>
                        <option value='Near Miss' <?= $incident_management['experience_type'] == 'Near Miss' ? "selected='selected'" : NULL; ?> > Near Miss </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-category"  class='col-sm-2 form-control-label'>Category</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='category' id='txt-incident_management-category'> 
                        <option value='Employment Practices and Safety' <?= $incident_management['category'] == 'Employment Practices and Safety' ? "selected='selected'" : NULL; ?> > Employment Practices And Safety </option>
                        <option value='Damage to Physical Assets' <?= $incident_management['category'] == 'Damage to Physical Assets' ? "selected='selected'" : NULL; ?> > Damage To Physical Assets </option>
                        <option value='Business Distruption' <?= $incident_management['category'] == 'Business Distruption' ? "selected='selected'" : NULL; ?> > Business Distruption </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-incident"  class='col-sm-2 form-control-label'>Incident</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='incident' id='txt-incident_management-incident'> 
                        <option value='open' <?= $incident_management['incident'] == 'open' ? "selected='selected'" : NULL; ?> > Open </option>
                        <option value='closed' <?= $incident_management['incident'] == 'closed' ? "selected='selected'" : NULL; ?> > Closed </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-total_cost"  class='col-sm-2 form-control-label'>Total Cost</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='total_cost' id='txt-incident_management-total_cost' value='<?= $incident_management['total_cost'] ?>' placeholder='total_cost' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-maximum_potential_loss"  class='col-sm-2 form-control-label'>Maximum Potential Loss</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='maximum_potential_loss' id='txt-incident_management-maximum_potential_loss' value='<?= $incident_management['maximum_potential_loss'] ?>' placeholder='maximum_potential_loss' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-expected_loss"  class='col-sm-2 form-control-label'>Expected Loss</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='expected_loss' id='txt-incident_management-expected_loss' value='<?= $incident_management['expected_loss'] ?>' placeholder='expected_loss' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-cause"  class='col-sm-2 form-control-label'>Cause</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='cause' id='txt-incident_management-cause' placeholder='cause' ><?= $incident_management['cause'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-cause_category"  class='col-sm-2 form-control-label'>Cause Category</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='cause_category' id='txt-incident_management-cause_category' value='<?= $incident_management['cause_category'] ?>' placeholder='cause_category' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-source"  class='col-sm-2 form-control-label'>Source</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='source' id='txt-incident_management-source'> 
                        <option value='Email' <?= $incident_management['source'] == 'Email' ? "selected='selected'" : NULL; ?> > Email </option>
                        <option value='phone' <?= $incident_management['source'] == 'phone' ? "selected='selected'" : NULL; ?> > Phone </option>
                        <option value='in person' <?= $incident_management['source'] == 'in person' ? "selected='selected'" : NULL; ?> > In Person </option>
                        <option value='Soial Media' <?= $incident_management['source'] == 'social media' ? "selected='selected'" : NULL; ?> > Social Media </option>
                        <option value=' Media' <?= $incident_management['source'] == ' media' ? "selected='selected'" : NULL; ?> >  Media </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-actions"  class='col-sm-2 form-control-label'>Actions</label>
                <div class='col-sm-10'>
                    <textarea class='form-control' id="summernote"  name='actions' id='txt-incident_management-actions' placeholder='actions' ><?= $incident_management['actions'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-action_due_date"  class='col-sm-2 form-control-label'>Action Due Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='action_due_date' id='txt-incident_management-action_due_date' value='<?= $incident_management['action_due_date'] ?>' placeholder='action_due_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_management-actions_complete"  class='col-sm-2 form-control-label'>Actions Complete</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='actions_complete' id='txt-incident_management-actions_complete'> 
                        <option value='Yes' <?= $incident_management['actions_complete'] == 'Yes' ? "selected='selected'" : NULL; ?> > Yes </option>
                        <option value='No' <?= $incident_management['actions_complete'] == 'No' ? "selected='selected'" : NULL; ?> > No </option>
                    </select>
                </div>
            </div>
        </div>
        <div class='form-group clearfix'>
            <label  for="txt-incident_management-attachments"  class='col-sm-2 form-control-label'>Attachments</label>
            <div class='col-sm-10'>
                <input type="file" name="files[]" id="incident_management-attachments" multiple="multiple">
            </div>
        </div>




    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
        <button class='btn btn-primary waves-effect waves-light'><i class='fa fa-save'></i> Save </button>

    </div>
</div><!-- /.modal-content -->
<script>
    $(document).ready(function () {
        $('#summernote').summernote();
    });


</script>


<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
<script type="text/javascript">
        $('#incident_management-attachments').filer({
            limit: 4,
            maxSize: 3,
            extensions: ['pdf', 'doc', 'xlsx', 'docx'],
            changeInput: true,
            showThumbs: true,
            addMore: true
        });
</script>

<?= form_close(); ?>
