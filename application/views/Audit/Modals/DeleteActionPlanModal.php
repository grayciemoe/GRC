<?php 
$action_plan = $data['action_plan'];
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Delete Management Action Plan</h4>
        </div>
        <div class="modal-body">
            Do you want to delete management action plan <strong  class="text-danger"><?= $action_plan['action_plan'] ?>?</strong><br />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= base_url("index.php/Audit/deleteActionPlan/{$action_plan['id']}/true") ?>" 
               class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->