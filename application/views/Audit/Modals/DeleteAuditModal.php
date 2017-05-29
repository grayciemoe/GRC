<?php 
$audit = $data['audit'];
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Delete Audit</h4>
        </div>
        <div class="modal-body">
            Do you want to delete audit <strong  class="text-danger"><?= $audit['audit_name'] ?>?</strong><br />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= base_url("index.php/Audit/deleteAudit/{$audit['id']}/true") ?>" 
               class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->