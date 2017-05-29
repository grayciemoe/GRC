


<?= form_open_multipart("", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Obligation Comply </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-obligation_comply-id' value='<?= $obligation_comply['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-obligation_comply-obligations"  class='col-sm-2 form-control-label'>Obligations</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='obligations' id='txt-obligation_comply-obligations' value='<?= $obligation_comply['obligations'] ?>' placeholder='obligations' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-user"  class='col-sm-2 form-control-label'>User</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='user' id='txt-obligation_comply-user' value='<?= $obligation_comply['user'] ?>' placeholder='user' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-obligation_comply-ref_code' value='<?= $obligation_comply['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-obligation_comply-title' value='<?= $obligation_comply['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-comply"  class='col-sm-2 form-control-label'>Comply</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='comply' id='txt-obligation_comply-comply'> 
                        <option value='yes' <?= $obligation_comply['comply'] == 'yes' ? "selected='selected'" : NULL; ?> > Yes </option>
                        <option value='no' <?= $obligation_comply['comply'] == 'no' ? "selected='selected'" : NULL; ?> > No </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-obligation_comply-description' placeholder='description' ><?= $obligation_comply['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-attachments"  class='col-sm-2 form-control-label'>Attachments</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='attachments' id='txt-obligation_comply-attachments' placeholder='attachments' ><?= $obligation_comply['attachments'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-timestamp"  class='col-sm-2 form-control-label'>Timestamp</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='timestamp' id='txt-obligation_comply-timestamp' value='<?= $obligation_comply['timestamp'] ?>' placeholder='timestamp' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-submission_deadline"  class='col-sm-2 form-control-label'>Submission Deadline</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='submission_deadline' id='txt-obligation_comply-submission_deadline' value='<?= $obligation_comply['submission_deadline'] ?>' placeholder='submission_deadline' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-delete"  class='col-sm-2 form-control-label'>Delete</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='delete' id='txt-obligation_comply-delete' value='<?= $obligation_comply['delete'] ?>' placeholder='delete' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-draft"  class='col-sm-2 form-control-label'>Draft</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='draft' id='txt-obligation_comply-draft' value='<?= $obligation_comply['draft'] ?>' placeholder='draft' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-updated"  class='col-sm-2 form-control-label'>Updated</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='updated' id='txt-obligation_comply-updated' value='<?= $obligation_comply['updated'] ?>' placeholder='updated' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-obligation_frequency"  class='col-sm-2 form-control-label'>Obligation Frequency</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='obligation_frequency' id='txt-obligation_comply-obligation_frequency'> 
                        <option value='annually' <?= $obligation_comply['obligation_frequency'] == 'annually' ? "selected='selected'" : NULL; ?> > Annually </option>
                        <option value='semi annually' <?= $obligation_comply['obligation_frequency'] == 'semi annually' ? "selected='selected'" : NULL; ?> > Semi Annually </option>
                        <option value='quarterly' <?= $obligation_comply['obligation_frequency'] == 'quarterly' ? "selected='selected'" : NULL; ?> > Quarterly </option>
                        <option value='monthly' <?= $obligation_comply['obligation_frequency'] == 'monthly' ? "selected='selected'" : NULL; ?> > Monthly </option>
                        <option value='weekly' <?= $obligation_comply['obligation_frequency'] == 'weekly' ? "selected='selected'" : NULL; ?> > Weekly </option>
                        <option value='daily' <?= $obligation_comply['obligation_frequency'] == 'daily' ? "selected='selected'" : NULL; ?> > Daily </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-obligation_point"  class='col-sm-2 form-control-label'>Obligation Point</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='obligation_point' id='txt-obligation_comply-obligation_point' value='<?= $obligation_comply['obligation_point'] ?>' placeholder='obligation_point' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-year"  class='col-sm-2 form-control-label'>Year</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='year' id='txt-obligation_comply-year' value='<?= $obligation_comply['year'] ?>' placeholder='year' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-month"  class='col-sm-2 form-control-label'>Month</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='month' id='txt-obligation_comply-month' value='<?= $obligation_comply['month'] ?>' placeholder='month' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-date"  class='col-sm-2 form-control-label'>Date</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='date' id='txt-obligation_comply-date' value='<?= $obligation_comply['date'] ?>' placeholder='date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-week"  class='col-sm-2 form-control-label'>Week</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='week' id='txt-obligation_comply-week' value='<?= $obligation_comply['week'] ?>' placeholder='week' />
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>