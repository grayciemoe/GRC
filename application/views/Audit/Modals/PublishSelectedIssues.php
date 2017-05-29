<?php
/*
 *  Code By Alex
 *  Eat Code Sleep Repeat
 */
?>
<?php
$reciepient = $data['reciepient'];
?>
<?= form_open_multipart("Audit/publishSelectedIssues", array('id' => 'frm_publishAudit_form', 'class' => 'form-vertical')) ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Publish Selected Issues To <?= ucwords($reciepient) ?></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <input type='hidden' class='form-control'  name='reciepient' id='txt-audit-id' value='<?= $reciepient ?>' />
                <div class="col-sm-12">

                    <div class='form-group'>
                        <label  for="txt-audit-respond_by_date"  class='col-sm-12 form-control-label'>Respond By Date</label>
                        <div class='col-sm-12'>
                            <input type='date' min="<?php echo date("Y-m-d"); ?>" required class='form-control' name='respond_by_date'  id='txt-audit-respond_by_date' 
                                   value='' />
                        </div>

                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-primary waves-effect'>Publish </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

