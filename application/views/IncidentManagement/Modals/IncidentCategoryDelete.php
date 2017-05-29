<?php $delete_link = base_url("index.php/IncidentManagement/incidentCategoryDelete/{$data['incident_category']['id']}/true"); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Delete Control Category</h4>
        </div>
        <div class="modal-body">
            <p>Do you want to delete <strong><?= $data['incident_category']['title'] ?></strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= $delete_link ?>" <?= MODAL_AJAX ?>  class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->