<?php
//echo $data['repository']['source'];
$contract = $data['repository'][$data['repository']['source']];
//print_pre($contract);
?>
<?= form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => '')) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Contract </h4>
        </div>
        <div class='modal-body'>
            <?php // print_pre($data);?>
            <input type='hidden' class='form-control'  name='repository_id' id='txt-best_practices-id' value='<?= $data['repository']['id'] ?>' />

            <input type='hidden' class='form-control'  name='id' id='txt-contract-id' value='<?= $contract['id'] ?>' />

            <div class='form-group row'>
                <label  for="txt-contract-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-contract-name' value='<?= $contract['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-effective_date"  class='col-sm-2 form-control-label'>Effective Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='effective_date' id='txt-contract-effective_date' value='<?= $contract['effective_date'] ?>'  />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-contract-expiry_date"  class='col-sm-2 form-control-label'>Expiry Date</label>
                <div class='col-sm-10'>

                    <input type='date' class='form-control'  name='expiry_date' id='txt-contract-expiry_date' value='<?= $contract['expiry_date'] ?>'  />
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
                    <select  class='form-control'name='type' id='txt-contract-type'> 
                        <option value='Perpetual' <?= $contract['type'] == 'Perpetual' ? "selected='selected'" : NULL; ?> > Perpetual </option>
                        <option value='Periodic' <?= $contract['type'] == 'Periodic' ? "selected='selected'" : NULL; ?> > Periodic </option>
                        <option value='Rolling' <?= $contract['type'] == 'Rolling' ? "selected='selected'" : NULL; ?> > Rolling </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-contract_owner"  class='col-sm-2 form-control-label'>Contract Owner</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='contract_owner' id='txt-process-contract_owner'> 
                        <option value=''>SELECT</option>
                        <?php foreach ($data['owners'] as $key => $value): ?>
                            <option value='<?= $value['id'] ?>' <?= (isset($contract['contract_owner']['id']) and $contract['contract_owner']['id'] == $value['id'] ) ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-signed_by"  class='col-sm-2 form-control-label'>Signed By</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='signed_by' id='txt-process-signed_by'> 
                        <option value=''>SELECT</option>
                        <?php foreach ($data['owners'] as $key => $value): ?>
                            <option value='<?= $value['id'] ?>' <?= (isset($contract['contract_owner']['id']) and $contract['signed_by']['id'] == $value['id']) ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class='form-group row'>
                <label  for="txt-contract-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-12'>
                    <textarea class='form-control wysiwyg' rows="5"  name='description' id='txt-contract-description' placeholder='description' ><?= $contract['description'] ?></textarea>
                </div>
            </div>

            <?= files_upload("environment", "contract", $contract['id']); ?>

        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>
    CKEDITOR.replace('txt-contract-description');
</script>