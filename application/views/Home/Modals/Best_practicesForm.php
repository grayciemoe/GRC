<?php
$best_practices = $data['repository'][$data['repository']['source']];
echo form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => ''))
?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Best Practices </h4>
        </div>
        <div class='modal-body'>

            <?php // print_pre($data); ?>
            <input type='hidden' class='form-control'  name='repository_id' id='txt-best_practices-id' value='<?= $data['repository']['id'] ?>' />
            <input type='hidden' class='form-control'  name='id' id='txt-best_practices-id' value='<?= $best_practices['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-best_practices-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-best_practices-ref_code' value='<?= $best_practices['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-best_practices-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-best_practices-name' value='<?= $best_practices['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-best_practices-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-12'>
                    <textarea class='form-control wysiwyg' rows="10"  name='description' id='txt-best_practices-description' placeholder='description' ><?= $best_practices['description'] ?></textarea>
                </div>
            </div>
            <?= files_upload("environment", "best_practices", $best_practices['id']); ?>
        </div>
        <div class='modal-footer'>
            <div class="btn-group">
                <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-secondary waves-effect' >Save </button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-best_practices-description');
</script>