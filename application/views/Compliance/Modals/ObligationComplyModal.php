


<?= form_open_multipart("Compliance/compliantPost", array('id' => '', 'class' => '')) ?>

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
                <label  for="txt-obligation_comply-completion"  class='col-sm-2 form-control-label'>Completion</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='completion' id='txt-obligation_comply-completion'> 
                        <option value='fully' <?= $obligation_comply['completion'] == 'fully' ? "selected='selected'" : NULL; ?> > Fully </option>
                        <option value='partially' <?= $obligation_comply['completion'] == 'partially' ? "selected='selected'" : NULL; ?> > Partially </option>
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
                <label  for="txt-obligation_comply-period_name"  class='col-sm-2 form-control-label'>Period Name</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='period_name' id='txt-obligation_comply-period_name'> 
                        <option value='Year' <?= $obligation_comply['period_name'] == 'Year' ? "selected='selected'" : NULL; ?> > Year </option>
                        <option value='Half' <?= $obligation_comply['period_name'] == 'Half' ? "selected='selected'" : NULL; ?> > Half </option>
                        <option value='Quarter' <?= $obligation_comply['period_name'] == 'Quarter' ? "selected='selected'" : NULL; ?> > Quarter </option>
                        <option value='Month' <?= $obligation_comply['period_name'] == 'Month' ? "selected='selected'" : NULL; ?> > Month </option>
                        <option value='Week' <?= $obligation_comply['period_name'] == 'Week' ? "selected='selected'" : NULL; ?> > Week </option>
                        <option value='Day' <?= $obligation_comply['period_name'] == 'Day' ? "selected='selected'" : NULL; ?> > Day </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-period_initials"  class='col-sm-2 form-control-label'>Period Initials</label>
                <div class='col-sm-10'>
                    <select  class='form-control' name='period_initials' id='txt-obligation_comply-period_initials'> 
                        <option value='Y' <?= $obligation_comply['period_initials'] == 'Y' ? "selected='selected'" : NULL; ?> > Y </option>
                        <option value='H' <?= $obligation_comply['period_initials'] == 'H' ? "selected='selected'" : NULL; ?> > H </option>
                        <option value='Q' <?= $obligation_comply['period_initials'] == 'Q' ? "selected='selected'" : NULL; ?> > Q </option>
                        <option value='M' <?= $obligation_comply['period_initials'] == 'M' ? "selected='selected'" : NULL; ?> > M </option>
                        <option value='W' <?= $obligation_comply['period_initials'] == 'W' ? "selected='selected'" : NULL; ?> > W </option>
                        <option value='D' <?= $obligation_comply['period_initials'] == 'D' ? "selected='selected'" : NULL; ?> > D </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-obligation_comply-period"  class='col-sm-2 form-control-label'>Period</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='period' id='txt-obligation_comply-period' value='<?= $obligation_comply['period'] ?>' placeholder='period' />
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



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>