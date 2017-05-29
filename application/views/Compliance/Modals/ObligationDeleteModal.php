<?php $obligation = $data['obligation']?>
<div class="modal-dialog  modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Delete Obligation</h4>
        </div>
        <div class="modal-body">
            <p> Do you want to delete <strong class="text-danger"><?= $obligation['title']?></strong></p>
        </div>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= base_url("index.php/Compliance/obligationDelete/{$obligation['id']}/true");?>" class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->