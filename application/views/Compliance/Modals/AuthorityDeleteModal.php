
<?php $delete_link = base_url("index.php/Compliance/authorityDelete/{$data['authority']['id']}/true"); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Delete <span class="text-danger"><?= ucwords(str_replace("_", " ", $data['authority']['title'])) ?></span></h4>
        </div>
        <div class="modal-body">
            <p>Do you want to delete <strong><?= $data['authority']['title'] ?></strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= $delete_link ?>" <?= MODAL_AJAX ?>  class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->