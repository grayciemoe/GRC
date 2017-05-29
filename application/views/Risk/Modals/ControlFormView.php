


<?= form_open_multipart("", array('id' => '', 'class' => '')) ?>

<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> control </h4>
        </div>
        <div class="modal-body">




            <input type='hidden' class='form-control'  name='id' id='txt-control-id' value='<?= $control['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-control-user"  class='col-sm-2 form-control-label'>User</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='user' id='txt-control-user' value='<?= $control['user'] ?>' placeholder='user' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-owner"  class='col-sm-2 form-control-label'> Control Owner</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='owner' id='txt-control-owner' value='<?= $control['owner'] ?>' placeholder='owner' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-risk"  class='col-sm-2 form-control-label'>Risk</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='risk' id='txt-control-risk' value='<?= $control['risk'] ?>' placeholder='risk' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-control-ref_code' value='<?= $control['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-control-title' value='<?= $control['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-intention"  class='col-sm-2 form-control-label'>Intention</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='intention' id='txt-control-intention'> 
                        <option value='detect' <?= $control['intention'] == 'detect' ? "selected='selected'" : NULL; ?> > Detect </option>
                        <option value='prevent' <?= $control['intention'] == 'prevent' ? "selected='selected'" : NULL; ?> > Prevent </option>
                        <option value='correct' <?= $control['intention'] == 'correct' ? "selected='selected'" : NULL; ?> > Correct </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-control-description' placeholder='description' ><?= $control['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' id='txt-control-type'> 
                        <option value='proposed' <?= $control['type'] == 'proposed' ? "selected='selected'" : NULL; ?> > Proposed </option>
                        <option value='in place' <?= $control['type'] == 'in place' ? "selected='selected'" : NULL; ?> > In Place </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='status' id='txt-control-status'> 
                        <option value='' <?= $control['status'] == '' ? "selected='selected'" : NULL; ?> > SELECT  </option>
                        <option value='active' <?= $control['status'] == 'active' ? "selected='selected'" : NULL; ?> > Active </option>
                        <option value='inactive' <?= $control['status'] == 'inactive' ? "selected='selected'" : NULL; ?> > Inactive </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-approval_status"  class='col-sm-2 form-control-label'>Approval Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='approval_status' id='txt-control-approval_status'> 
                        <option value='' <?= $control['approval_status'] == '' ? "selected='selected'" : NULL; ?> > SELECT </option>
                        <option value='approved' <?= $control['approval_status'] == 'approved' ? "selected='selected'" : NULL; ?> > Approved </option>
                        <option value='rejected' <?= $control['approval_status'] == 'rejected' ? "selected='selected'" : NULL; ?> > Rejected </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-state"  class='col-sm-2 form-control-label'>State</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='state' id='txt-control-state'> 
                        
                        <option value='sufficient' <?= $control['state'] == 'sufficient' ? "selected='selected'" : NULL; ?> > Sufficient </option>
                        <option value='not sufficient' <?= $control['state'] == 'not sufficient' ? "selected='selected'" : NULL; ?> > Not Sufficient </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-category"  class='col-sm-2 form-control-label'>Category</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='category' required="" id='txt-control-category'> 
                        <option value="">SELECT</option>
                        <option value='IT' <?= $control['category'] == 'IT' ? "selected='selected'" : NULL; ?> > IT </option>
                        <option value='Financial' <?= $control['category'] == 'Financial' ? "selected='selected'" : NULL; ?> > Financial </option>
                        <option value='Supervision' <?= $control['category'] == 'Supervision' ? "selected='selected'" : NULL; ?> > Supervision </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-control_categories"  class='col-sm-2 form-control-label'>Control Categories</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='control_categories' id='txt-control-control_categories' value='<?= $control['control_categories'] ?>' placeholder='control_categories' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-criticality"  class='col-sm-2 form-control-label'>Criticality</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='criticality' id='txt-control-criticality'> 
                        
                        <option value='high' <?= $control['criticality'] == 'high' ? "selected='selected'" : NULL; ?> > High </option>
                        <option value='medium' <?= $control['criticality'] == 'medium' ? "selected='selected'" : NULL; ?> > Medium </option>
                        <option value='low' <?= $control['criticality'] == 'low' ? "selected='selected'" : NULL; ?> > Low </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-control-created' value='<?= $control['created'] ?>' placeholder='created' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-modified"  class='col-sm-2 form-control-label'>Modified</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='modified' id='txt-control-modified' value='<?= $control['modified'] ?>' placeholder='modified' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-status_update"  class='col-sm-2 form-control-label'>Status Update</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='status_update' id='txt-control-status_update' value='<?= $control['status_update'] ?>' placeholder='status_update' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-type_update"  class='col-sm-2 form-control-label'>Type Update</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='type_update' id='txt-control-type_update' value='<?= $control['type_update'] ?>' placeholder='type_update' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-state_update"  class='col-sm-2 form-control-label'>State Update</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='state_update' id='txt-control-state_update' value='<?= $control['state_update'] ?>' placeholder='state_update' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-approval_status_update"  class='col-sm-2 form-control-label'>Approval Status Update</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='approval_status_update' id='txt-control-approval_status_update' value='<?= $control['approval_status_update'] ?>' placeholder='approval_status_update' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-delete"  class='col-sm-2 form-control-label'>Delete</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-control-draft"  class='col-sm-2 form-control-label'>Draft</label>
                <div class='col-sm-10'>
                </div>
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
            <button class='btn btn-default'><i class='fa fa-save'></i> Save </button>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<?= form_close(); ?>

