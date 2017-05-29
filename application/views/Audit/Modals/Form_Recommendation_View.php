<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
<?php 
$recommendation = $data['recommendation'];
//print_pre($recommendation);
?>
<?= form_open_multipart("Audit/recommendationPost", array('id' => 'frm_recommendation_form', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Recommendation </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <input type='hidden' class='form-control'  name='id' id='txt-recommendation-id' value='<?= $recommendation['id'] ?>' />
                <input type='hidden' class='form-control'  name='issue' id='txt-issue-id' value='<?= $recommendation['issue'] ?>' />

                <div class='form-group'>
                        <label  for="txt-recommendation"  class='col-sm-12 form-control-label'>Recommendation</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg'  rows="10" name='recommendation' id='txt-recommendation' placeholder='recommendation' ><?= $recommendation['recommendation'] ?></textarea>
                        </div>
                    </div>

                <div class='form-group'>
                    <label  for="txt-issue-respond_by_date"  class='col-sm-12 form-control-label'>Respond By Date</label>
                    <div class='col-sm-12'>
                        <input type='date' class='form-control' name='respond_by_date'  id='txt-issue-respond_by_date' 
                               value='<?= strftime("%Y-%m-%d", strtotime($recommendation['respond_by_date'])) ?>' />
                    </div>
                </div>

            </div>

        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Cancel</button>
            <button type='submit' class='btn btn-primary waves-effect'>Save </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    CKEDITOR.replace('txt-recommendation');

</script>
<?= form_close(); ?>

