


<?= form_open_multipart("", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Complaince Register </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-complaince_register-id' value='<?= $complaince_register['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-complaince_register-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-complaince_register-ref_code' value='<?= $complaince_register['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-category"  class='col-sm-2 form-control-label'>Category</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='category' id='txt-complaince_register-category' value='<?= $complaince_register['category'] ?>' placeholder='category' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-owner"  class='col-sm-2 form-control-label'>Owner</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='owner' id='txt-complaince_register-owner' value='<?= $complaince_register['owner'] ?>' placeholder='owner' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-summary"  class='col-sm-2 form-control-label'>Summary</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='summary' id='txt-complaince_register-summary' placeholder='summary' ><?= $complaince_register['summary'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='type' id='txt-complaince_register-type' value='<?= $complaince_register['type'] ?>' placeholder='type' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-last_action"  class='col-sm-2 form-control-label'>Last Action</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='last_action' id='txt-complaince_register-last_action' value='<?= $complaince_register['last_action'] ?>' placeholder='last_action' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-last_action_date"  class='col-sm-2 form-control-label'>Last Action Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='last_action_date' id='txt-complaince_register-last_action_date' value='<?= $complaince_register['last_action_date'] ?>' placeholder='last_action_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-complaince_register-title' value='<?= $complaince_register['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-attachments"  class='col-sm-2 form-control-label'>Attachments</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='attachments' id='txt-complaince_register-attachments' placeholder='attachments' ><?= $complaince_register['attachments'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='status' id='txt-complaince_register-status' value='<?= $complaince_register['status'] ?>' placeholder='status' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-approve"  class='col-sm-2 form-control-label'>Approve</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-draft"  class='col-sm-2 form-control-label'>Draft</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='draft' id='txt-complaince_register-draft' value='<?= $complaince_register['draft'] ?>' placeholder='draft' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-delete"  class='col-sm-2 form-control-label'>Delete</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='delete' id='txt-complaince_register-delete' value='<?= $complaince_register['delete'] ?>' placeholder='delete' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-user"  class='col-sm-2 form-control-label'>User</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='user' id='txt-complaince_register-user' value='<?= $complaince_register['user'] ?>' placeholder='user' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-complaince_register-timestamp"  class='col-sm-2 form-control-label'>Timestamp</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='timestamp' id='txt-complaince_register-timestamp' value='<?= $complaince_register['timestamp'] ?>' placeholder='timestamp' />
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>