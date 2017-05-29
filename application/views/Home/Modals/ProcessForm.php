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
            <input type='hidden' class='form-control'  name='repository_id' id='txt-best_practices-id' value='<?= $data['repository']['id'] ?>' />

            <input type='hidden' class='form-control'  name='id' id='txt-process-id' value='<?= $process['id'] ?>' />

            <div class='form-group row'>
                <label  for="txt-process-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-process-name' value='<?= $process['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-owner"  class='col-sm-2 form-control-label'>Owner</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='owner' id='txt-process-owner'> 
                        <option value=''>SELECT</option>
                        <?php foreach ($data['owners'] as $key => $value): ?>
                            <option value='' <?= $process['owner'] == $value['id'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-process-link"  class='col-sm-2 form-control-label'>Link</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='link' id='txt-process-link' value='<?= $process['link'] ?>' placeholder='link' />
                </div>
            </div>

            <div class='form-group row'>
                <label  for="txt-process-system_involved"  class='col-sm-2 form-control-label'>System Involved</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='system_involved' id='txt-process-system_involved' value='<?= $process['system_involved'] ?>' placeholder='system_involved' />
                </div>
            </div>

            <div class='form-group row'>
                <label  for="txt-process-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg' rows="5" name='description' id='txt-process-description' placeholder='description' ><?= $process['description'] ?></textarea>
                </div>
            </div>
            <?= files_upload("environment", "repository", $process['id']); ?>


        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>
    CKEDITOR.replace('txt-process-description');
</script>