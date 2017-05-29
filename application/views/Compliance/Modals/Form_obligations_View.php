  <!-- <?php
 $obligations = $data['obligations'];
    ?>
      -->       

<?= form_open_multipart("",array('id'=>'','class'=>''))?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Obligations </h4>
        </div>
        <div class='modal-body'>
		<input type='hidden' class='form-control'  name='id' id='txt-obligations-id' value='<?= $obligations['id']?>' />
				<div class='form-group row'>
<label  for="txt-obligations-user"  class='col-sm-2 form-control-label'>User</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='user' id='txt-obligations-user' value='<?= $obligations['user']?>' placeholder='user' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-type"  class='col-sm-2 form-control-label'>Type</label>
<div class='col-sm-10'>
<select  class='form-control'name='type' id='txt-obligations-type'> 
 <option value='Statutory Return' <?= $obligations['type'] == 'Statutory Return' ? "selected='selected'" : NULL; ?> > Statutory Return </option>
<option value='Regulatory Guidelines' <?= $obligations['type'] == 'Regulatory Guidelines' ? "selected='selected'" : NULL; ?> > Regulatory Guidelines </option>
<option value='Internal Guidelines' <?= $obligations['type'] == 'Internal Guidelines' ? "selected='selected'" : NULL; ?> > Internal Guidelines </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='ref_code' id='txt-obligations-ref_code' value='<?= $obligations['ref_code']?>' placeholder='ref_code' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-short_code"  class='col-sm-2 form-control-label'>Short Code</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='short_code' id='txt-obligations-short_code' value='<?= $obligations['short_code']?>' placeholder='short_code' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-compliance_requirement"  class='col-sm-2 form-control-label'>Compliance Requirement</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='compliance_requirement' id='txt-obligations-compliance_requirement' value='<?= $obligations['compliance_requirement']?>' placeholder='compliance_requirement' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-authority"  class='col-sm-2 form-control-label'>Authority</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='authority' id='txt-obligations-authority' value='<?= $obligations['authority']?>' placeholder='authority' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-title"  class='col-sm-2 form-control-label'>Title</label>
<div class='col-sm-10'>
<input type='text' class='form-control'   name='title'  required=''  id='txt-obligations-title' value='<?= $obligations['title']?>' placeholder='title' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-description"  class='col-sm-2 form-control-label'>Description</label>
<div class='col-sm-10'>
<textarea class='form-control wysiwyg'  name='description' id='txt-obligations-description' placeholder='description' ><?= $obligations['description']?></textarea>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-responsible_manager_1"  class='col-sm-2 form-control-label'>Responsible Manager 1</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='responsible_manager_1' id='txt-obligations-responsible_manager_1' value='<?= $obligations['responsible_manager_1']?>' placeholder='responsible_manager_1' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-responsible_manager_2"  class='col-sm-2 form-control-label'>Responsible Manager 2</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='responsible_manager_2' id='txt-obligations-responsible_manager_2' value='<?= $obligations['responsible_manager_2']?>' placeholder='responsible_manager_2' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-repeat"  class='col-sm-2 form-control-label'>Repeat</label>
<div class='col-sm-10'>
<select  class='form-control'name='repeat' id='txt-obligations-repeat'> 
 <option value='one off' <?= $obligations['repeat'] == 'one off' ? "selected='selected'" : NULL; ?> > One Off </option>
<option value='continuous' <?= $obligations['repeat'] == 'continuous' ? "selected='selected'" : NULL; ?> > Continuous </option>
<option value='periodic' <?= $obligations['repeat'] == 'periodic' ? "selected='selected'" : NULL; ?> > Periodic </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-frequency"  class='col-sm-2 form-control-label'>Frequency</label>
<div class='col-sm-10'>
<select  class='form-control'name='frequency' id='txt-obligations-frequency'> 
 <option value='annually' <?= $obligations['frequency'] == 'annually' ? "selected='selected'" : NULL; ?> > Annually </option>
<option value='semi annually' <?= $obligations['frequency'] == 'semi annually' ? "selected='selected'" : NULL; ?> > Semi Annually </option>
<option value='quarterly' <?= $obligations['frequency'] == 'quarterly' ? "selected='selected'" : NULL; ?> > Quarterly </option>
<option value='monthly' <?= $obligations['frequency'] == 'monthly' ? "selected='selected'" : NULL; ?> > Monthly </option>
<option value='weekly' <?= $obligations['frequency'] == 'weekly' ? "selected='selected'" : NULL; ?> > Weekly </option>
<option value='daily' <?= $obligations['frequency'] == 'daily' ? "selected='selected'" : NULL; ?> > Daily </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-next_review"  class='col-sm-2 form-control-label'>Next Review</label>
<div class='col-sm-10'>
<input type='date' class='form-control'  name='next_review' id='txt-obligations-next_review' value='<?= $obligations['next_review']?>' placeholder='next_review' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-submission_deadline"  class='col-sm-2 form-control-label'>Submission Deadline</label>
<div class='col-sm-10'>
<input type='date' class='form-control'  name='submission_deadline' id='txt-obligations-submission_deadline' value='<?= $obligations['submission_deadline']?>' placeholder='submission_deadline' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-notification_date"  class='col-sm-2 form-control-label'>Notification Date</label>
<div class='col-sm-10'>
<input type='date' class='form-control'  name='notification_date' id='txt-obligations-notification_date' value='<?= $obligations['notification_date']?>' placeholder='notification_date' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-escalation_person"  class='col-sm-2 form-control-label'>Escalation Person</label>
<div class='col-sm-10'>
<select  class='form-control'name='activity' id='txt-obligations-activity'> 
 <option value='document submission' <?= $obligations['activity'] == 'document submission' ? "selected='selected'" : NULL; ?> > Document Submission </option>
<option value='web entry' <?= $obligations['activity'] == 'web entry' ? "selected='selected'" : NULL; ?> > Web Entry </option>
<option value='audit pass' <?= $obligations['activity'] == 'audit pass' ? "selected='selected'" : NULL; ?> > Audit Pass </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-activity"  class='col-sm-2 form-control-label'>Activity</label>
<div class='col-sm-10'>
<select  class='form-control'name='activity' id='txt-obligations-activity'> 
 <option value='document submission' <?= $obligations['activity'] == 'document submission' ? "selected='selected'" : NULL; ?> > Document Submission </option>
<option value='web entry' <?= $obligations['activity'] == 'web entry' ? "selected='selected'" : NULL; ?> > Web Entry </option>
<option value='audit pass' <?= $obligations['activity'] == 'audit pass' ? "selected='selected'" : NULL; ?> > Audit Pass </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-document_name"  class='col-sm-2 form-control-label'>Document Name</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='document_name' id='txt-obligations-document_name' value='<?= $obligations['document_name']?>' placeholder='document_name' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-person_name"  class='col-sm-2 form-control-label'>Person Name</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='person_name' id='txt-obligations-person_name' value='<?= $obligations['person_name']?>' placeholder='person_name' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-person_phone"  class='col-sm-2 form-control-label'>Person Phone</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='person_phone' id='txt-obligations-person_phone' value='<?= $obligations['person_phone']?>' placeholder='person_phone' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-person_address"  class='col-sm-2 form-control-label'>Person Address</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='person_address' id='txt-obligations-person_address' value='<?= $obligations['person_address']?>' placeholder='person_address' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-person_email"  class='col-sm-2 form-control-label'>Person Email</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='person_email' id='txt-obligations-person_email' value='<?= $obligations['person_email']?>' placeholder='person_email' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-url"  class='col-sm-2 form-control-label'>Url</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='url' id='txt-obligations-url' value='<?= $obligations['url']?>' placeholder='url' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-priority"  class='col-sm-2 form-control-label'>Priority</label>
<div class='col-sm-10'>
<select  class='form-control'name='priority' id='txt-obligations-priority'> 
 <option value='high' <?= $obligations['priority'] == 'high' ? "selected='selected'" : NULL; ?> > High </option>
<option value='medium' <?= $obligations['priority'] == 'medium' ? "selected='selected'" : NULL; ?> > Medium </option>
<option value='low' <?= $obligations['priority'] == 'low' ? "selected='selected'" : NULL; ?> > Low </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-late_submission_consequence"  class='col-sm-2 form-control-label'>Late Submission Consequence</label>
<div class='col-sm-10'>
<textarea class='form-control wysiwyg'  name='late_submission_consequence' id='txt-obligations-late_submission_consequence' placeholder='late_submission_consequence' ><?= $obligations['late_submission_consequence']?></textarea>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-late_submission_penalty"  class='col-sm-2 form-control-label'>Late Submission Penalty</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='late_submission_penalty' id='txt-obligations-late_submission_penalty' value='<?= $obligations['late_submission_penalty']?>' placeholder='late_submission_penalty' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-none_submission_consequence"  class='col-sm-2 form-control-label'>None Submission Consequence</label>
<div class='col-sm-10'>
<textarea class='form-control wysiwyg'  name='none_submission_consequence' id='txt-obligations-none_submission_consequence' placeholder='none_submission_consequence' ><?= $obligations['none_submission_consequence']?></textarea>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-none_submission_penalty"  class='col-sm-2 form-control-label'>None Submission Penalty</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='none_submission_penalty' id='txt-obligations-none_submission_penalty' value='<?= $obligations['none_submission_penalty']?>' placeholder='none_submission_penalty' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-noncompliance_consequence"  class='col-sm-2 form-control-label'>Noncompliance Consequence</label>
<div class='col-sm-10'>
<textarea class='form-control wysiwyg'  name='noncompliance_consequence' id='txt-obligations-noncompliance_consequence' placeholder='noncompliance_consequence' ><?= $obligations['noncompliance_consequence']?></textarea>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-noncompliance_penalty"  class='col-sm-2 form-control-label'>Noncompliance Penalty</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='noncompliance_penalty' id='txt-obligations-noncompliance_penalty' value='<?= $obligations['noncompliance_penalty']?>' placeholder='noncompliance_penalty' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-created"  class='col-sm-2 form-control-label'>Created</label>
<div class='col-sm-10'>
<input type='date' class='form-control'  name='created' id='txt-obligations-created' value='<?= $obligations['created']?>' placeholder='created' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-approved"  class='col-sm-2 form-control-label'>Approved</label>
<div class='col-sm-10'>
<select  class='form-control'name='approved' id='txt-obligations-approved'> 
 <option value='pending' <?= $obligations['approved'] == 'pending' ? "selected='selected'" : NULL; ?> > Pending </option>
<option value='approved' <?= $obligations['approved'] == 'approved' ? "selected='selected'" : NULL; ?> > Approved </option>
<option value='rejected' <?= $obligations['approved'] == 'rejected' ? "selected='selected'" : NULL; ?> > Rejected </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-compliance_state"  class='col-sm-2 form-control-label'>Compliance State</label>
<div class='col-sm-10'>
<select  class='form-control'name='compliance_state' id='txt-obligations-compliance_state'> 
 <option value='active' <?= $obligations['compliance_state'] == 'active' ? "selected='selected'" : NULL; ?> > Active </option>
<option value='inactive' <?= $obligations['compliance_state'] == 'inactive' ? "selected='selected'" : NULL; ?> > Inactive </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-complied"  class='col-sm-2 form-control-label'>Complied</label>
<div class='col-sm-10'>
<select  class='form-control'name='complied' id='txt-obligations-complied'> 
 <option value='pending' <?= $obligations['complied'] == 'pending' ? "selected='selected'" : NULL; ?> > Pending </option>
<option value='yes' <?= $obligations['complied'] == 'yes' ? "selected='selected'" : NULL; ?> > Yes </option>
<option value='no' <?= $obligations['complied'] == 'no' ? "selected='selected'" : NULL; ?> > No </option>
</select>
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-draft"  class='col-sm-2 form-control-label'>Draft</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='draft' id='txt-obligations-draft' value='<?= $obligations['draft']?>' placeholder='draft' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-obligations-delete"  class='col-sm-2 form-control-label'>Delete</label>
<div class='col-sm-10'>
</div>
</div>


			
            </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>