

<?php $obligation_comply = $data['complies'] ?>
<?= form_open_multipart("Compliance/compliantPost", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Obligation Comply </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <div class="col-sm-6">
                    <input type='hidden' class='form-control'  name='id' id='txt-obligation_comply-id' value='<?= $obligation_comply['id'] ?>' />
                    <div class='form-group row'>
                        <label  for="txt-obligation_comply-title"  class='col-sm-2 form-control-label'>Title</label>
                        <div class='col-sm-12'>
                            <input type='text' readonly class='form-control'   name='title'  required=''  id='txt-obligation_comply-title' value='<?= $obligation_comply['title'] ?>' placeholder='title' />
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class='form-group row'>
                        <label  for="txt-obligation_comply-completion"  class='col-sm-2 form-control-label'>Completion</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'name='completion' id='txt-obligation_comply-completion'> 
                                <option value='fully' <?= $obligation_comply['completion'] == 'fully' ? "selected='selected'" : NULL; ?> > Fully </option>
                                <option value='partially' <?= $obligation_comply['completion'] == 'partially' ? "selected='selected'" : NULL; ?> >Partially </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">

                    <div class='form-group row'>
                        <label  for="txt-obligation_comply-description"  class='col-sm-2 form-control-label'>Description</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' rows="10" name='description' id='txt-obligation_comply-description' placeholder='description' ><?= $obligation_comply['description'] ?></textarea>
                        </div>
                    </div>
                    <label>Attach Evidence</label>
                    <?= files_upload("compliance","obligation_comply",$obligation_comply['id'])?>
                </div>
            </div>




        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>
    CKEDITOR.replace('txt-obligation_comply-description');
</script>