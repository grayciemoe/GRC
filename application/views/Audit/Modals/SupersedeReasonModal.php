<?php 
$action_plan = $data['action_plan'];
?>                                          

<?= form_open_multipart("Audit/supersedeReasonPost", array('id' => 'frm_supersede_reason_form', 'class' => '')) ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4>Reason why the Action Plan has been superceded</h4>
            
        </div>
        <div class="modal-body">
            <input type="text" name="issue" value="<?= $action_plan['issue'] ?>" class="hidden"/>
            <input type="text" name="id" value="<?= $action_plan['id'] ?>" class="hidden"/>
            <div class='form-group row'>
                    <label  for='txt-supersede_reason'  class='col-sm-2 form-control-label'>Reasons</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control noresize' rows='2'  name='superseded_reasons' id='txt-supersede_reason' placeholder='reason' ></textarea>
                    </div>
                </div>
            
            
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type='submit'  class='btn btn-info-outline waves-effect waves-light pull-right'><i class='icon icon-save'></i> save</button>
            </div>
        </div>
        
    </div>
</div>
<?= form_close(); ?>


<script>
    CKEDITOR.replace('txt-supersede_reason');
</script>