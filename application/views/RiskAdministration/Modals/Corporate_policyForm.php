<?php
$corporate_policy = $data['repository'][$data['repository']['source']]
?>
<?= form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => '')) ?>




<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Corporate Policy </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-corporate_policy-id' value='<?= $corporate_policy['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-corporate_policy-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-corporate_policy-ref_code' value='<?= $corporate_policy['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' required="" id='txt-corporate_policy-type'> 
                        <option value="">SELECT</option>
                        <option value='Internal' <?= $corporate_policy['type'] == 'Internal' ? "selected='selected'" : NULL; ?> > Internal </option>
                        <option value='External' <?= $corporate_policy['type'] == 'External' ? "selected='selected'" : NULL; ?> > External </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-corporate_policy-name' value='<?= $corporate_policy['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-corporate_policy-description' placeholder='description' ><?= $corporate_policy['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-attachment"  class='col-sm-2 form-control-label'>Attachment</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='attachment' id='txt-corporate_policy-attachment' value='<?= $corporate_policy['attachment'] ?>' placeholder='attachment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-environment"  class='col-sm-2 form-control-label'>Environment</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='environment' id='txt-corporate_policy-environment' value='<?= $corporate_policy['environment'] ?>' placeholder='environment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-approved"  class='col-sm-2 form-control-label'>Approved</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-kra_clipboard"  class='col-sm-2 form-control-label'>Kra Clipboard</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='kra_clipboard' id='txt-corporate_policy-kra_clipboard' value='<?= $corporate_policy['kra_clipboard'] ?>' placeholder='kra_clipboard' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-corporate_policy-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-corporate_policy-created' value='<?= $corporate_policy['created'] ?>' placeholder='created' />
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

