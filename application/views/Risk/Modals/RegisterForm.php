
<?php
$risk_register = $data['register'];

?>

<?= form_open_multipart("Risk/registerPost", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Risk Register </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-risk_register-id' value='<?= $risk_register['id'] ?>' />
            
            <div class='form-group row'>
                <label  for="txt-risk_register-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control '    name='title'  required=''  id='txt-risk_register-title' value='<?= $risk_register['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-risk_register-associated_business_goals"  class='col-sm-2 form-control-label'>Associated Business Goals</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg noresize' rows="3" name='associated_business_goals' id='txt-risk_register-associated_business_goals' placeholder='associated_business_goals' ><?= $risk_register['associated_business_goals'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-risk_register-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg noresize' rows="3"  name='description' id='txt-risk_register-description' placeholder='description' ><?= $risk_register['description'] ?></textarea>
                </div>
            </div>




        </div>
        <div class='modal-footer'>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>cancel</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-risk_register-associated_business_goals');
    CKEDITOR.replace('txt-risk_register-description');
    
</script>