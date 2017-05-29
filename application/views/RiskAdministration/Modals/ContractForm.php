<?php
$contract = $data['repository'][$data['repository']['source']]
?>
<?= form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => '')) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Contract </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-contract-id' value='<?= $contract['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-contract-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-contract-ref_code' value='<?= $contract['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  required=""  name='name'  required=''  id='txt-contract-name' value='<?= $contract['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-contract-description' placeholder='description' ><?= $contract['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-effective_date"  class='col-sm-2 form-control-label'>Effective Date</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-expiry_date"  class='col-sm-2 form-control-label'>Expiry Date</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-link"  class='col-sm-2 form-control-label'>Link</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='link' id='txt-contract-link' value='<?= $contract['link'] ?>' placeholder='link' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' required="" id='txt-contract-type'> 
                        <option value="">SELECT</option>
                        <option value='Perpetual' <?= $contract['type'] == 'Perpetual' ? "selected='selected'" : NULL; ?> > Perpetual </option>
                        <option value='Periodic' <?= $contract['type'] == 'Periodic' ? "selected='selected'" : NULL; ?> > Periodic </option>
                        <option value='Rolling' <?= $contract['type'] == 'Rolling' ? "selected='selected'" : NULL; ?> > Rolling </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-contract_owner"  class='col-sm-2 form-control-label'>Contract Owner</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='contract_owner' id='txt-contract-contract_owner' value='<?= $contract['contract_owner'] ?>' placeholder='contract_owner' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-signed_by"  class='col-sm-2 form-control-label'>Signed By</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='signed_by' id='txt-contract-signed_by' value='<?= $contract['signed_by'] ?>' placeholder='signed_by' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='status' required id='txt-contract-status'> 
                        <option value="">SELECT</option>
                        <option value='Expired' <?= $contract['status'] == 'Expired' ? "selected='selected'" : NULL; ?> > Expired </option>
                        <option value='Closed' <?= $contract['status'] == 'Closed' ? "selected='selected'" : NULL; ?> > Closed </option>
                        <option value='Active' <?= $contract['status'] == 'Active' ? "selected='selected'" : NULL; ?> > Active </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-attachment"  class='col-sm-2 form-control-label'>Attachment</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='attachment' id='txt-contract-attachment' value='<?= $contract['attachment'] ?>' placeholder='attachment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-environment"  class='col-sm-2 form-control-label'>Environment</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='environment' id='txt-contract-environment' value='<?= $contract['environment'] ?>' placeholder='environment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-approved"  class='col-sm-2 form-control-label'>Approved</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-kra_clipboard"  class='col-sm-2 form-control-label'>Kra Clipboard</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='kra_clipboard' id='txt-contract-kra_clipboard' value='<?= $contract['kra_clipboard'] ?>' placeholder='kra_clipboard' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-contract-created' value='<?= $contract['created'] ?>' placeholder='created' />
                </div>
            </div>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

