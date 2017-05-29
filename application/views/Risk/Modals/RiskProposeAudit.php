<?= form_open_multipart("Risk/riskProposeAuditPost", array('id' => 'Risk_prop_audit', 'class' => '')) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header bg-faded'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Propose Risk </h4>
        </div>
        <div class='modal-body' >
            <?php // print_pre($data);?>

            <?php if (count($data['category']) == 0): ?>
                <div class="alert alert-danger">
                    <h4>No Category Selected</h4>
                    <p>Please select a category in order to propose a risk</p>
                </div>
            <?php else: ?>
                <input type='hidden' class='form-control' name='audit'  id='txt-issue' value='<?= $data['audit'] ?>' />
                <input type='hidden' class='form-control' name='issue'  id='txt-issue' value='<?= $data['issue'] ?>' />
                <input type='hidden' class='form-control' name='category'  required='' id='txt-risk-category' value='<?= $data['category']['id'] ?>' placeholder='title' />
                <div class='form-group row'>
                    <label  for="txt-risk-title"  class='col-sm-3 form-control-label'>Risk Title</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control' name='title'  required='' id='txt-risk-title' value='' placeholder='title' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk-description"  class='col-sm-3 form-control-label'>Description</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control wysiwyg' rows="5" name='description' id='txt-risk-description' placeholder='description' ></textarea>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class='modal-footer'>


            <?php if (count($data['category']) == 0): ?>
            <?php else: ?>
                <div class="btn-group">
                    <button type='button' class='btn btn-secondary waves-effect' id="dismiss_modal" data-dismiss="modal">Cancel</button>
                    <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div><!-- /.modal-content -->
<?= form_close(); ?>

