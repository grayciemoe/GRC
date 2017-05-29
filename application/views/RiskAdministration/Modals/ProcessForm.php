<?php
$process = $data['repository'][$data['repository']['source']]
?>
<?= form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => '')) ?>


<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Process </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-process-id' value='<?= $process['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-process-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-process-ref_code' value='<?= $process['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-owner"  class='col-sm-2 form-control-label'>Owner</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='owner' id='txt-process-owner' value='<?= $process['owner'] ?>' placeholder='owner' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-process-name' value='<?= $process['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-process-description' placeholder='description' ><?= $process['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-process-created' value='<?= $process['created'] ?>' placeholder='created' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-link"  class='col-sm-2 form-control-label'>Link</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='link' id='txt-process-link' value='<?= $process['link'] ?>' placeholder='link' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='status' id='txt-process-status'> 
                        <option value='Active' <?= $process['status'] == 'Active' ? "selected='selected'" : NULL; ?> > Active </option>
                        <option value='Inactive' <?= $process['status'] == 'Inactive' ? "selected='selected'" : NULL; ?> > Inactive </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-system_involved"  class='col-sm-2 form-control-label'>System Involved</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='system_involved' id='txt-process-system_involved' value='<?= $process['system_involved'] ?>' placeholder='system_involved' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-environment"  class='col-sm-2 form-control-label'>Environment</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='environment' id='txt-process-environment' value='<?= $process['environment'] ?>' placeholder='environment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-approved"  class='col-sm-2 form-control-label'>Approved</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-kra_clipboard"  class='col-sm-2 form-control-label'>Kra Clipboard</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='kra_clipboard' id='txt-process-kra_clipboard' value='<?= $process['kra_clipboard'] ?>' placeholder='kra_clipboard' />
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

