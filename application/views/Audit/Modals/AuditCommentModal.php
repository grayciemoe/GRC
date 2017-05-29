<?php 
// $audit_comment= $data['audit_comment'];
?>

<?= form_open_multipart("AuditComment/auditCommentPost", array('id' => 'frm_audit_comment_form', 'class' => '')) ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <?php if($data['auditor_manager']=='manager'): ?>
            <h4>Management Comment</h4>
            <?php else:?>
                <h4>Auditor's Comment</h4>
           <?php endif; ?>
            
        </div>
        <div class="modal-body">
            <input type="text" name="issue" value="<?= $data['issue'] ?>" hidden=""/>
            <input type="text" name="user_type" value="<?= $data['user_type'] ?>" hidden=""/>
            <div class='form-group row'>
                    <label  for='txt-audit_comment'  class='col-sm-2 form-control-label'>Comment</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control noresize' rows='2'  name='comment' id='txt-audit_comment' placeholder='Make A Comment' ></textarea>
                    </div>
                    
                </div>
            <?php if($data['auditor_manager']!='manager'): ?>
                 <div class='form-group row'>
                            <div class="col-sm-12 m-t-30">
                                <label>Want to include this <b>Auditors comment</b> to Audit Report?</label>
                                <div class="radio radio-info radio-inline m-l-5">
                                    <input  type="radio" required id="inlineRadio2" value="yes" name="auditor_comment_report" >
                                    <label for="inlineRadio2"> Yes </label>
                                </div>
                                <div class="radio radio-inline">
                                    <input  type="radio" required checked id="inlineRadio1" value="no" name="auditor_comment_report" >
                                    <label for="inlineRadio1"> No </label>
                                </div>
                            </div>
                        </div>
           <?php endif; ?>
            
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type='submit'  class='btn btn-info-outline waves-effect waves-light pull-right'><i class='icon icon-speech'></i> Post</button>
            </div>
        </div>
        
    </div>
</div>
<?= form_close(); ?>


<script>
    CKEDITOR.replace('txt-audit_comment');
</script>