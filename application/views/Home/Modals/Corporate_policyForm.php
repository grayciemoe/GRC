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
            <input type='hidden' class='form-control'  name='repository_id' id='txt-best_practices-id' value='<?= $data['repository']['id'] ?>' />
            <input type='hidden' class='form-control'  name='id' id='txt-corporate_policy-id' value='<?= $corporate_policy['id'] ?>' />

            <div class='form-group row'>
                <label  for="txt-corporate_policy-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' id='txt-corporate_policy-type'> 
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
                    <textarea class='form-control wysiwyg' rows="5"  name='description' id='txt-corporate_policy-description' placeholder='description' ><?= $corporate_policy['description'] ?></textarea>
                </div>
            </div>


            <?= files_upload("environment", "corporate_policy", $corporate_policy['id']); ?>


        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>
    CKEDITOR.replace('txt-corporate_policy-description');
</script>