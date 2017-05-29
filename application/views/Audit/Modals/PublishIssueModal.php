<?php 
$issue = $data['issue'];
$reciepient = $data['reciepient'];
?>
<?= form_open_multipart("Audit/publishpost", array('id' => 'frm_publishIssue_form', 'class' => 'form-vertical')) ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Publish To <?= ($reciepient == 'ceo') ? 'CEO': ucwords($reciepient)  ?></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <input type='hidden' class='form-control'  name='issue' id='txt-recommendation-id' value='<?= $issue['id'] ?>' />
                <input type='hidden' class='form-control'  name='reciepient' id='txt-issue-id' value='<?= $reciepient ?>' />
                <div class="col-sm-12">
                    
                    <?php if($reciepient == 'management'):?>
                    Do you want to Publish Issue <strong  class="text-custom"><?= $issue['title'] ?></strong> to <?= ($reciepient == 'ceo') ? 'CEO': ucwords($reciepient)  ?> and expect response by: <br />
                    <div class='form-group'>
                    <label  for="txt-issue-respond_by_date"  class='col-sm-12 form-control-label'>Respond By Date</label>
                    <div class='col-sm-12'>
                        <input type='date' required class='form-control' name='respond_by_date'  id='txt-issue-respond_by_date' 
                               value='' />
                    </div>
                    
                </div>
                    <?php else:?>
                    Publish Issue <strong  class="text-custom"><?= $issue['title'] ?></strong> to <?= ($reciepient == 'ceo') ? 'CEO': ucwords($reciepient)  ?><br />
                    <div class='form-group'>
                    <label  for="txt-issue-respond_by_date"  class='col-sm-12 form-control-label'>Respond By Date <small class="text-muted">(Optional)</small></label>
                    <div class='col-sm-12'>
                        <input type='date'  class='form-control' name='respond_by_date'  id='txt-issue-respond_by_date' 
                               value='' />
                    </div>
                        <?php endif;?>
                </div>
            </div>
            
            
        </div>
        <div class="modal-footer">
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>No</button>
            <button type='submit' class='btn btn-primary waves-effect'>Yes </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
