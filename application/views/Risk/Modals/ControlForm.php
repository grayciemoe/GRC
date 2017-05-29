<?php
$control = $data['control'];
?>
<?= form_open_multipart("Risk/controlPost", array('id' => '', 'class' => '')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-control-id' value='<?= $control['id'] ?>' />

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Control </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <div class="col-sm-5">
                    <div class='form-group'>
                        <label  for="txt-control-title"  class='col-sm-12 form-control-label'>Title</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'   name='title'  required=''  id='txt-control-title' value='<?= $control['title'] ?>' placeholder='title' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control-intention"  class='col-sm-12 form-control-label'>Intention</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' required name='intention' id='txt-control-intention'> 
                                <option value='detect' <?= $control['intention'] == 'detect' ? "selected='selected'" : NULL; ?> > Detect </option>
                                <option value='prevent' <?= $control['intention'] == 'prevent' ? "selected='selected'" : NULL; ?> > Prevent </option>
                                <option value='correct' <?= $control['intention'] == 'correct' ? "selected='selected'" : NULL; ?> > Correct </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control-state"  class='col-sm-12 form-control-label'>State</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' required name='state' id='txt-control-state'> 
                                <option value='sufficient' <?= $control['state'] == 'sufficient' ? "selected='selected'" : NULL; ?> > Sufficient </option>
                                <option value='not sufficient' <?= $control['state'] == 'not sufficient' ? "selected='selected'" : NULL; ?> > Not Sufficient </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control-category"  class='col-sm-12 form-control-label'>Control Category</label>
                        <div class='col-sm-12'>

                            <select  class='form-control' required name='control_categories' id='txt-control-control_categories'> 
                                <option value=''>SELECT</option>
                                <?php foreach ($data['control_category'] as $key => $value): ?>
                                    <option value='<?= $value['id'] ?>' <?= $value['id'] == $control['control_categories'] ? "selected='selected'" : NULL; ?> > <?= $value['title'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control-criticality"  class='col-sm-12 form-control-label'>Criticality</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' required name='criticality' id='txt-control-criticality'> 
                                <option value='high' <?= $control['criticality'] == 'high' ? "selected='selected'" : NULL; ?> > High </option>
                                <option value='medium' <?= $control['criticality'] == 'medium' ? "selected='selected'" : NULL; ?> > Medium </option>
                                <option value='low' <?= $control['criticality'] == 'low' ? "selected='selected'" : NULL; ?> > Low </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control-owner"  class='col-sm-12 form-control-label'> Control Owner</label>
                        <div class='col-sm-12'>

                            <select  class='form-control select2' style="width: 100%" name='owner' required id='txt-control-owner'> 
                                <option value=''>SELECT</option>
                                <?php foreach ($data['owners'] as $key => $value): ?>
                                    <option value='<?= $value['id'] ?>' <?= $value['id'] == $control['owner'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-7">
                    <div class='form-group'>
                        <label  for="txt-control-description"  class='col-sm-12 form-control-label'>Description</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' required rows="16" name='description' id='txt-control-description' placeholder='description' ><?= $control['description'] ?></textarea>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-control-description');

    $(".select2").select2();


</script>